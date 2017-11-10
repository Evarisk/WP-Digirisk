<?php
/**
 * Fichier de gestion des "actions" pour le module de mise à jour des données suite aux différentes version de l'extension
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de gestion des "actions" pour le module de mise à jour des données suite aux différentes version de l'extension
 */
class Update_Manager_Action {

	/**
	 * Instanciation de la classe de gestions des mises à jour des données suite aux différentes versions de l'extension
	 */
	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'automatic_update_redirect' ) );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );

		add_action( 'wp_ajax_digi_redirect_to_dashboard', array( $this, 'callback_digi_redirect_to_dashboard' ) );
	}

	/**
	 * On récupère la version actuelle de l'extension principale pour savoir si une mise à jour est nécessaire
	 * On regarde également si des mises à jour n'ont pas été faite suite à un suivi des mises à jours non régulier
	 */
	public function automatic_update_redirect() {
		$waiting_updates = get_option( '_digi_waited_updates', array() );
		$core_option = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( ! strpos( $_SERVER['REQUEST_URI'], 'admin-ajax.php' ) && ! empty( $core_option ) && ! empty( $core_option['installed'] ) ) {
			$current_version_to_check = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );
			$last_version_done = (int) get_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, 6260 );

			if ( 3 === strlen( $current_version_to_check ) ) {
				$current_version_to_check *= 10;
			}

			if ( $last_version_done !== $current_version_to_check ) {
				$update_path = \eoxia\Config_Util::$init['digirisk']->update_manager->path . 'update/';
				$update_data_path = \eoxia\Config_Util::$init['digirisk']->update_manager->path . 'data/';

				for ( $i = ( (int) substr( $last_version_done, 0, 4 ) + 1 ); $i <= $current_version_to_check; $i++ ) {
					if ( is_file( $update_data_path . 'update-' . $i . '-data.php' ) ) {
						require_once( $update_data_path . 'update-' . $i . '-data.php' );
						$waiting_updates[ $i ] = $datas;

						update_option( '_digi_waited_updates', $waiting_updates );
					}
				}
			}
		}
	}

	/**
	 * Ajoutes une page invisible qui vas permettre la gestion des mises à jour.
	 *
	 * @return void
	 *
	 * @since 6.2.8.0
	 * @version 6.2.8.0
	 */
	public function callback_admin_menu() {
		add_submenu_page( '', __( 'DigiRisk mise à jour', 'digirisk' ), __( 'DigiRisk mise à jour', 'digirisk' ), 'manage_options', 'digirisk-update', array( Update_Manager::g(), 'display' ) );
	}

	/**
	 * AJAX Callback - Return the website url
	 */
	public function callback_digi_redirect_to_dashboard() {
		$version = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );
		if ( 3 === strlen( $version ) ) {
			$version *= 10;
		}
		update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, $version );
		delete_option( '_digi_waited_updates' );
		wp_die( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) );
	}

}

new Update_Manager_Action();
