<?php
/**
 * Gestion des actions pour les mises à jours.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.4.0
 * @version 1.4.0
 * @copyright 2015-2018 Eoxia
 * @package DigiRisk
 * @subpackage Update Manager
 */

namespace digirisk;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de gestion des "actions" pour le module de mise à jour des données suite aux différentes version de l'extension
 */
class Update_Manager_Action extends \eoxia\Update_Manager_Action {

	/**
	 * Instanciation de la classe de gestions des mises à jour des données suite aux différentes versions de l'extension
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( ! empty( $digirisk_core['installed'] ) ) {
			parent::__construct();
			add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
			add_action( 'wp_loaded', array( $this, 'automatic_update_redirect' ) );
			add_action( 'wp_ajax_digi_redirect_to_dashboard', array( $this, 'callback_digi_redirect_to_dashboard' ) );
		}
	}

	/**
	 * AJAX Callback - Return the website url
	 *
	 * @since 7.0.0
	 */
	public function callback_digi_redirect_to_dashboard() {
		$path_version = ! empty( $_POST['version'] ) ? (int) $_POST['version'] : 0;
		$version      = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );

		if ( 3 === strlen( $version ) ) {
			$version *= 10;
		}

		update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, $path_version );
		delete_option( \eoxia\Config_Util::$init['digirisk']->key_waiting_updates );

		$url = admin_url( 'admin.php?page=' . \eoxia\Config_Util::$init['digirisk']->dashboard_page_url );

		if ( is_multisite() ) {
			$sites = get_sites();

			if ( ! empty( $sites ) ) {
				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					$digirisk_core       = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );
					$last_update_version = get_option( '_digirisk_last_update_version', true );

					if ( (int) $version > (int) $last_update_version && ! empty( $digirisk_core['installed'] ) ) {
						delete_option( \eoxia\Config_Util::$init['digirisk']->key_waiting_updates );
						$this->automatic_update_redirect();
						$url = admin_url( 'admin.php?page=digirisk-update' );
						break;
					}
				}

				restore_current_blog();
			}
		}

		wp_send_json_success( array(
			'updateComplete'  => true,
			// Translators: 1. Start of link to dashboard 2. End of link to dashboard.
			'doneDescription' => sprintf( __( 'Vous allez être redirigé vers DigiRisk.. %1$sCliquez ici si rien ne se passe.%2$s', 'digirisk' ), '<a href="" >', '</a>' ),
			'url'             => $url,
		) );
	}

}

new Update_Manager_Action();
