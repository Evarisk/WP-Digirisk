<?php
/**
 * Gestion des shortcodes en relation avec les causeries sécurité.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des shortcodes en relation avec les causeries sécurité.
 */
class Causerie_Shortcode {

	/**
	 * Ajoutes le shortcode digi-causerie.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_shortcode( 'digi-causerie', array( $this, 'callback_digi_causerie' ) );
	}

	/**
	 *
	 * Gestion du shortcode pour gérer les causeries sécurité.
	 *
	 * Les attributs supportés sont 'post_id'
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param array $param {
	 *     Les attibuts du shortcode.
	 *
	 *     @type integer $post_id L'ID du post.
	 * }
	 *
	 * @return void
	 */
	public function callback_digi_causerie( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Causerie_Class::g()->display( $element_id );
	}
}

new Causerie_Shortcode();
