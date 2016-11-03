<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy@evarisk.com>
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
		add_shortcode( 'digi_dropdown_risk', array( $this, 'callback_dropdown_risk' ) );
	}

	/**
	* Affiches la liste des risques ainsi que le formulaire pour en ajouter
	*
	* @param array $param
	*/
	public function callback_digi_risk( $param ) {
		$element_id = !empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		risk_class::g()->display( $element_id );
	}

	public function callback_dropdown_risk( $param ) {
		$society_id = !empty( $param['society_id'] ) ? (int) $param['society_id'] : 0;
		$element_id = !empty( $param['element_id'] ) ? (int) $param['element_id'] : 0;
		$risk_id = !empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;

		$society = society_class::g()->show_by_type( $society_id, array( 'list_risk', 'evaluation' ) );

		require( RISK_VIEW_DIR . 'dropdown/list.view.php' );
	}
}

new risk_shortcode();
