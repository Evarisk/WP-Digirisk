<?php
/**
 * Gestion des actions pour gérer les modèles ODT personnalisés.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions pour gérer les modèles ODT personnalisés.
 */
class Handle_Model_Action {

	/**
	 * Le constructeur ajoutes le shortcode digi-handle-model
	 */
	public function __construct() {
		add_action( 'wp_ajax_set_model', array( $this, 'set_model' ) );
		add_action( 'wp_ajax_reset_default_model', array( $this, 'reset_default_model' ) );
		add_action( 'wp_ajax_view_historic_model', array( $this, 'view_historic_model' ) );
	}

	/**
	 * Appelle la méthode "upload_model" de "Handle_Model_Class"
	 *
	 * @since 6.2.1
	 */
	public function set_model() {
		// check_ajax_referer( 'associate_file' );
		//
		$type    = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : 0; // WPCS: input var ok.
		$file_id = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0; // WPCS: input var ok.

		$file_path = str_replace( '\\', '/', get_attached_file( $file_id ) );
		if ( ! Handle_Model_Class::g()->upload_model( $type, $file_path ) ) {
			wp_send_json_error();
		}

		ob_start();
		do_shortcode( '[digi-handle-model]' );
		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes la catégorie "default_model" au modèle par défault courant selon $_POST['type'] qui correspond au type de modèle.
	 *
	 * @since 6.2.3
	 */
	public function reset_default_model() {
		check_ajax_referer( 'reset_default_model' );

		$type  = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : ''; // WPCS: input var ok.
		$class = ! empty( $_POST['class'] ) ? sanitize_text_field( wp_unslash( $_POST['class'] ) ) : ''; // WPCS: input var ok.

		if ( empty( $type ) || empty( $class ) ) {
			wp_send_json_error();
		}

		// On récupères tous les posts qui correspond aux catégories "model" et $type.
		$tax_query = array(
			'relation' => 'AND',
		);

		$types = array( 'model', $type );

		if ( ! empty( $types ) ) {
			foreach ( $types as $element ) {
				$tax_query[] = array(
					'taxonomy' => Document_Class::g()->attached_taxonomy_type,
					'field'    => 'slug',
					'terms'    => $element,
				);
			}
		}

		$models = Document_Class::g()->get( array(
			'post_status' => 'inherit',
			'tax_query'   => $tax_query,
		) );

		if ( ! empty( $models ) ) {
			foreach ( $models as $element ) {
				wp_remove_object_terms( $element->data['id'], 'default_model', Document_Class::g()->attached_taxonomy_type );
			}
		}

		// On récupère le modèle officiel de DigiRisk.
		$model = $class::g()->get_default_model( array( $type, 'default_model', 'model' ) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'handleModel',
			'callback_success' => 'reset_default_model_success',
			'url'              => $model['url'],
			'type'             => $type,
		) );
	}

	/**
	 * Charges tous les posts qui contienne la catégorie "model" et "$type".
	 * $type correspond au type du modèle.
	 *
	 * @since 6.2.3
	 */
	public function view_historic_model() {
		check_ajax_referer( 'view_historic_model' );

		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : ''; // WPCS: input var ok.
		$type  = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : ''; // WPCS: input var ok.
		$class = ! empty( $_POST['class'] ) ? sanitize_text_field( wp_unslash( $_POST['class'] ) ) : ''; // WPCS: input var ok.

		$upload_dir = wp_upload_dir();

		if ( empty( $type ) ) {
			wp_send_json_error();
		}

		// Récupères le modèle par défaut actuel.
		$default_model      = $class::g()->get_default_model( array( $type, 'default_model', 'model' ) );
		$default_model_data = Document_Class::g()->get( array(
			'post_status' => 'inherit',
			'id'          => $default_model['id'],
		), true );

		if ( ! is_object( $default_model_data ) ) {
			$default_model_data = $default_model_data[0];
		}

		$default_model_data->data['url'] = $default_model['url'];

		// On récupères tous les posts qui correspond aux catégories "model" et $type.
		$tax_query = array(
			'relation' => 'AND',
		);

		$types = array( 'model', $type );

		if ( ! empty( $types ) ) {
			foreach ( $types as $element ) {
				$tax_query[] = array(
					'taxonomy' => Document_Class::g()->attached_taxonomy_type,
					'field'    => 'slug',
					'terms'    => $element,
				);
			}
		}

		$models = Document_Class::g()->get( array(
			'post_status' => 'inherit',
			'tax_query'   => $tax_query,
		) );

		if ( ! empty( $models ) ) {
			foreach ( $models as $element ) {
				$element->data['path'] = get_attached_file( $element->data['id'] );
				$element->data['url']  = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $element->data['path'] );
			}
		}

		array_unshift( $models, $default_model_data );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'handle_model', 'popup-list', array(
			'models' => $models,
		) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'handleModel',
			'callback_success' => 'loadedPopupHistoric',
			'title'            => $title,
			'view'             => ob_get_clean(),
		) );
	}
}

new Handle_Model_Action();
