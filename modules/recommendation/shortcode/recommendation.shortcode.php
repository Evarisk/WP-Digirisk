<?php namespace digi;
/**
* todo
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
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

		$recommendation_category_list = recommendation_category_class::g()->get( array(), array( 'recommendation' ) );
		$first_recommendation = max( $recommendation_category_list[0]->recommendation );

		view_util::exec( 'recommendation', 'dropdown', array( 'id' => $id, 'first_recommendation' => $first_recommendation, 'recommendation_category_list' => $recommendation_category_list ) );
	}
}

new recommendation_shortcode();
