<?php
/**
 * Les actions qui se déroulent lors de l'installation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
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
	 * save_society (Ajax)
	 * installer_components (Ajax)
	 *
	 * @since 0.1.0
	 * @version 6.2.8
	 */
	public function __construct() {
		add_action( 'wp_ajax_installer_save_society', array( $this, 'ajax_installer_save_society' ) );
		add_action( 'wp_ajax_installer_components', array( $this, 'ajax_installer_components' ) );
	}


	/**
	 * Installe la société de base pour le fonctionnement de DigiRisk.
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 6.3.0
	 */
	public function ajax_installer_save_society() {
		check_ajax_referer( 'ajax_installer_save_society' );

		$society = Society_Class::g()->create( $_POST['society'] );

		// Création des données par default depuis le fichier json installer/asset/json/default.json.
		$file_content = file_get_contents( \eoxia\Config_Util::$init['digirisk']->installer->path . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( ! empty( $data ) ) {
			foreach ( $data as $group_object ) {
				$group = Group_Class::g()->update( array(
					'title' => $group_object->title,
					'post_parent' => $society->id,
				) );

				if ( ! empty( $group_object->workunits ) ) {
					foreach ( $group_object->workunits as $workunit_object ) {
						$workunit = Workunit_Class::g()->update( array(
							'title' => $workunit_object->title,
							'post_parent' => $group->id,
						) );
					}
				}
			}
		}

		wp_send_json_success( array(
			'namespace' => 'digirisk',
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
	 * @since 6.2.3
	 * @version 6.3.0
	 */
	public function ajax_installer_components() {
		// check_ajax_referer( 'ajax_installer_components' );

		$default_core_option = array(
			'installed' => false,
			'db_version' => '1',
			'danger_installed' => false,
			'recommendation_installed' => false,
			'evaluation_method_installed' => false,
		);

		$core_option = get_option( \eoxia\Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			Danger_Default_Data_Class::g()->create();
			\eoxia\Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation des dangers effectués', 'digirisk' ) );
			$core_option['danger_installed'] = true;
		} elseif ( ! $core_option['recommendation_installed'] ) {
			Recommendation_Default_Data_Class::g()->create();
			\eoxia\Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation des recommandations effectués', 'digirisk' ) );
			$core_option['recommendation_installed'] = true;
		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			Evaluation_Method_Default_Data_Class::g()->create();
			\eoxia\Log_Class::g()->exec( 'digirisk-installer', '', __( "Installation des méthodes d'évaluation effectués", 'digirisk' ) );
			$core_option['evaluation_method_installed'] = true;
			$core_option['installed'] = true;
			\eoxia\Log_Class::g()->exec( 'digirisk-installer', '', __( 'Installation de digiRisk effectué', 'digirisk' ) );
		}

		$current_version_for_update_manager = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );
		if ( 3 === strlen( $current_version_for_update_manager ) ) {
			$current_version_for_update_manager *= 10;
		}

		update_option( \eoxia\Config_Util::$init['digirisk']->core_option, $core_option );
		update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, $current_version_for_update_manager );

		wp_send_json_success( array(
			'core_option' => $core_option,
			'namespace' => 'digirisk',
			'module' => 'installer',
			'callback_success' => 'installedComponentSuccess',
		) );
	}

}

new Installer_Action();
