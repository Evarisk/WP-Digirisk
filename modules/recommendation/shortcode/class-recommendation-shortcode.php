<?php
/**
 * Ajoutes les shortcodes pour les signalisations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.1
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation shortcode class.
 */
class Recommendation_Shortcode {

	/**
	 * Constructeur.
	 *
	 * @since   6.2.1
	 * @version 6.2.4
	 */
	public function __construct() {
		add_shortcode( 'digi-recommendation', array( $this, 'callback_digi_recommendation' ) );
		add_shortcode( 'dropdown_recommendation', array( $this, 'callback_dropdown_recommendation' ) );
	}

	/**
	 * Appelle la méthode display de Recommendation_Class
	 *
	 * @since   6.2.1
	 * @version 7.0.0
	 *
	 * @param  array $param Les paramètres du shortcode.
	 *
	 * @return void
	 */
	public function callback_digi_recommendation( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Recommendation::g()->display( $element_id );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @since   6.2.1
	 * @version 7.0.0
	 *
	 * @param array $param Tableau de donnée.
	 *
	 * @return void
	 */
	public function callback_dropdown_recommendation( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;

		$recommendation            = array();
		$recommendation_categories = Recommendation_Category::g()->get( array(
			'orderby' => 'term_id',
		) );

		$display = 'dropdown';

		if ( 0 !== $id ) {
			$recommendation = Recommendation::g()->get( array( 'id' => $id ), true );
			$display        = 'item-dropdown';
		}

		\eoxia\View_Util::exec( 'digirisk', 'recommendation', $display, array(
			'id'                        => $id,
			'recommendation'            => $recommendation,
			'recommendation_categories' => $recommendation_categories,
		) );
	}
}

new Recommendation_Shortcode();
