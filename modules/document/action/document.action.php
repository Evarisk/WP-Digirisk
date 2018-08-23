<?php
/**
 * Les actions relatives au document.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2018 Evarisk
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
	 * @since 6.2.1
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_document', array( $this, 'ajax_generate_document' ) );
	}

	/**
	 * Re-génére un document a partir des données présentes en base de données
	 *
	 * @since 6.2.1
	 */
	public function ajax_generate_document() {
		$document_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$model_class = ! empty( $_POST['model'] ) ? sanitize_text_field( $_POST['model'] ) : '';
		$model_class = str_replace( 'digi/', '\digi\\', $model_class );

		$model_class::g()->create_document( $document_id );

		wp_send_json_success();
	}
}

new Document_Action();
