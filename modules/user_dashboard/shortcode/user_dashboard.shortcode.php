<?php
/**
* Ajoutes un shortcode qui permet d'afficher le détail d'un utilisateur
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class user_dashboard_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi_user_dashboard', array( $this, 'callback_digi_user_dashboard' ) );
	}

	public function callback_digi_user_dashboard( $param ) {
		$list_user = \digi\user_class::g()->get();
		array_shift( $list_user );
		require( USER_DASHBOARD_VIEW . 'main.view.php' );
	}
}

new user_dashboard_shortcode();
