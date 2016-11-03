<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class user_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-user', array( $this, 'callback_digi_user' ) );
		add_shortcode( 'digi_dropdown_user', array( $this, 'callback_dropdown_user' ) );
	}

	/**
	* Appelle la fonction render de \digi\user_class
	*
	* @param array $param
	*/
	public function callback_digi_user( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		user_digi_class::g()->render( $element );
	}

	public function callback_dropdown_user( $param ) {
		$element_id = !empty( $param['element_id'] ) ? (int) $param['element_id'] : 0;
		$user_id = !empty( $param['user_id'] ) ? (int) $param['user_id'] : 0;

		$list_user = \digi\user_class::g()->get();
		array_shift($list_user);

		require( USERS_VIEW . 'dropdown/list.view.php' );
	}
}

new user_shortcode();
