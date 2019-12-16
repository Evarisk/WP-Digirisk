<?php
/**
 * Gestion des actions des signatures
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.2
 * @copyright 2015-2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Gestion des signatures
 */
class Signature_Action {
	public function __construct() {
		add_action( 'wp_ajax_load_modal_signature', array( $this, 'load_modal_signature' ) );
		add_action( 'wp_ajax_digi_save_signature', array( $this, 'save_signature' ) );
	}

	public function load_modal_signature() {
		$id   = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$url  = ! empty( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : '';
		$key  = ! empty( $_POST['key'] ) ? sanitize_text_field( $_POST['key'] ) : '';
		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'signature', 'modal', array(
			'id'   => $id,
			'url'  => $url,
			'key'  => $key,
			'type' => $type,
		) );
		$modal_view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'signature', 'modal-button' );
		$buttons_view = ob_get_clean();
		wp_send_json_success( array(
			'view'         => $modal_view,
			'buttons_view' => $buttons_view,
		) );
	}

	public function save_signature() {
		check_ajax_referer( 'digi_save_signature' );

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$key            = ! empty( $_POST['key'] ) ? sanitize_text_field( $_POST['key'] ) : '';
		$type           = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : ''; // WPCS: input var ok.

		if ( empty( $id ) || empty( $signature_data ) ) {
			wp_send_json_error();
		}

		// Save signature.
		$signature_id = Signature::g()->save( $id, $key, $type, $signature_data );

		ob_start();
		\eoxia\View_Util::exec(
			'digirisk',
			'signature',
			'main',
			array(
				'id'           => $id,
				'signature_id' => $signature_id,
			)
		);

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'signature',
			'callback_success' => 'savedSignatureSuccess',
			'view'             => ob_get_clean(),
		) );
	}
}

new Signature_Action();
