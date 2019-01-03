<?php
/**
 * Ajoutes un shortcode permettant d'afficher un commentaire d'un post n'importe ou.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes un shortcode permettant d'afficher un commentaire d'un post n'importe ou.
 */
class Digi_Comment_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.1
	 * @version 6.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi_comment', array( $this, 'callback_digi_comment' ) );
	}

	/**
	 * Appelle la méthode display de Digi_Comment_Class
	 *
	 * @param  array $param  Les paramètres du shortcode.
	 * @return void
	 *
	 * @since 6.2.1
	 * @version 6.4.0
	 */
	public function callback_digi_comment( $param ) {
		Digi_Comment_Class::g()->display( $param );
	}
}

new Digi_Comment_Shortcode();
