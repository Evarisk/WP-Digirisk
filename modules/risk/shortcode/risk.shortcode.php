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
	public function __construct() {
		add_shortcode( 'digi-risk', array( $this, 'callback_digi_risk' ) );
	}

	public function callback_digi_risk( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::get()->show_by_type( $element_id );
		$list_risk = risk_class::get()->index( array( 'post__in' => $element->option['associated_risk'] ) );

		// Si l'établissement n'a pas de risque, on remet le tableau à 0
		if ( empty( $element->option['associated_risk'] ) ) {
			$list_risk = array();
		}

		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $key => $risk ) {
				$list_risk[$key] = risk_class::get()->get_risk( $risk->id );
			}
		}

		$term_evarisk_simple = get_term_by( 'slug', 'evarisk-simplified', evaluation_method_class::get()->get_taxonomy() );

		require( RISK_VIEW_DIR . '/list.view.php' );
	}
}

new risk_shortcode();
