<?php
/**
 * Les actions qui se déroulent lors de l'installation.
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions qui se déroulent lors de l'installation.
 */
class Installer_Action {

	/**
	 * Le constructeur appelle les méthodes admin_post et ajax suivantes:
	 */
	public function __construct() {
		add_action( 'wp_ajax_installer_save_society', array( $this, 'ajax_installer_save_society' ) );
		add_action( 'wp_ajax_installer_components', array( $this, 'ajax_installer_components' ) );
		add_action( 'admin_post_last_step', array( $this, 'admin_post_last_step' ) );
	}


	/**
	 * Test
	 *
	 * @return void
	 */
	public function ajax_installer_save_society() {
		check_ajax_referer( 'ajax_installer_save_society' );

		$address = address_class::g()->create( $_POST['address'] );
		$groupment = group_class::g()->create( $_POST['groupment'] );
		$groupment->contact['address_id'][] = $address->id;
		group_class::g()->update( $groupment );
		$address->post_id = $groupment->id;
		address_class::g()->update( $address );

		wp_send_json_success( array( 'module' => 'installer', 'callback_success' => 'save_society' ) );
	}

	/**
	 * Installes les composants requis pour l'utilisation de Digirisk
	 * Les dangers
	 * Les méthodes d'évaluations
	 * Les recommendations
	 *
	 * @return void
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

		$core_option = get_option( config_util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			danger_default_data_class::g()->create();
			log_class::g()->exec( 'digirisk-installer', '', __( 'Installation des dangers effectués', 'digirisk' ) );
			$core_option['danger_installed'] = true;
		} elseif ( ! $core_option['recommendation_installed'] ) {
			recommendation_default_data_class::g()->create();
			log_class::g()->exec( 'digirisk-installer', '', __( 'Installation des recommandations effectués', 'digirisk' ) );
			$core_option['recommendation_installed'] = true;
		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			evaluation_method_default_data_class::g()->create();
			log_class::g()->exec( 'digirisk-installer', '', __( "Installation des méthodes d'évaluation effectués", 'digirisk' ) );
			$core_option['evaluation_method_installed'] = true;
			$core_option['installed'] = true;
			log_class::g()->exec( 'digirisk-installer', '', __( 'Installation de digiRisk effectué', 'digirisk' ) );
		}

		update_option( config_util::$init['digirisk']->core_option, $core_option );

		wp_send_json_success( array( 'core_option' => $core_option, 'module' => 'installer', 'callback_success' => 'install_component_success' ) );
	}

	/**
	 * Tmp
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

new installer_action();
