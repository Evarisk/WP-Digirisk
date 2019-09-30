<?php
/**
 * Gestion des actions des causeries pour la lecture.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Causerie Intervention Action Class.
 */
class Causerie_Intervention_Action {

	/**
	 * Constructeur.
	 */
	public function __construct() {
		add_action( 'wp_ajax_causerie_save_former', array( $this, 'callback_save_former' ) );
		add_action( 'wp_ajax_causerie_save_participant', array( $this, 'callback_causerie_save_participant' ) );
		add_action( 'wp_ajax_causerie_save_signature', array( $this, 'callback_causerie_save_signature' ) );
		add_action( 'wp_ajax_causerie_delete_participant', array( $this, 'callback_causerie_delete_participant' ) );
	}

	public function callback_save_former() {
		$id        = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$former_id = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$final_causerie->data['former']['user_id'] = $former_id;
		Causerie_Intervention_Class::g()->update( $final_causerie->data );

		wp_send_json_success();
	}

	/**
	 * Enregistre à participant à la causerie.
	 *
	 * @since   6.6.0
	 */
	public function callback_causerie_save_participant() {
		check_ajax_referer( 'causerie_save_participant' );

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		$final_causerie = Causerie_Intervention_Class::g()->add_participant( $final_causerie, $participant_id );
		$final_causerie = Causerie_Intervention_Class::g()->update( $final_causerie->data );

		Causerie_Intervention_Page_Class::g()->register_search( null, null );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4', array(
			'final_causerie' => $final_causerie,
			'all_signed'     => Causerie_Intervention_Page_Class::g()->check_all_signed( $final_causerie ),
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'savedParticipant',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Enregistres la signature d'un utilisateur.
	 *
	 * Puis renvoie la nouvelle ligne du tableau (HTML).
	 *
	 * @since   6.6.0
	 */
	public function callback_causerie_save_signature() {
		check_ajax_referer( 'causerie_save_signature' );

		$is_former      = ( isset( $_POST['is_former'] ) && 'true' === $_POST['is_former'] ) ? true : false; // WPCS: input var ok.
		$causerie_id    = ! empty( $_POST['causerie_id'] ) ? (int) $_POST['causerie_id'] : 0; // WPCS: input var ok.
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0; // WPCS: input var ok.
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : ''; // WPCS: input var ok.

		if ( $is_former ) {
			$participant_id = ! empty( $_POST['former_id'] ) ? (int) $_POST['former_id'] : 0;
		}

		if ( empty( $causerie_id ) || empty( $participant_id ) || empty( $signature_data ) ) {
			wp_send_json_error();
		}

		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $causerie_id ), true );
		$final_causerie = Causerie_Intervention_Class::g()->add_signature( $final_causerie, $participant_id, $signature_data, $is_former );

		$current_participant = null;

		$final_causerie = Causerie_Intervention_Class::g()->update( $final_causerie->data );

		ob_start();
		if ( ! $is_former ) {
			if ( ! empty( $final_causerie->data['participants'] ) ) {
				foreach ( $final_causerie->data['participants'] as $participant ) {
					if ( $participant_id === $participant['user_id'] ) {
						$current_participant = $participant;
						break;
					}
				}
			}

			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4-item', array(
				'participant'    => $current_participant,
				'final_causerie' => $final_causerie,
				'all_signed'     => Causerie_Intervention_Page_Class::g()->check_all_signed( $final_causerie ),
			) );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-1-signature', array(
				'final_causerie' => $final_causerie,
			) );
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => $is_former ? 'savedFormerSignature' : 'savedSignature',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un participant
	 *
	 * @since   6.6.0
	 */
	public function callback_causerie_delete_participant() {
		check_ajax_referer( 'causerie_delete_participant' );

		$id      = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$user_id = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		if ( empty( $user_id ) || empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie_intervention = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );
		Causerie_Intervention_Page_Class::g()->register_search( null, null );

		if ( empty( $causerie_intervention ) ) {
			wp_send_json_error();
		}

		if ( ! empty( $causerie_intervention->data['participants'] ) ) {
			foreach ( $causerie_intervention->data['participants'] as $key => $participant ) {
				if ( $user_id === $participant['user_id'] ) {
					unset( $causerie_intervention->data['participants'][ $key ] );
				}
			}
		}

		Causerie_Intervention_Class::g()->update( $causerie_intervention->data );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4', array(
			'final_causerie' => $causerie_intervention,
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'savedParticipant',
			'view'             => ob_get_clean(),
		) );
	}
}

new Causerie_Intervention_Action();
