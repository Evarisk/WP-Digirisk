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
		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
	}

	/**
	 * La méthode qui gère la réponse de la requête.
	 * Cette méthode appelle la méthode generate de DUER_Generate_Class.
	 *
	 * @return void
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'callback_ajax_generate_duer' );
		$duer = DUER_Generate_Class::g()->generate( $_POST );
		wp_send_json_success( array( 'module' => 'group', 'callback_success' => 'callback_generate_duer_success', 'duer' => $duer ) );
	}
}

new DUER_Action();
