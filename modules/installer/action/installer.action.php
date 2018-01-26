<?php
/**
 * Les actions qui se déroulent lors de l'installation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
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
	 * @since 6.0.0
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
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function ajax_installer_save_society() {
		check_ajax_referer( 'ajax_installer_save_society' );

		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';

		if ( empty( $title ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->create( array(
			'title'  => $title,
			'status' => 'publish',
		) );

		\eoxia\LOG_Util::log( sprintf( 'Installeur - Création de la société %s -> success.', $society->title ), 'digirisk' );

		// Création des données par default depuis le fichier json installer/asset/json/default.json.
		$request = wp_remote_get( \eoxia\Config_Util::$init['digirisk']->installer->url . 'asset/json/default.json' );

		if ( is_wp_error( $request ) ) {
			\eoxia\LOG_Util::log( sprintf( 'Installeur - Impossible de lire asset/json/default.json' ), 'digirisk' );
			wp_send_json_error();
		}

		$request = wp_remote_retrieve_body( $request );
		$data    = json_decode( $request );

		if ( ! empty( $data ) ) {
			foreach ( $data as $group_object ) {
				$group = Group_Class::g()->update( array(
					'title'       => $group_object->title,
					'post_parent' => $society->id,
					'status'      => 'inherit',
				) );

				if ( ! empty( $group_object->workunits ) ) {
					foreach ( $group_object->workunits as $workunit_object ) {
						$workunit = Workunit_Class::g()->update( array(
							'title'       => $workunit_object->title,
							'post_parent' => $group->id,
							'status'      => 'inherit',
						) );
					}
				}
			}
		}

		\eoxia\LOG_Util::log( 'Installeur - Création des GP et UT par défaut -> success.', 'digirisk' );

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
	 * @return void
	 *
	 * @since 6.2.3
	 * @version 6.5.0
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
