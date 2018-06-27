<?php
/**
 * Gestion des actions lié à la page des utilisateurs de DigiRisk du menu "Utilisateurs" de WordPress.
 *
 * Ajoutes la page "digirisk-users".
 *
 * Gères les actions de sauvegardes, édition et suppression des utilisateurs.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.6
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * User Dashboard Action class.
 */
class User_Dashboard_Action extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.1.6
	 */
	protected function construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );

		add_action( 'wp_ajax_save_user', array( $this, 'ajax_save_user' ) );
		add_action( 'wp_ajax_load_user', array( $this, 'ajax_load_user' ) );
		add_action( 'wp_ajax_delete_user', array( $this, 'ajax_delete_user' ) );
	}

	/**
	 * Créer la page "Digirisk" dans le menu "Utilisateurs" de WordPress
	 *
	 * @since 6.1.6
	 */
	public function callback_admin_menu() {
		add_users_page( __( 'Utilisateurs DigiRisk', 'digirisk' ), __( 'Utilisateurs DigiRisk', 'digirisk' ), 'manage_digirisk', 'digirisk-users', array( $this, 'callback_users_page' ) );
	}

	/**
	 * Le callback de "add_users_page" qui permet d'afficher la vue pour le rendu de la page.
	 *
	 * @since 6.1.6
	 */
	public function callback_users_page() {
		$from_install = ( ! empty( $_GET['from_install'] ) && 'true' === $_GET['from_install'] ) ? true : false; // WPCS: input var ok, CSRF ok.

		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'main', array(
			'from_install' => $from_install,
		) );
	}

	/**
	 * Enregistres un utilisateur avec les paramètres reçu par le formulaire.
	 *
	 * @since 6.1.6
	 */
	public function ajax_save_user() {
		check_ajax_referer( 'ajax_save_user' );

		$id        = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$lastname  = ! empty( $_POST['lastname'] ) ? sanitize_text_field( wp_unslash( $_POST['lastname'] ) ) : ''; // WPCS: input var ok.
		$firstname = ! empty( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : ''; // WPCS: input var ok.
		$email     = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : ''; // WPCS: input var ok.

		if ( empty( $lastname ) || empty( $firstname ) || empty( $email ) ) {
			wp_send_json_error();
		}

		$user_args = array(
			'id'        => $id,
			'login'     => trim( strtolower( remove_accents( sanitize_user( $firstname . $lastname ) ) ) ),
			'password'  => wp_generate_password(),
			'lastname'  => $lastname,
			'firstname' => $firstname,
			'email'     => $email,
		);

		$update_state = User_Digi_Class::g()->update( $user_args );

		$error = is_wp_error( $update_state );

		ob_start();
		User_Dashboard_Class::g()->display_list_user();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'userDashboard',
			'callback_success' => 'savedUserSuccess',
			'template'         => ob_get_clean(),
			'error'            => $error,
			'object'           => $update_state,
		) );
	}

	/**
	 * Charges un utilisateur et renvoie dans la réponse JSON la vue.
	 *
	 * @since 6.1.6
	 */
	public function ajax_load_user() {
		check_ajax_referer( 'ajax_load_user' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$user = User_Digi_Class::g()->get( array( 'id' => $id ), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'item-edit', array( 'user' => $user ) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'userDashboard',
			'callback_success' => 'loadedUserSuccess',
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un utilisateur.
	 *
	 * @since 6.1.6
	 */
	public function ajax_delete_user() {
		check_ajax_referer( 'ajax_delete_user' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		wp_delete_user( $id );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'userDashboard',
			'callback_success' => 'deletedUserSuccess',
		) );
	}
}

User_Dashboard_Action::g();
