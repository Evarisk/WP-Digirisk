<?php
/**
 * Gestion des shortcode des DUER.
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
 * DUER Shortcode class.
 */
class DUER_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since   6.2.1
	 */
	public function __construct() {
		add_shortcode( 'digi-list-duer', array( $this, 'callback_digi_list_duer' ) );
	}

	/**
	 * Appelle la méthode display de la classe Document_Unique_Class
	 *
	 * @since   6.2.1
	 *
	 * @param array $param Les paramètres du shortcode.
	 */
	public function callback_digi_list_duer( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		DUER_Class::g()->display( $element_id, array( DUER_Class::g()->get_type() ) );
	}
}

new DUER_Shortcode();
