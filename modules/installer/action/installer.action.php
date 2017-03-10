<?php
/**
 * Les actions qui se déroulent lors de l'installation.
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.6.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions qui se déroulent lors de l'installation.
 */
class Installer_Action {

	/**
	 * Le constructeur appelle les méthodes admin_post et ajax suivantes:
	 * save_society (Ajax)
	 * installer_components (Ajax)
	 * last_step (admin_post)
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_installer_save_society', array( $this, 'ajax_installer_save_society' ) );
		add_action( 'wp_ajax_installer_components', array( $this, 'ajax_installer_components' ) );
		add_action( 'admin_post_last_step', array( $this, 'admin_post_last_step' ) );
	}


	/**
	 * Installe la société de base pour le fonctionnement de DigiRisk.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.6.0
	 */
	public function ajax_installer_save_society() {
		check_ajax_referer( 'ajax_installer_save_society' );

		$groupment = Group_Class::g()->create( $_POST['groupment'] );

		wp_send_json_success( array(
			'module' => 'installer',
			'callback_success' => 'savedSociety',
		) );
	}

	/**
	 * Installes les composants requis pour l'utilisation de Digirisk
	 * Les dangers
	 * Les méthodes d'évaluations
	 * Les recommendations
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.8.0
	 */
	public function ajax_installer_components() {
		check_ajax_referer( 'ajax_installer_components' );

		$default_core_option = array(
			'installed' 									=> false,
			'db_version'									=> '1',
			'danger_installed' 						=> false,
			'recommendation_installed' 		=> false,
			'evaluation_method_installed' => false,
		);

		$core_option = get_option( Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			Danger_Default_Data_Class::g()->create();
			Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation des dangers effectués', 'digirisk' ) );
			$core_option['danger_installed'] = true;
		} elseif ( ! $core_option['recommendation_installed'] ) {
			Recommendation_Default_Data_Class::g()->create();
			Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation des recommandations effectués', 'digirisk' ) );
			$core_option['recommendation_installed'] = true;
		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			Evaluation_Method_Default_Data_Class::g()->create();
			Log_Class::g()->exec( 'digirisk-installer', '', __( "Installation des méthodes d'évaluation effectués", 'digirisk' ) );
			$core_option['evaluation_method_installed'] = true;
			$core_option['installed'] = true;
			Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation de digiRisk effectué', 'digirisk' ) );
		}

		// update_option( Config_Util::$init['digirisk']->core_option, $core_option );

		wp_send_json_success( array(
			'core_option' => $core_option,
			'module' => 'installer',
			'callback_success' => 'installedComponentSuccess',
		) );
	}

	/**
	 * C'est quoi cette méthode ?
	 *
	 * @return void
	 */
	public function admin_post_last_step() {
		if ( empty( $_GET['_wpnonce'] ) ) {
			wp_safe_redirect( wp_get_referer() );
			die();
		}
		$wpnonce = sanitize_text_field( $_GET['_wpnonce'] );

		if ( ! wp_verify_nonce( $wpnonce, 'last_step' ) ) {
			wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
		}

		wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
	}
}

new Installer_Action();
