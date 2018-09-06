<?php
/**
 * Gestion des shortcode des accidents et registre d'accident bénins.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Accident Shortcode class.
 */
class Accident_Shortcode {

	/**
	 * Ajoutes le shortcode digi-accident.
	 *
	 * @since 6.1.5
	 */
	public function __construct() {
		add_shortcode( 'digi-registre-accident', array( $this, 'callback_digi_registre_accident' ) );
		add_shortcode( 'digi-accident', array( $this, 'callback_digi_accident' ) );
	}

	/**
	 * Gestion du shortcode pour gérer le registre des accidents.
	 *
	 * Les attributs supportés sont 'post_id'
	 *
	 * @since 6.3.0
	 *
	 * @param array $param {
	 *     Les attibuts du shortcode.
	 *
	 *     @type integer $post_id L'ID du post.
	 * }
	 */
	public function callback_digi_registre_accident( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Registre_AT_Benin_Class::g()->display( $element_id, array( '\digi\Registre_AT_Benin_Class' ) );
	}

	/**
	 *
	 * Gestion du shortcode pour gérer les accidents.
	 *
	 * Les attributs supportés sont 'post_id'
	 *
	 * @since 6.3.0
	 *
	 * @param array $param {
	 *     Les attributs du shortcode.
	 *
	 *     @type integer $post_id L'ID du post.
	 * }
	 */
	public function callback_digi_accident( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Accident_Class::g()->display( $element_id );
	}
}

new Accident_Shortcode();
