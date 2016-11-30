<?php
/**
 * Ajoutes les shortcodes pour les préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package recommendation
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes les shortcodes pour les préconisations
 */
class Recommendation_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi-recommendation', array( $this, 'callback_digi_recommendation' ) );
		add_shortcode( 'dropdown_recommendation', array( $this, 'callback_dropdown_recommendation' ) );
	}

	/**
	 * Appelle la méthode display de Recommendation_Class
	 *
	 * @param  array $param Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_recommendation( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		recommendation_class::g()->display( $element_id );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 *
	 * @return void
	 */
	public function callback_dropdown_recommendation( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;

		$recommendation_category_list = recommendation_category_term_class::g()->get( array() );
		$first_recommendation = max( $recommendation_category_list[0]->recommendation_term );

		$recommendation = array();

		$display = 'dropdown';

		if ( 0 !== $id ) {
			$recommendation = recommendation_class::g()->get( array( 'post__in' => array( $id ) ) );
			$recommendation = $recommendation[0];
			$display = 'item-dropdown';
		}

		view_util::exec( 'recommendation', $display, array( 'recommendation' => $recommendation, 'id' => $id, 'first_recommendation' => $first_recommendation, 'recommendation_category_list' => $recommendation_category_list ) );
	}
}

new recommendation_shortcode();
