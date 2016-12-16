<?php
/**
 * Gères l'action AJAX de la génération du DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action AJAX de la génération du DUER
 */
class DUER_Action {

	/**
	 * Le constructeur
	 */
	function __construct() {
		add_action( 'wp_ajax_display_societies_duer', array( $this, 'callback_display_societies_duer' ) );
		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
	}


	/**
	 * Appelle la méthode display_societies_tree de DUER_Class pour récupérer la vue dans la tamporisation de sortie.
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.3.0
	 */
	public function callback_display_societies_duer() {
		ob_start();
		View_Util::exec( 'duer', 'tree/main' );
		wp_send_json_success( array( 'module' => 'DUER', 'callback_success' => 'display_societies_duer_success', 'view' => ob_get_clean() ) );
	}

	/**
	 * La méthode qui gère la réponse de la requête.
	 * Cette méthode appelle la méthode generate de DUER_Generate_Class.
	 *
	 * @return void
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'callback_ajax_generate_duer' );
		$generate_response = DUER_Generate_Class::g()->generate( $_POST );

		$response = array(
			'module' => 'DUER',
			'number_document' => ! empty( $_POST['number_document'] ) ? $_POST['number_document'] : 0,
			'index' => ! empty( $_POST['index'] ) ? $_POST['index'] : 0,
			'end' => false,
		);

		if ( empty( $_POST['number_document'] ) ) {
			$response['number_document'] = Society_Class::g()->get_number_society_in( $_POST['element_id'] );
		}

		if ( $generate_response['success'] ) {
			$response['callback_success'] = 'callback_generate_duer_success';
			$response['index']++;

			if ( (int) $response['index'] === (int) $response['number_document'] ) {
				$response['end'] = true;
			}
		} else {
			$response['callback_error'] = 'callback_generate_duer_error';
		}

		wp_send_json_success( $response );
	}
}

new DUER_Action();
