<?php
/**
 * Gestion des shortcodes en relation avec les accidents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.5
 * @version 6.1.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des shortcodes en relation avec les accidents.
 */
class Accident_Shortcode {

	/**
	 * Ajoutes le shortcode digi-accident.
	 *
	 * @since 6.1.5
	 * @version 6.1.5
	 */
	public function __construct() {
		add_shortcode( 'digi-registre-accident', array( $this, 'callback_digi_registre_accident' ) );
		add_shortcode( 'digi--accident', array( $this, 'callback_digi_accident' ) );
	}

	/**
	 *
	 * Gestion du shortcode pour gérer le registre des accidents.
	 *
	 * Les attributs supportés sont 'post_id'
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @param array $param {
	 *     Les attibuts du shortcode.
	 *
	 *     @type integer $post_id L'ID du post.
	 * }
	 *
	 * @return void
	 */
	public function callback_digi_registre_accident( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Accident_Class::g()->display_registre( $element_id );
	}

	/**
	 *
	 * Gestion du shortcode pour gérer les accidents.
	 *
	 * Les attributs supportés sont 'post_id'
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @param array $param {
	 *     Les attibuts du shortcode.
	 *
	 *     @type integer $post_id L'ID du post.
	 * }
	 *
	 * @return void
	 */
	public function callback_digi_accident( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Accident_Class::g()->display( $element_id );
	}
}

new Accident_Shortcode();
