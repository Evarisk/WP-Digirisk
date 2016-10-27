<?php
/**
 * Gestion des modules
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des modules
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Module_util extends Singleton_util {
	/**
	 * Le constructeur obligatoirement pour utiliser la classe singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Parcours le fichier digirisk.config.json pour récupérer les chemins vers tous les modules.
	 * Initialise ensuite un par un, tous ses modules.
	 *
	 * @return mixed WP_Error si les configs de DigiRisk ne sont pas initialisés, ou si aucun module n'est présent.
	 */
	public function exec_module() {
		if ( empty( config_util::$init['digirisk'] ) ) {
			return new \WP_Error( 'broke', __( 'Les configurations de base de DigiRisk ne sont pas initialisées', 'digirisk' ) );
		}

		if ( empty( config_util::$init['digirisk']->modules ) ) {
			return new \WP_Error( 'broke', __( 'Aucun module a charger', 'digirisk' ) );
		}

		if ( ! empty( config_util::$init['digirisk']->modules ) ) {
			foreach ( config_util::$init['digirisk']->modules as $module_json_path ) {
				\digi\log_class::g()->start_ms( 'digi_boot_module' );
				self::inc_config_module( $module_json_path );
				self::inc_module( $module_json_path );
				\digi\log_class::g()->exec( 'digi_boot', 'digi_boot_module', 'Boot le module', array( 'module_path' => $module_json_path ) );
			}
		}
	}

	/**
	 * Appelle la méthode init_config de Config_util pour initialiser les configs du module
	 *
	 * @param  string $module_json_path Le chemin vers le dossier du module.
	 * @return void                   	nothing
	 */
	public function inc_config_module( $module_json_path ) {
		config_util::g()->init_config( $module_json_path );
	}

	/**
	 * Inclus les dépendences du module (qui sont défini dans le config.json du module en question)
	 *
	 * @param  string $module_json_path Le chemin vers le module.
	 * @return void                   	nothing
	 */
	public function inc_module( $module_json_path ) {
		$module_name = basename( $module_json_path, '.config.json' );
		$module_path = dirname( $module_json_path );

		if ( ! isset( config_util::$init[ $module_name ]->state ) || ( isset( config_util::$init[ $module_name ]->state ) && config_util::$init[ $module_name ]->state ) ) {
			if ( ! empty( config_util::$init[ $module_name ]->dependencies ) ) {
				foreach ( config_util::$init[ $module_name ]->dependencies as $dependence_folder => $list_option ) {
					$path_to_module_and_dependence_folder = $module_path . '/' . $dependence_folder . '/';

					if ( ! empty( $list_option->priority ) ) {
						$this->inc_priority_file( $path_to_module_and_dependence_folder, $dependence_folder, $list_option->priority );
					}

					include_util::g()->in_folder( $path_to_module_and_dependence_folder );
				}
			}
		}
	}

	/**
	 * Inclus les fichiers prioritaires qui se trouvent dans la clé "priority" dans le .config.json du module
	 *
	 * @param  string $path_to_module_and_dependence_folder Le chemin vers le module.
	 * @param  string $dependence_folder                    le chemin vers le dossier à inclure.
	 * @param  array  $list_priority_file                    La liste des chemins des fichiers à inclure en priorité.
	 * @return void                                       	nothing
	 */
	public function inc_priority_file( $path_to_module_and_dependence_folder, $dependence_folder, $list_priority_file ) {
		if ( ! empty( $list_priority_file ) ) {
			foreach ( $list_priority_file as $file_name ) {
				$path_file = realpath( PLUGIN_DIGIRISK_PATH . $path_to_module_and_dependence_folder . $file_name . '.' . $dependence_folder . '.php' );

				require_once( $path_file );
			}
		}
	}
}
