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
		add_action( 'wp_loaded', array( $this, 'check_update' ) );
	}

	/**
	 * On récupère la version actuelle de l'extension principale pour savoir si une mise à jour est nécessaire
	 * On regarde également si des mises à jour n'ont pas été faite suite à un suivi des mises à jours non régulier
	 */
	public function check_update() {
		$current_version_to_check = (int) str_replace( '.', '', Config_Util::$init['digirisk']->version );
		$last_version_done = (int) get_option( Config_Util::$init['digirisk']->key_last_update_version, 6260 );
		$update_final_path = PLUGIN_DIGIRISK_PATH . Config_Util::$init['update-manager']->path . 'class/';

		if ( $last_version_done !== $current_version_to_check ) {
			for ( $i = $last_version_done; $i <= $current_version_to_check; $i++ ) {
				if ( is_file( $update_final_path . 'update-' . $i . '.php' ) ) {
					global $wpdb;
					require_once( $update_final_path . 'update-' . $i . '.php' );
					log_class::g()->exec( 'digirisk-update-manager', '', 'Update version ' . $i . ' done.', array() );
				}
			}
		}

		update_option( Config_Util::$init['digirisk']->key_last_update_version, $current_version_to_check );
	}

}

new Update_Manager_Action();
