<?php namespace digi;
/**
* todo
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package recommendation
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-recommendation', array( $this, 'callback_digi_recommendation' ) );
		add_shortcode( 'dropdown_recommendation', array( $this, 'callback_dropdown_recommendation' ) );
	}

	/**
	* Affiches le template pour lister les recommendations ainsi que le formulaire
	*
	* @param array $param
	*/
	public function callback_digi_recommendation( $param ) {
		$element_id = !empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		recommendation_class::g()->display( $element_id );
	}

	/**
	* Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	*
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	* @param string $param['display'] La méthode d'affichage pour le template
	*
	* @return bool
	*/
	public function callback_dropdown_recommendation( $param ) {
		$id = !empty( $param ) && !empty( $param['id'] ) ? $param['id'] : 0;

		$recommendation_category_list = recommendation_category_term_class::g()->get( array(), array( '\digi\recommendation_term' ) );
		$first_recommendation = max( $recommendation_category_list[0]->recommendation_term );

		$recommendation = array();

		$display = 'dropdown';

		if ( $id != 0 ) {
			$recommendation = recommendation_class::g()->get( array( 'include' => array( $id ) ), array( '\digi\recommendation_category_term', '\digi\recommendation_term' ) );
			$recommendation = $recommendation[0];
			$display = 'item-dropdown';
		}

		view_util::exec( 'recommendation', $display, array( 'recommendation' => $recommendation, 'id' => $id, 'first_recommendation' => $first_recommendation, 'recommendation_category_list' => $recommendation_category_list ) );
	}
}

new recommendation_shortcode();
