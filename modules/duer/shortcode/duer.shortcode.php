<?php
/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les documents uniques d'un établissement.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
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
	 *
	 * @since 6.2.1
	 * @version 6.2.1
	 */
	public function __construct() {
		add_shortcode( 'digi-list-duer', array( $this, 'callback_digi_list_duer' ) );
	}

	/**
	 * Appelle la méthode display de la classe Document_Unique_Class
	 *
	 * @since 6.2.1
	 * @version 6.2.1
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
