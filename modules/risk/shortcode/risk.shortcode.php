<?php
/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'une société.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'une société.
 */
class Risk_Shortcode {

	/**
	 * Ajoutes le shortcode digi_risk qui permet l'affichage de la liste des risques.
	 * Ajoutes le shortcode digi_dropdown_risk qui permet l'affichage de la toggle pour sélectionné la catégorie de risque.
	 */
	public function __construct() {
		add_shortcode( 'digi-risk', array( $this, 'callback_digi_risk' ) );
		add_shortcode( 'digi_dropdown_risk', array( $this, 'callback_dropdown_risk' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Risk_Class pour gérer le rendu de la liste des risques.
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	public function callback_digi_risk( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Risk_Class::g()->display( $element_id );
	}

	/**
	 * Appelle la vue pour afficher les catégories de risque.
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	public function callback_dropdown_risk( $param ) {
		$society_id = ! empty( $param['society_id'] ) ? (int) $param['society_id'] : 0;
		$element_id = ! empty( $param['element_id'] ) ? (int) $param['element_id'] : 0;
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;

		$society = Society_Class::g()->show_by_type( $society_id );

		require( RISK_VIEW_DIR . 'dropdown/list.view.php' );
	}
}

new Risk_Shortcode();
