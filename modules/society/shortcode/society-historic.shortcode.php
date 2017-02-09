<?php
/**
 * Les shortcodes relatif à l'historique des sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.6.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les shortcodes relatif aux options avancées d'une sociétés
 */
class Society_Historic_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi-historic', array( $this, 'callback_digi_historic' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Society_Historic_Class pour gérer le rendu.
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 6.2.6.0
	 * @version 6.2.6.0
	 */
	public function callback_digi_historic( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		$element = Society_Class::g()->show_by_type( $element_id );
		Society_Historic_Class::g()->display( $element );
	}
}

new Society_Historic_Shortcode();
