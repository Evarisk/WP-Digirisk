<?php
/**
 * Gestion des actions pour les mises à jours.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Update_Manager\Action
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de gestion des "actions" pour le module de mise à jour des données suite aux différentes version de l'extension
 */
class Update_Manager_Action {

	/**
	 * Définition du namespace courant pour le module de mise à jour.
	 *
	 * @var string
	 */
	protected $current_plugin_slug = null;

	/**
	 * Instanciation de la classe de gestions des mises à jour des données suite aux différentes versions de l'extension
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function __construct() {
		$element_namespace         = new \ReflectionClass( get_called_class() );
		$this->current_plugin_slug = str_replace( '_', '-', $element_namespace->getNamespaceName() );

		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_scripts' ) );
	}

	/**
	 * Charges le CSS et le JS de WPEO_Update_Manager
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function callback_admin_scripts() {
		wp_enqueue_style( 'wpeo_update_manager_style', \eoxia\Config_Util::$init['eo-framework']->wpeo_update_manager->url . '/assets/css/style.css', array() );
		wp_enqueue_script( 'wpeo_update_manager_script', \eoxia\Config_Util::$init['eo-framework']->wpeo_update_manager->url . '/assets/js/wpeo-update-manager.js', array( 'jquery', 'jquery-form' ), \eoxia\Config_Util::$init['eo-framework']->wpeo_update_manager->version );
	}

	/**
	 * On récupère la version actuelle de l'extension principale pour savoir si une mise à jour est nécessaire
	 * On regarde également si des mises à jour n'ont pas été faite suite à un suivi des mises à jours non régulier
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function automatic_update_redirect() {
		$waiting_updates = get_option( Config_Util::$init[ $this->current_plugin_slug ]->key_waiting_updates, array() );

		if ( ! strpos( $_SERVER['REQUEST_URI'], 'admin-ajax.php' ) ) {
			$current_version_to_check = (int) str_replace( '.', '', Config_Util::$init[ $this->current_plugin_slug ]->version );
			$last_version_done        = (int) get_option( Config_Util::$init[ $this->current_plugin_slug ]->key_last_update_version, Config_Util::$init[ $this->current_plugin_slug ]->update_manager->first_version );
			if ( 3 === strlen( $current_version_to_check ) ) {
				$current_version_to_check *= 10;
			}

			if ( $last_version_done !== $current_version_to_check ) {
				$update_data_path = Config_Util::$init[ $this->current_plugin_slug ]->update_manager->path . 'data/';
				for ( $i = ( (int) substr( $last_version_done, 0, 4 ) + 1 ); $i <= $current_version_to_check; $i++ ) {
					if ( is_file( $update_data_path . 'update-' . $i . '-data.php' ) ) {
						require_once $update_data_path . 'update-' . $i . '-data.php';
						$waiting_updates[ $i ] = $datas;

						update_option( Config_Util::$init[ $this->current_plugin_slug ]->key_waiting_updates, $waiting_updates );
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
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function callback_admin_menu() {

		$element_namespace             = new \ReflectionClass( get_called_class() );
		$current_plugin_update_manager = '\\' . $element_namespace->getNamespaceName() . '\Update_Manager';
		add_submenu_page( 'eo-update-manager-' . $this->current_plugin_slug, __( 'Update Manager', 'eoxia' ), __( 'Update Manager', 'eoxia' ), 'manage_options', Config_Util::$init[ $this->current_plugin_slug ]->update_page_url, array( $current_plugin_update_manager::g(), 'display' ) );

	}

}
