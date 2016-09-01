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

class user_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-user', array( $this, 'callback_digi_user' ) );
	}

	/**
	* Appelle la fonction render de \digi\user_class
	*
	* @param array $param
	*/
	public function callback_digi_user( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		\digi\user_class::g()->render( $element );
	}
}

new user_shortcode();
