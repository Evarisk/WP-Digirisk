<?php
/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les documents uniques d'un établissement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   6.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les documents uniques d'un établissement.
 */
class Evaluator_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since   6.0.0
	 * @version 6.0.0
	 */
	public function __construct() {
		add_shortcode( 'digi-evaluator', array( $this, 'callback_digi_evaluator' ) );
	}

	/**
	 * Affiches la page des evaluateurs
	 *
	 * @since   6.0.0
	 * @version 6.0.0
	 *
	 * @param array $param Description.
	 */
	public function callback_digi_evaluator( $param ) {
		$element_id = $param['post_id'];
		$element    = Society_Class::g()->show_by_type( $element_id );

		Evaluator_Class::g()->render( $element );
	}
}

new Evaluator_Shortcode();
