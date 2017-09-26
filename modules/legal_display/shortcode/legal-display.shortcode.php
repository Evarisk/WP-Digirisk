<?php
/**
 * Les actions relatives aux affichages légaux.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package Digirisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux affichages légaux.
 */
class Legal_Display_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.4
	 */
	public function __construct() {
		add_shortcode( 'digi-legal_display', array( $this, 'callback_digi_legal_display' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @param array $param Les paramètres dans le shortcode.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function callback_digi_legal_display( $param ) {
		$element_id = $param['post_id'];
		$element = Society_Class::g()->get( array(
			'id' => $element_id,
		), true );

		Legal_Display_Class::g()->display( $element );
	}
}

new Legal_Display_Shortcode();
