<?php
/**
 * Gestion des shortcode des affichages légaux.
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
 * Legal Display Shortcode class.
 */
class Legal_Display_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_shortcode( 'digi-legal_display', array( $this, 'callback_digi_legal_display' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @param array $atts Les paramètres dans le shortcode.
	 *
	 * @since   6.0.0
	 */
	public function callback_digi_legal_display( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Legal_Display_Class::g()->display( $element_id, array( '\digi\Legal_Display_A3_Class', '\digi\Legal_Display_A4_Class' ), false );
		Legal_Display_Class::g()->display_form( $element_id );
	}
}

new Legal_Display_Shortcode();
