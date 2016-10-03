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
	}

	/**
	* Affiches le template pour lister les recommendations ainsi que le formulaire
	*
	* @param array $param
	*/
	public function callback_digi_recommendation( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		$list_recommendation_category = recommendation_category_class::g()->get();
		$list_recommendation_in_workunit = $element->associated_recommendation;
		view_util::exec( 'recommendation', 'list', array( 'element' => $element, 'element_id' => $element_id, 'list_recommendation_category' => $list_recommendation_category, 'list_recommendation_in_workunit' => $list_recommendation_in_workunit ) );
	}
}

new recommendation_shortcode();
