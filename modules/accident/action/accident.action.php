<?php
/**
 * Gestion des actions des accidents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
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
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function ajax_edit_accident() {
		check_ajax_referer( 'edit_accident' );

		$accident = ! empty( $_POST['accident'] ) ? (array) $_POST['accident'] : array();
		$signature_of_the_caregiver = ! empty( $_POST['signature_of_the_caregiver'] ) ? $_POST['signature_of_the_caregiver'] : '';
		$signature_of_the_victim = ! empty( $_POST['signature_of_the_victim'] ) ? $_POST['signature_of_the_victim'] : '';
		$accident_investigation = ! empty( $_POST['accident_investigation'] ) ? $_POST['accident_investigation'] : 0;
		$accident_stopping_days = ! empty( $_POST['accident_stopping_day'] ) ? (array) $_POST['accident_stopping_day'] : array();

		$add = isset( $_POST['add'] ) ? true : false;

		Accident_Travail_Stopping_Day_Class::g()->save_stopping_day( $accident_stopping_days );

		if ( ! empty( $accident['have_investigation'] ) ) {
			$accident['have_investigation'] = ( 'true' == $accident['have_investigation'] ) ? true : false;
		}

		$accident = Accident_Class::g()->update( $accident );
		$upload_dir = wp_upload_dir();

		// Associations des images.
		if ( ! empty( $signature_of_the_caregiver ) ) {
			$encoded_image = explode( ',', $signature_of_the_caregiver )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $accident->id );
			$accident->associated_document_id['signature_of_the_caregiver_id'][0] = $file_id;
		}

		if ( ! empty( $signature_of_the_victim ) ) {
			$encoded_image = explode( ',', $signature_of_the_victim )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $accident->id );
			$accident->associated_document_id['signature_of_the_victim_id'][0] = $file_id;
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

		$accident = Accident_Class::g()->update( $accident );

		if ( ! $add ) {
			do_action( 'generate_accident_benin', $accident->id );
		}

		do_action( 'digi_add_historic', array(
			'parent_id' => $accident->parent_id,
			'id'        => $accident->id,
			'content'   => 'Mise à jour de l\'accident ' . $accident->modified_unique_identifier,
		) );

		ob_start();
		if ( $add ) {
			\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-edit', array(
				'accident' => $accident,
			) );
		} else {
			Accident_Class::g()->display_accident_list();
		}
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'accident',
			'callback_success' => 'editedAccidentSuccess',
			'view'             => ob_get_clean(),
			'add'              => $add,
		) );
	}

	/**
	 * Charges un accident ainsi que ses images et la liste des commentaires.
	 *
	 * @since 6.3.0
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function ajax_load_accident() {
		check_ajax_referer( 'load_accident' );

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
			'id' => $id,
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
		check_ajax_referer( 'delete_accident' );

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
