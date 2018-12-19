<?php
/**
 * Gestion des actions lors de l'installation de DigiRisk.
 *
 * Ajoutes la page d'installation dans le menu de WordPress.
 *
 * Gères l'enregistrement de la première société ainsi que les données par
 * défaut pour le fonctionnement de l'application.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Installer action class.
 */
class Installer_Action {

	/**
	 * Le constructeur appelle les méthodes admin_post et ajax suivantes:
	 * save_society (Ajax)
	 * installer_components (Ajax)
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_installer_save_society', array( $this, 'ajax_installer_save_society' ) );
		add_action( 'wp_ajax_installer_components', array( $this, 'ajax_installer_components' ) );
	}

	/**
	 * Ajoutes la page "Installeur" dans le menu "DigiRisk"
	 *
	 * @since 6.0.0
	 */
	public function admin_menu() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( empty( $digirisk_core['installed'] ) ) {
			add_menu_page( __( 'Installation de DigiRisk', 'digirisk' ), __( 'DigiRisk', 'digirisk' ), 'manage_digirisk', 'digi-setup', array( Installer_Class::g(), 'setup_page' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
		}
	}


	/**
	 * Installe la société de base pour le fonctionnement de DigiRisk.
	 *
	 * @since 6.0.0
	 */
	public function ajax_installer_save_society() {
		check_ajax_referer( 'ajax_installer_save_society' );

		$title                = ! empty( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : ''; // WPCS: input var ok.
		$install_default_data = ( ! empty( $_POST['install_default_data'] ) && 'true' === $_POST['install_default_data'] ) ? true : false; // WPCS: input var ok.

		if ( empty( $title ) ) {
			wp_send_json_error();
		}

		$society = Installer_Class::g()->create_install_society( $title );

		if ( $install_default_data ) {
			// Création des données par default depuis le fichier json installer/asset/json/default.json.
			if ( Installer_Class::g()->create_default_data( $society->data['id'] ) ) {
				\eoxia\LOG_Util::log( 'Installeur - Création des GP et UT par défaut -> success.', 'digirisk' );
			}
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'installer',
			'callback_success' => 'savedSociety',
		) );
	}

	/**
	 * Installes les composants requis pour l'utilisation de Digirisk
	 * Les dangers
	 * Les méthodes d'évaluations
	 * Les recommendations
	 *
	 * @since 6.2.3
	 */
	public function ajax_installer_components() {
		// check_ajax_referer( 'ajax_installer_components' );

		$default_core_option = array(
			'installed'                   => false,
			'db_version'                  => '1',
			'danger_installed'            => false,
			'recommendation_installed'    => false,
			'evaluation_method_installed' => false,
		);

		$core_option = get_option( \eoxia\Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			\eoxia\LOG_Util::log( 'Installeur composant - DEBUT: Création des catégorie de risque', 'digirisk' );
			if ( Risk_Category_Default_Data_Class::g()->create() ) {
				$core_option['danger_installed'] = true;
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégorie de risque SUCCESS', 'digirisk' );
			} else {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégorie de risque ERROR', 'digirisk' );
			}
		} elseif ( ! $core_option['recommendation_installed'] ) {

			\eoxia\LOG_Util::log( 'Installeur composant - DEBUT: Création des catégorie de recommendation', 'digirisk' );
			if ( Recommendation_Default_Data_Class::g()->create() ) {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégorie de recommendation SUCCESS', 'digirisk' );
				$core_option['recommendation_installed'] = true;
			} else {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégorie de recommendation ERROR', 'digirisk' );
			}

		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			\eoxia\LOG_Util::log( 'Installeur composant - DEBUT: Création des méthodes d\'évaluation', 'digirisk' );
			if ( Evaluation_Method_Default_Data_Class::g()->create() ) {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des méthodes d\'évaluation SUCCESS', 'digirisk' );
				$core_option['evaluation_method_installed'] = true;
				$core_option['installed']                   = true;
			} else {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des méthodes d\'évaluation ERROR', 'digirisk' );
			}
		}

		$current_version_for_update_manager = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );

		// version * 10 car le module de mise à jour parse les mises à jour à faire grâce à des versions à 4 chiffres.
		if ( 3 === strlen( $current_version_for_update_manager ) ) {
			$current_version_for_update_manager *= 10;
		}

		update_option( \eoxia\Config_Util::$init['digirisk']->core_option, $core_option );
		update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, $current_version_for_update_manager );

		wp_send_json_success( array(
			'core_option'      => $core_option,
			'namespace'        => 'digirisk',
			'module'           => 'installer',
			'callback_success' => 'installedComponentSuccess',
		) );
	}

}

new Installer_Action();
