<?php
/**
 * Classe gérant les actions des fiches de groupement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Groupment Action class.
 */
class Sheet_Groupment_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_groupment
	 *
	 * @since 6.1.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_sheet_groupment', array( $this, 'ajax_generate_sheet_groupment' ) );
	}

	/**
	 * Appel la méthode "generate" de "Sheet_Groupment_Class" afin de générer la fiche de groupement.
	 *
	 * @since 6.1.0
	 */
	public function ajax_generate_sheet_groupment() {
		check_ajax_referer( 'generate_sheet_groupment' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		$society  = Society_Class::g()->show_by_type( $society_id );
		$response = Sheet_Groupment_Class::g()->prepare_document( $society );

		Sheet_Groupment_Class::g()->create_document( $response['document']->data['id'] );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'sheet_groupment',
			'callback_success' => 'generatedSheetGroupment',
			'data'             => $response,
		) );
	}
}

new sheet_groupment_action();
