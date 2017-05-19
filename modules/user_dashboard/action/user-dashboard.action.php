<?php
/**
 * Les actions relatives aux utilisateurs dans la page "utilisateur" de WordPress.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package user_dashboard
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux utilisateurs dans la page "utilisateur" de WordPress.
 */
class User_Shortcode_Action extends Singleton_Util {

	/**
	 * Le constructeur appelle les actions suivantes:
	 * admin_menu (Pour déclarer le sous menu dans le menu utilisateur de WordPress)
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	protected function construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );

		add_action( 'wp_ajax_save_user', array( $this, 'ajax_save_user' ) );
		add_action( 'wp_ajax_load_user', array( $this, 'ajax_load_user' ) );
		add_action( 'wp_ajax_delete_user', array( $this, 'ajax_delete_user' ) );
		add_action( 'wp_ajax_save_domain_mail', array( $this, 'ajax_save_domain_mail' ) );
	}

	/**
	 * Créer la page "Digirisk" dans le menu "Utilisateurs" de WordPress
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_admin_menu() {
		add_users_page( __( 'Utilisateurs DigiRisk', 'digirisk' ), __( 'Utilisateurs DigiRisk', 'digirisk' ), 'manage_digirisk', 'digirisk-users', array( $this, 'callback_users_page' ) );
	}

	/**
	 * Le callback de "add_users_page" qui permet d'afficher la vue pour le rendu de la page.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_users_page() {
		View_Util::exec( 'user_dashboard', 'main' );
	}

	/**
	 * Enregistres un utilisateur avec les paramètres reçu par le formulaire.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_save_user() {
		check_ajax_referer( 'ajax_save_user' );

		$error = false;
		$update_state = User_Digi_Class::g()->update( $_POST );

		$error = is_wp_error( $update_state->id );

		ob_start();
		User_Dashboard_Class::g()->display_list_user();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'userDashboard',
			'callback_success' => 'savedUserSuccess',
			'template' => ob_get_clean(),
			'error' => $error,
		) );
	}

	/**
	 * Charges un utilisateur et renvoie dans la réponse JSON la vue.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_load_user() {
		check_ajax_referer( 'ajax_load_user' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error( );
		} else {
			$id = (int) $_POST['id'];
		}

		$user = User_Digi_Class::g()->get( array( 'id' => $id ) );
		$user = $user[0];

		ob_start();
		View_Util::exec( 'user_dashboard', 'item-edit', array( 'user' => $user ) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'userDashboard',
			'callback_success' => 'loadedUserSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un utilisateur.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_delete_user() {
		check_ajax_referer( 'ajax_delete_user' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		User_Digi_Class::g()->delete( $id );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'userDashboard',
			'callback_success' => 'deletedUserSuccess',
		) );
	}

	/**
	 * Sauvegardes le domaine de l'email dans la page "Digirisk" dans le menu "Utilisateurs" de WordPress.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function ajax_save_domain_mail() {
		check_ajax_referer( 'save_domain_mail' );
		$domain_mail = ! empty( $_POST['domain_mail'] ) ? sanitize_text_field( $_POST['domain_mail'] ) : '';
		if ( '' === $domain_mail ) {
			wp_send_json_error();
		}

		update_option( 'digirisk_domain_mail', $domain_mail );

		wp_send_json_success();
	}
}

User_Shortcode_Action::g();
