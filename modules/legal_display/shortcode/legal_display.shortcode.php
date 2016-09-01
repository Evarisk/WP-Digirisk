<?php
/**
* Ajoutes le formulaire pour générer l'affichage légal
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package legal_display
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-legal_display', array( $this, 'callback_digi_legal_display' ) );
	}

	/**
	* Appelle la fonction display de la class affichage légal
	*
	* @param array $param
	*/
	public function callback_digi_legal_display( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		legal_display_class::g()->display( $element );
	}
}

new legal_display_shortcode();
