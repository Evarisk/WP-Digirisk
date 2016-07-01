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

class legal_display_shortcode {
	public function __construct() {
		add_shortcode( 'digi-legal_display', array( $this, 'callback_digi_legal_display' ) );
	}

	public function callback_digi_legal_display( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::get()->show_by_type( $element_id );

		legal_display_class::get()->display( $element );
	}
}

new legal_display_shortcode();
