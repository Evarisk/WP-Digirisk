<?php
/**
 * Gestion des actions des causeries pour la lecture.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des causeries pour la lecture.
 */
class Causerie_Intervention_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_causerie_save_participant', array( $this, 'callback_causerie_save_participant' ) );
		add_action( 'wp_ajax_causerie_save_signature', array( $this, 'callback_causerie_save_signature' ) );
		add_action( 'wp_ajax_causerie_delete_participant', array( $this, 'callback_causerie_delete_participant' ) );
	}

	/**
	 * Enregistre à participant à la causerie.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function callback_causerie_save_participant() {
		check_ajax_referer( 'causerie_save_participant' );

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		$final_causerie = Causerie_Intervention_Class::g()->add_participant( $final_causerie, $participant_id );

		$final_causerie = Causerie_Intervention_Class::g()->update( $final_causerie );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3', array(
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
	 * Enregistre la signature d'un utilisateur et lui renvois la vue.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function callback_causerie_save_signature() {
		check_ajax_referer( 'causerie_save_signature' );

		$causerie_id    = ! empty( $_POST['causerie_id'] ) ? (int) $_POST['causerie_id'] : 0;
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0;
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : '';

		if ( empty( $causerie_id ) || empty( $participant_id ) || empty( $signature_data ) ) {
			wp_send_json_error();
		}

		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $causerie_id ), true );

		$final_causerie = Causerie_Intervention_Class::g()->add_signature( $final_causerie, $participant_id, $signature_data );

		$current_participant = null;

		$final_causerie = Causerie_Intervention_Class::g()->update( $final_causerie );

		if ( ! empty( $final_causerie->participants ) ) {
			foreach ( $final_causerie->participants as $participant ) {
				if ( $participant_id === $participant['user_id'] ) {
					$current_participant = $participant;
					break;
				}
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3-item', array(
			'participant'    => $current_participant,
			'final_causerie' => $final_causerie,
			'all_signed'     => Causerie_Intervention_Page_Class::g()->check_all_signed( $final_causerie ),
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'savedSignature',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_causerie_delete_participant() {
		check_ajax_referer( 'causerie_delete_participant' );

		$id      = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$user_id = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		if ( empty( $user_id ) || empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie_intervention = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		if ( empty( $causerie_intervention ) ) {
			wp_send_json_error();
		}

		if ( ! empty( $causerie_intervention->participants ) ) {
			foreach ( $causerie_intervention->participants as $key => $participant ) {
				if ( $user_id === $participant['user_id'] ) {
					unset( $causerie_intervention->participants[ $key ] );
				}
			}
		}

		Causerie_Intervention_Class::g()->update( $causerie_intervention );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3', array(
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
