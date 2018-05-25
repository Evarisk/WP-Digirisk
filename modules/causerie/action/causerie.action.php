<?php
/**
 * Gestion des actions des causeries.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des causeries
 */
class Causerie_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 * Il appelle également les actions ajax suivantes
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
		add_action( 'wp_ajax_edit_causerie', array( $this, 'ajax_edit_causerie' ) );
		add_action( 'wp_ajax_load_causerie', array( $this, 'ajax_load_causerie' ) );
		add_action( 'wp_ajax_delete_causerie', array( $this, 'ajax_delete_causerie' ) );
	}

	/**
	 * Ajoutes le sous menu 'Accidents'.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Causeries', 'digirisk' ), __( 'Causeries', 'digirisk' ), 'manage_digirisk', 'digirisk-causerie', array( Causerie_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	/**
	 * Sauvegardes un causerie ainsi que ses images et la liste des commentaires.
	 *
	 * @since 6.5.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function ajax_edit_causerie() {
		check_ajax_referer( 'edit_causerie' );

		$id               = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$title            = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$description      = ! empty( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
		$category_risk_id = ! empty( $_POST['risk']['danger_id'] ) ? (int) $_POST['risk']['danger_id'] : 0;
		$image_id         = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;

		$causerie = Causerie_Class::g()->update( array(
			'id'       => $id,
			'title'    => $title,
			'content'  => $description,
			'taxonomy' => array(
				'digi-category-risk' => $category_risk_id,
			),
		) );

		if ( ! empty( $image_id ) && empty( $causerie->thumbnail_id ) ) {
			$causerie->thumbnail_id                      = (int) $image_id;
			$causerie->associated_document_id['image'][] = (int) $image_id;
		}

		$causerie = Causerie_Class::g()->update( $causerie );

		ob_start();
		Causerie_Add_Class::g()->display();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'editedCauserieSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Charges un causerie ainsi que ses images et la liste des commentaires.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function ajax_load_causerie() {
		check_ajax_referer( 'ajax_load_causerie' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'add/item-edit', array(
			'causerie' => $causerie,
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'loadedCauserieSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Passes le status de l'causerie en "trash".
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function ajax_delete_causerie() {
		check_ajax_referer( 'ajax_delete_causerie' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $causerie ) ) {
			wp_send_json_error();
		}

		$causerie->status = 'trash';

		Causerie_Class::g()->update( $causerie );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'deletedAccidentSuccess',
		) );
	}
}

new Causerie_Action();
