<?php
/**
 * Gestion des actions des accidents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des accidents
 */
class Accident_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 * Il appelle également les actions ajax suivantes
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
		add_action( 'wp_ajax_edit_accident', array( $this, 'ajax_edit_accident' ) );
		add_action( 'wp_ajax_load_accident', array( $this, 'ajax_load_accident' ) );
		add_action( 'wp_ajax_delete_accident', array( $this, 'ajax_delete_accident' ) );
	}

	/**
	 * Ajoutes le sous menu 'Accidents'.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @return void
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Accidents', 'digirisk' ), __( 'Accidents', 'digirisk' ), 'manage_digirisk', 'digirisk-accident', array( Accident_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	/**
	 * Sauvegardes un accident ainsi que ses images et la liste des commentaires.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @return void
	 */
	public function ajax_edit_accident() {
		check_ajax_referer( 'edit_accident' );

		$name_and_signature_of_the_caregiver_id = ! empty( $_POST['name_and_signature_of_the_caregiver_id'] ) ? (int) $_POST['name_and_signature_of_the_caregiver_id'] : 0;
		$signature_of_the_victim_id = ! empty( $_POST['signature_of_the_victim_id'] ) ? (int) $_POST['signature_of_the_victim_id'] : 0;
		$accident_investigation_id = ! empty( $_POST['accident_investigation_id'] ) ? (int) $_POST['accident_investigation_id'] : 0;

		$accident = Accident_Class::g()->update( $_POST['accident'] );

		// Associations des images.
		if ( ! empty( $name_and_signature_of_the_caregiver_id ) ) {
			\eoxia\WPEO_Upload_Class::g()->associate_file( $accident->id, $name_and_signature_of_the_caregiver_id, '\digi\Accident_Class', 'name_and_signature_of_the_caregiver_id' );
		}
		if ( ! empty( $signature_of_the_victim_id ) ) {
			\eoxia\WPEO_Upload_Class::g()->associate_file( $accident->id, $signature_of_the_victim_id, '\digi\Accident_Class', 'signature_of_the_victim_id' );
		}

		if ( ! empty( $accident_investigation_id ) ) {
			\eoxia\WPEO_Upload_Class::g()->associate_file( $accident->id, $accident_investigation_id, '\digi\Accident_Class', 'accident_investigation_id' );
		}

		// Associations des commentaires.
		if ( ! empty( $_POST['list_comment'] ) ) {
			foreach ( $_POST['list_comment'] as $comment ) {
				if ( ! empty( $comment['content'] ) ) {
					$comment['post_id'] = $accident->id;
					\eoxia\Comment_Class::g()->update( $comment );
				}
			}
		}

		do_action( 'generate_accident_benin', $accident->id );

		do_action( 'digi_add_historic', array(
			'parent_id' => $accident->parent_id,
			'id' => $accident->id,
			'content' => 'Mise à jour de l\'accident ' . $accident->modified_unique_identifier,
		) );

		ob_start();
		Accident_Class::g()->display_accident_list();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'accident',
			'callback_success' => 'editedAccidentSuccess',
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * Charges un accident ainsi que ses images et la liste des commentaires.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @return void
	 */
	public function ajax_load_accident() {
		check_ajax_referer( 'ajax_load_accident' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$accident = Accident_Class::g()->get( array(
			'id' => $id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-edit', array(
			'main_society' => $main_society,
			'society_id' => $accident->parent_id,
			'accident' => $accident,
		) );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'accident',
			'callback_success' => 'loadedAccidentSuccess',
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * Passes le status de l'accident en "trash".
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @return void
	 */
	public function ajax_delete_accident() {
		check_ajax_referer( 'ajax_delete_accident' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$accident = Accident_Class::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $accident ) ) {
			wp_send_json_error();
		}

		$accident->status = 'trash';

		Accident_Class::g()->update( $accident );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'accident',
			'callback_success' => 'deletedAccidentSuccess',
		) );
	}
}

new Accident_Action();
