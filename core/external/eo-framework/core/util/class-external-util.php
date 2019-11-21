<?php
/**
 * Gestion des externals.
 * Les externals doivent être placés dans core/externals/
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\Core\Util
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\External_Util' ) ) {

	/**
	 * Gestion des externals
	 */
	class External_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		protected function construct() {}

		/**
		 * Parcours le fichier digirisk.config.json pour récupérer les chemins vers tous les modules.
		 * Initialise ensuite un par un, tous ses modules.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $path        Le chemin vers le module externe.
		 * @param string $plugin_slug Le slug principale du plugin dans le fichier principale config.json.
		 *
		 * @return WP_Error|bool {
		 *                            WP_Error Si le module n'existe pas dans le tableau externals du fichier principale de config.json.
		 *                            bool     Si aucune erreur s'est produite.
		 *}
		 */
		public function exec( $path, $plugin_slug ) {
			if ( empty( \eoxia\Config_Util::$init[ $plugin_slug ]->externals ) ) {
				return new \WP_Error( 'broke', __( 'Aucun module a charger', $plugin_slug ) );
			}

			if ( ! empty( \eoxia\Config_Util::$init[ $plugin_slug ]->externals ) ) {
				foreach ( \eoxia\Config_Util::$init[ $plugin_slug ]->externals as $external_json_path ) {
					self::inc_config( $plugin_slug, $path . $external_json_path );
					self::inc( $plugin_slug, $path . $external_json_path );
				}
			}

			return true;
		}

		/**
		 * Appelle la méthode init_config de \eoxia\Config_Util pour initialiser les configs du module
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $plugin_slug      Le slug du module externe à initialiser.
		 * @param string $module_json_path Le chemin vers le dossier du module externe.
		 *
		 * @return void
		 */
		public function inc_config( $plugin_slug, $module_json_path ) {
			\eoxia\Config_Util::g()->init_config( $module_json_path, $plugin_slug );
		}

		/**
		 * Inclus les dépendences du module (qui sont défini dans le config.json du module en question)
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $plugin_slug      Le slug du module externe à initialiser.
		 * @param string $module_json_path Le chemin vers le dossier du module externe.
		 *
		 * @return void
		 */
		public function inc( $plugin_slug, $module_json_path ) {
			$module_name = basename( $module_json_path, '.config.json' );
			$module_path = dirname( $module_json_path );

			if ( ! empty( \eoxia\Config_Util::$init['external'] ) ) {
				foreach ( \eoxia\Config_Util::$init['external'] as $external_name => $config ) {
					if ( ! empty( $config->dependencies ) ) {
						foreach ( $config->dependencies as $folder_name => $folder_conf ) {
							$path_to_module_and_dependence_folder = $config->path . '/' . $folder_name . '/';

							if ( ! empty( $folder_conf->priority ) ) {
								$this->inc_priority_file( $path_to_module_and_dependence_folder, $folder_name, $folder_conf->priority );
							}

							\eoxia\Include_util::g()->in_folder( $path_to_module_and_dependence_folder );
						}
					}
				}
			}
		}

		/**
		 * Inclus les fichiers prioritaires qui se trouvent dans la clé "priority" dans le .config.json du module
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $path_to_module_and_dependence_folder Le chemin vers le module.
		 * @param  string $dependence_folder                    le chemin vers le dossier à inclure.
		 * @param  array  $list_priority_file                   La liste des chemins des fichiers à inclure en priorité.
		 * @return void
		 */
		public function inc_priority_file( $path_to_module_and_dependence_folder, $dependence_folder, $list_priority_file ) {
			if ( ! empty( $list_priority_file ) ) {
				foreach ( $list_priority_file as $file_name ) {
					$path_file = realpath( $path_to_module_and_dependence_folder . $file_name . '.' . $dependence_folder . '.php' );

					if ( file_exists( $path_file ) ) {
						require_once( $path_file );
					}
				}
			}
		}
	}
} // End if().
