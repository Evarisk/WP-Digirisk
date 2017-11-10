<?php
/**
 * Les actions relatives au document.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives au document.
 */
class Document_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_regenerate_document', array( $this, 'ajax_regenerate_document' ) );
	}

	/**
	 * Re-génére un document a partir des données présentes en base de données
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	function ajax_regenerate_document() {
		check_ajax_referer( 'regenerate_document' );

		$model_name = ! empty( $_POST['model_name'] ) ? sanitize_text_field( $_POST['model_name'] ) : '';
		if ( empty( $model_name ) ) {
			wp_send_json_error();
		}
		$tmp_name = $model_name;
		$model_name = '\digi\\' . $model_name . '_class';

		$document_id = ! empty( $_POST ) && is_int( (int) $_POST['element_id'] ) && ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		if ( ! empty( $document_id ) ) {
			$parent_id = ! empty( $_POST ) && is_int( (int) $_POST['parent_id'] ) && ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
			$parent_element = Society_Class::g()->show_by_type( $parent_id );

			$current_document = $model_name::g()->get( array(
				'id' => $document_id,
			) );
			$response = Document_Class::g()->generate_document( $current_document[0]->model_id, $current_document[0]->document_meta, $parent_element->type . '/' . $parent_id . '/' . $current_document[ 0 ]->title . '.odt' );
			wp_send_json_success( $response );
		} else {
			wp_send_json_error( array( 'message' => __( 'No document has been selected', 'digirisk' ), ) );
		}

		wp_send_json_error( array( 'message' => __( 'An error occured while trying to generate the document', 'digirisk' ), ) );
	}
}

new Document_Action();
