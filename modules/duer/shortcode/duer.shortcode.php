<?php
/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les documents uniques d'un établissement.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 0.1
 * @copyright 2015-2016 Eoxia
 * @package document
 * @subpackage shortcode
 */

namespace digi;



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les documents d'un établissement.
 */
class DUER_Shortcode {
	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_list_duer', array( $this, 'callback_digi_list_duer' ) );
	}

	/**
	 * Appelle la méthode display de la classe Document_Unique_Class
	 *
	 * @param array $param Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_list_duer( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		DUER_Class::g()->display( $element_id );
	}
}

new DUER_Shortcode();
