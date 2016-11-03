<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher le détail d'un utilisateur
*
* @author Jimmy Latour <jimmy@evarisk.com>
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
		user_shortcode_action::g()->callback_users_page();
	}
}

new user_dashboard_shortcode();
