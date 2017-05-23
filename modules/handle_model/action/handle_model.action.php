<?php
/**
 * Gestion des actions pour gérer les modèles personnalisés
 *
 * @since 6.2.3.0
 * @version 6.2.9.0
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des actions pour gérer les modèles personnalisés
 */
class Handle_Model_Action {

	/**
	 * Le constructeur ajoutes le shortcode digi-handle-model
	 */
	public function __construct() {
		add_action( 'wp_ajax_reset_default_model', array( $this, 'reset_default_model' ) );
		add_action( 'wp_ajax_view_historic_model', array( $this, 'view_historic_model' ) );
	}

	/**
	 * Supprimes la catégorie "default_model" au modèle par défault courant selon $_POST['type'] qui correspond au type de modèle.
	 *
	 * @since 6.2.3.0
	 * @version 6.2.9.0
	 *
	 * @return void
	 */
	public function reset_default_model() {
		check_ajax_referer( 'reset_default_model' );

		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';

		if ( empty( $type ) ) {
			wp_send_json_error();
		}

		// On récupères tous les posts qui correspond aux catégories "model" et $type.
		$tax_query = array( 'relation' => 'AND' );
		$types = array( 'model', $type );

		if ( ! empty( $types ) ) {
			foreach ( $types as $element ) {
				$tax_query[] = array(
					'taxonomy' => document_class::g()->attached_taxonomy_type,
					'field'			=> 'slug',
					'terms'			=> $element,
				);
			}
		}

		$models = Document_Class::g()->get( array(
			'post_status' => 'inherit',
			'tax_query' => $tax_query,
		) );

		if ( ! empty( $models ) ) {
			foreach ( $models as $element ) {
				wp_remove_object_terms( $element->id, 'default_model', Document_Class::g()->attached_taxonomy_type );
			}
		}

		// On récupère le modèle officiel de DigiRisk.
		$model = Document_Class::g()->get_model_for_element( array( $type, 'default_model', 'model' ) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'handleModel',
			'callback_success' => 'reset_default_model_success',
			'url' => $model['model_url'],
			'type' => $type,
		) );
	}

	/**
	 * Charges tous les posts qui contienne la catégorie "model" et "$type".
	 * $type correspond au type du modèle.
	 *
	 * @since 6.2.3.0
	 * @version 6.2.9.0
	 *
	 * @return void
	 */
	public function view_historic_model() {
		check_ajax_referer( 'view_historic_model' );

		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		$upload_dir = wp_upload_dir();

		if ( empty( $type ) ) {
			wp_send_json_error();
		}

		// Récupères le modèle par défaut actuel.
		$default_model = Document_Class::g()->get_model_for_element( array( $type, 'default_model', 'model' ) );
		$default_model_data = Document_Class::g()->get( array( 'post_status' => 'inherit', 'post__in' => array( $default_model['model_id'] ) ) );
		$default_model_data = $default_model_data[0];
		$default_model_data->url = $default_model['model_url'];

		// On récupères tous les posts qui correspond aux catégories "model" et $type.
		$tax_query = array( 'relation' => 'AND' );
		$types = array( 'model', $type );

		if ( ! empty( $types ) ) {
			foreach ( $types as $element ) {
				$tax_query[] = array(
					'taxonomy' => document_class::g()->attached_taxonomy_type,
					'field'			=> 'slug',
					'terms'			=> $element,
				);
			}
		}

		$models = Document_Class::g()->get( array( 'post_status' => 'inherit', 'tax_query' => $tax_query ) );

		if ( ! empty( $models ) ) {
			foreach ( $models as $element ) {
				$element->path = get_attached_file( $element->id );
				$element->url = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $element->path );
			}
		}

		array_unshift( $models, $default_model_data );

		ob_start();
		View_Util::exec( 'handle_model', 'popup-list', array(
			'models' => $models,
		) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'handleModel',
			'callback_success' => 'loadedPopupHistoric',
			'title' => $title,
			'view' => ob_get_clean(),
		) );
	}
}

new Handle_Model_Action();
