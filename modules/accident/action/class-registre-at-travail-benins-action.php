<?php
/**
 * Classe gérant les actions des registres des AT bénins.
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
 * Registre Accident Travail Benin Action class.
 */
class Registre_Accident_Travail_Benin_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_registre_accidents_travail_benins
	 *
	 * @since 6.3.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_registre_at_benin', array( $this, 'ajax_generate_registre_at_benin' ) );
	}

	/**
	 * Appel la méthode "generate" de "Accident_Travail_Benin" afin de générer l'accident de travail bénin (ODT).
	 *
	 * @since 6.3.0
	 *
	 * @return void
	 */
	public function ajax_generate_registre_at_benin() {
		check_ajax_referer( 'generate_registre_at_benin' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		$society  = Society_Class::g()->show_by_type( $society_id );
		$response = Registre_AT_Benin_Class::g()->prepare_document( $society );

		Registre_AT_Benin_Class::g()->create_document( $response['document']->data['id'] );

		do_action( 'digi_add_historic', array(
			'parent_id' => $society_id,
			'id'        => $response['document']->data['id'],
			'content'   => sprintf( __( 'Generation of minor work accidents register %s', 'digirisk' ), $response['document']->data['unique_identifier'] ),
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'accident',
			'callback_success' => 'generatedRegistreATBenin',
			'data'             => $response,
		) );
	}
}

new Registre_Accident_Travail_Benin_Action();
