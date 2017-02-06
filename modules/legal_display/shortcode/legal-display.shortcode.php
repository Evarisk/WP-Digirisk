<?php
/**
 * Les actions relatives aux affichages légaux.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux affichages légaux.
 */
class Legal_Display_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi-legal_display', array( $this, 'callback_digi_legal_display' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @param array $param Les paramètres dans le shortcode.
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_digi_legal_display( $param ) {
		$element_id = $param['post_id'];
		$element = Society_Class::g()->show_by_type( $element_id );

		Legal_Display_Class::g()->display( $element );
	}
}

new Legal_Display_Shortcode();
