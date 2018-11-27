<?php
/**
 * Classe gérant les actions des fiches de poste.
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
 * Sheet Workunit Action class.
 */
class Sheet_Workunit_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_workunit
	 *
	 * @since 6.2.1
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_sheet_workunit', array( $this, 'ajax_generate_sheet_workunit' ) );
	}

	/**
	 * Appelle la méthode generate de Fiche_De_Poste_Class
	 *
	 * @since 6.2.1
	 */
	public function ajax_generate_sheet_workunit() {
		check_ajax_referer( 'generate_sheet_workunit' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		$society  = Society_Class::g()->show_by_type( $society_id );
		$response = Sheet_Workunit_Class::g()->prepare_document( $society );

		Sheet_Workunit_Class::g()->create_document( $response['document']->data['id'] );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'sheet_workunit',
			'callback_success' => 'generatedFicheDePosteSuccess',
			'data'             => $response,
		) );
	}

}

new Sheet_Workunit_Action();
