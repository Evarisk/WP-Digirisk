<?php
/**
 * Ajoutes les shortcodes pour les recommendations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes les shortcodes pour les recommendations
 */
class Recommendation_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.1
	 * @version 6.2.4
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
	 *
	 * @since 6.2.1
	 * @version 6.2.4
	 */
	public function callback_digi_recommendation( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Recommendation_Class::g()->display( $element_id );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 *
	 * @return void
	 *
	 * @since 6.2.1
	 * @version 6.5.0
	 */
	public function callback_dropdown_recommendation( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;

		$recommendation               = array();
		$recommendation_category_list = Recommendation_Category_Term_Class::g()->get();

		$display = 'dropdown';

		if ( 0 !== $id ) {
			$recommendation = Recommendation_Class::g()->get( array( 'id' => $id ), true );
			$display        = 'item-dropdown';
		}

		\eoxia\View_Util::exec( 'digirisk', 'recommendation', $display, array(
			'recommendation'               => $recommendation,
			'id'                           => $id,
			'recommendation_category_list' => $recommendation_category_list,
		) );
	}
}

new Recommendation_Shortcode();
