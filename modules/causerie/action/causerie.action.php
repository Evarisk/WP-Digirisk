<?php
/**
 * Gestion des actions des causeries.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.5.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
		add_action( 'wp_ajax_edit_causerie', array( $this, 'ajax_edit_causerie' ) );
		add_action( 'wp_ajax_load_edit_causerie', array( $this, 'ajax_load_edit_causerie' ) );
		add_action( 'wp_ajax_delete_causerie', array( $this, 'ajax_delete_causerie' ) );
	}

	/**
	 * Sauvegardes un causerie ainsi que ses images et la liste des commentaires.
	 *
	 * Appelle la méthode "generate" de "Sheet_Causerie_Class" afin de générer l'ODT.
	 *
	 * @since   6.6.0
	 */
	public function ajax_edit_causerie() {
		check_ajax_referer( 'edit_causerie' );

		$id               = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$title            = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$description      = ! empty( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
		$category_risk_id = ! empty( $_POST['risk_category_id'] ) ? (int) $_POST['risk_category_id'] : 0;
		$image_id         = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;

		$causerie = Causerie_Class::g()->update( array(
			'id'       => $id,
			'title'    => $title,
			'content'  => $description,
			'taxonomy' => array(
				'digi-category-risk' => array( $category_risk_id ),
			),
		) );

		if ( ! empty( $image_id ) && empty( $causerie->data['thumbnail_id'] ) ) {
			$causerie->data['thumbnail_id']                      = (int) $image_id;
			$causerie->data['associated_document_id']['image'][] = (int) $image_id;
		}

		Causerie_Class::g()->update( $causerie->data );

		// Sheet_Causerie_Class::g()->generate( $causerie->data['id'] );

		ob_start();
		Causerie_Page_Class::g()->display_form();
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
	 * @since   6.6.0
	 */
	public function ajax_load_edit_causerie() {
		check_ajax_referer( 'ajax_load_edit_causerie' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		$causerie->data['risk_category'] = Risk_Category_Class::g()->get( array(
			'id' => end( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ),
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/item-edit', array(
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
	 * @since   6.6.0
	 */
	public function ajax_delete_causerie() {
		check_ajax_referer( 'ajax_delete_causerie' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $causerie ) ) {
			wp_send_json_error();
		}

		$causerie->data['status'] = 'trash';

		Causerie_Class::g()->update( $causerie->data );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'deletedAccidentSuccess',
		) );
	}
}

new Causerie_Action();
