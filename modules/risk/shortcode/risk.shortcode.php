<?php
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-risk', array( $this, 'callback_digi_risk' ) );
	}

	/**
	* Affiches la liste des risques ainsi que le formulaire pour en ajouter
	*
	* @param array $param
	*/
	public function callback_digi_risk( $param ) {
		$element_id = !empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		risk_class::get()->display_risk_list( $element_id );
		return true;
	}
}

new risk_shortcode();
