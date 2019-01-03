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
		add_action( 'wp_ajax_load_user_details', array( $this, 'callback_load_user_details' ) );
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
		$from_install = ( ! empty( $_GET['from_install'] ) && 1 == $_GET['from_install'] ) ? true : false; // WPCS: input var ok, CSRF ok.

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

		$update_state = User_Class::g()->update( $user_args );

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

		$user = User_Class::g()->get( array( 'id' => $id ), true );

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

	/**
	 * Récupères les détails de l'utilisateur.
	 *
	 * @since 7.1.0
	 */
	public function callback_load_user_details() {
		check_ajax_referer( 'load_user_details' );
		$user_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $user_id ) ) {
			wp_send_json_error();
		}

		$user            = \eoxia\User_Class::g()->get( array( 'id' => $user_id ), true );
		$groups          = Group_Class::g()->get( array(
			'posts_per_page' => -1,
		) );
		$groups          = array_merge( $groups, Workunit_Class::g()->get( array(
			'posts_per_page' => -1,
		) ) );
		$affected_groups = array();

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				if ( ! empty( $group->data['user_info']['affected_id']['evaluator'] ) ) {
					foreach ( $group->data['user_info']['affected_id']['evaluator'] as $user_affected_id => $affected_info ) {
						if ( $user_affected_id === $user_id ) {
							$affected_groups[] = $group;
							break;
						}
					}
				}
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'user-detail/modal/main', array(
			'user'            => $user,
			'affected_groups' => $affected_groups,
		) );
		$view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'user-detail/modal/button' );
		$button_view = ob_get_clean();
		wp_send_json_success( array(
			'modal_title'  => 'Information de l\'utilisateur: ' . $user->data['displayname'],
			'view'         => $view,
			'buttons_view' => $button_view,
		) );
	}
}

User_Dashboard_Action::g();
