<?php
/**
 * Les shortcodes relatif aux options avancées d'une sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les shortcodes relatif aux options avancées d'une sociétés
 */
class Society_Advanced_Options_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi-advanced-options', array( $this, 'callback_digi_advanced_options' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Society_Advanced_Options pour gérer le rendu.
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function callback_digi_advanced_options( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		$element = Society_Class::g()->show_by_type( $element_id );
		Society_Advanced_Options_Class::g()->display( $element );
	}
}

new Society_Advanced_Options_Shortcode();
