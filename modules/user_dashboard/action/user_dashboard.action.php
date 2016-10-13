<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_shortcode_action extends singleton_util {
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
		$user = user_digi_class::g()->get( array( 'schema' => true ) );
		$user = $user[0];
		view_util::exec( 'user_dashboard', 'main', array( 'user' => $user ) );
	}

	public function ajax_save_user() {
		check_ajax_referer( 'ajax_save_user' );

		if ( !empty( $_POST['user'] ) ) {
		  foreach ( $_POST['user'] as $element ) {
				user_digi_class::g()->update( $element );
		  }
		}

		ob_start();
		user_dashboard_class::g()->display_list_user();
		$user = user_digi_class::g()->get( array( 'schema' => true ) );
		$user = $user[0];

		view_util::exec( 'user_dashboard', 'item-edit', array( 'user' => $user ) );
		wp_send_json_success( array( 'module' => 'user_dashboard', 'callback_success' => 'save_user_success', 'template' => ob_get_clean() ) );
	}

	public function ajax_load_user() {
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( );
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_load_user_' . $id );

		$user = user_digi_class::g()->get( array( 'id' => $id ) );
		$user = $user[0];

		ob_start();
		view_util::exec( 'user_dashboard', 'item-edit', array( 'user' => $user ) );
		wp_send_json_success( array( 'module' => 'user_dashboard', 'callback_success' => 'load_success', 'template' => ob_get_clean() ) );
	}

	public function ajax_delete_user() {
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error();
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_delete_user_' . $id );

		user_digi_class::g()->delete( $id );
		wp_send_json_success( array( 'module' => 'user_dashboard', 'callback_success' => 'delete_success' ) );
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
