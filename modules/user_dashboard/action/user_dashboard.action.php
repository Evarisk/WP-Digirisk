<?php

if ( !defined( 'ABSPATH' ) ) exit;

class user_shortcode_action extends \singleton_util {
	/**
	* Le constructeur appelle les actions suivantes:
	* admin_menu (Pour déclarer le sous menu dans le menu utilisateur de WordPress)
	*/
	protected function construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );

		add_action( 'wp_ajax_save_user', array( $this, 'ajax_save_user' ) );
		add_action( 'wp_ajax_load_user', array( $this, 'ajax_load_user' ) );
		add_action( 'wp_ajax_delete_user', array( $this, 'ajax_delete_user' ) );
		add_action( 'wp_ajax_save_domain_mail', array( $this, 'ajax_save_domain_mail' ) );
	}

	/**
	* Créer le sous menu dans le menu utilisateur de WordPress
	*/
	public function callback_admin_menu() {
		add_users_page( __( 'Digirisk', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'read', 'digirisk-users', array( $this, 'callback_users_page' ) );
	}

	public function callback_users_page() {
		$user = \digi\user_class::g()->get( array( 'schema' => true ) );
		$user = $user[0];
		require( USER_DASHBOARD_VIEW . 'main.view.php' );
	}

	public function ajax_save_user() {
		check_ajax_referer( 'ajax_save_user' );

		$user = \digi\user_class::g()->update( $_POST['user'] );

		ob_start();
		require( USER_DASHBOARD_VIEW . '/item.view.php' );
		wp_send_json_success( array( 'template' => ob_get_clean(), 'id' => $user->id ) );
	}

	public function ajax_load_user() {
		if ( 0 === (int)$_POST['user_id'] )
			wp_send_json_error( );
		else
			$user_id = (int)$_POST['user_id'];

		check_ajax_referer( 'ajax_load_user_' . $user_id );

		$user = user_class::g()->get( array( 'id' => $user_id ) );
		$user = $user[0];

		ob_start();
		require( USER_DASHBOARD_VIEW . '/item-edit.view.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_delete_user() {
		if ( 0 === (int)$_POST['user_id'] )
			wp_send_json_error();
		else
			$user_id = (int)$_POST['user_id'];

		check_ajax_referer( 'ajax_delete_user_' . $user_id );

		user_class::g()->delete( $user_id );
		wp_send_json_success();
	}

	public function ajax_save_domain_mail() {
		check_ajax_referer( 'save_domain_mail' );
		$domain_mail = !empty( $_POST['domain_mail'] ) ? sanitize_text_field( $_POST['domain_mail'] ) : '';
		if ( $domain_mail === '' ) {
			wp_send_json_error();
		}
		update_option( 'digirisk_domain_mail', $domain_mail );
		wp_send_json_success();
	}
}

user_shortcode_action::g();
