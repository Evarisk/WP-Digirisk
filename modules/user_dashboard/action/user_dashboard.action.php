<?php

if ( !defined( 'ABSPATH' ) ) exit;

class user_shortcode_action extends \singleton_util {
	/**
	* Le constructeur appelle les actions suivantes:
	* admin_menu (Pour déclarer le sous menu dans le menu utilisateur de WordPress)
	*/
	protected function construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );
	}

	/**
	* Créer le sous menu dans le menu utilisateur de WordPress
	*/
	public function callback_admin_menu() {
		add_users_page( __( 'Digirisk', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'read', 'digirisk-users', array( $this, 'callback_users_page' ) );
	}

	public function callback_users_page() {
		$list_user = \digi\user_class::g()->get();
		array_shift( $list_user );
		echo $list_user[1];
		require( USER_DASHBOARD_VIEW . 'main.view.php' );
	}
}

user_shortcode_action::g();
