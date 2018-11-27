<?php
/**
 * Fichier boot d'un plugin made Eoxia.
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

if ( ! class_exists( '\eoxia\Init_Util' ) ) {

	/**
	 * Cette classe initialise tous les fichiers config.json
	 */
	class Init_Util extends \eoxia\Singleton_Util {
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
		 * Appelles les méthodes read_core_util_file_and_include et init_main_config ainsi que init_module
		 *
		 * @param string $path        Le chemin absolue vers le plugin.
		 * @param string $plugin_slug Le slug du plugin (Défini dans votre config.json principale).
		 *
		 * @return void
		 */
		public function exec( $path, $plugin_slug ) {
			self::read_core_util_file_and_include( $path, $plugin_slug );
			self::init_main_config( $path, $plugin_slug );
			self::init_external( $path, $plugin_slug );
			Config_Util::$init['main'] = new \stdClass();
			Config_Util::$init['main']->full_plugin_path = $path;
			self::init_module( $path, $plugin_slug );
		}

		/**
		 * Listes la liste des fichiers ".utils" dans le dossier ./core/external/wpeo_util/
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $path        Le chemin du plugin.
		 * @param string $plugin_slug Le slug principale du plugin défini dans le fichier config.json principale.
		 *
		 * @return WP_Error|bool {
		 *                            WP_Error Si le module n'existe pas dans le tableau externals du fichier principale de config.json.
		 *                            WP_Error Si le fichier n'existe pas
		 *                            bool     Si aucune erreur s'est produite.
		 *}
		 */
		private function read_core_util_file_and_include( $path, $plugin_slug ) {
			$path_to_core_folder_util = $path . 'core/util/';
			if ( ! file_exists( $path_to_core_folder_util ) ) {
				return new \WP_Error( 'broke', __( 'Impossible de charger les fichiers .utils', $plugin_slug ) );
			}

			if ( ! is_dir( $path_to_core_folder_util ) ) {
				return new \WP_Error( 'broke', __( '$path_to_core_folder_util n\'est pas un dossier', $plugin_slug ) );
			}

			$list_file_name = scandir( $path_to_core_folder_util );

			if ( ! $list_file_name || ! is_array( $list_file_name ) ) {
				return new \WP_Error( 'broke', __( 'Impossible de charger les fichiers .utils', $plugin_slug ) );
			}

			if ( ! empty( $list_file_name ) ) {
				foreach ( $list_file_name as $file_name ) {
					if ( '.' !== $file_name && '..' !== $file_name && 'index.php' !== $file_name && '.git' !== $file_name && 'README.md' !== $file_name ) {
						$file_path = realpath( $path_to_core_folder_util . $file_name );
						require_once( $file_path );
					}
				}
			}
		}

		/**
		 * Appelle la méthode init_config avec le fichier digirisk.config.json
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $path        Le chemin du plugin.
		 * @param string $plugin_slug Le slug principale du plugin défini dans le fichier config.json principale.
		 *
		 * @return void
		 */
		private function init_main_config( $path, $plugin_slug ) {
			$main_config_path = $plugin_slug . '.config.json';
			$init_status = \eoxia\Config_Util::g()->init_config( $path . $main_config_path );

			if ( \is_wp_error( $init_status ) ) {
				exit( $init_status->errors['broke'][0] );
			}

			if ( isset( Config_Util::$init[ $plugin_slug ] ) ) {
				Config_Util::$init[ $plugin_slug ]->path = $path;
			}
		}

		/**
		* Appel la méthode 'exec' de l'objet 'External_Util' afin d'initialiser les externals.
		*
		* @since 0.1.0
		* @version 1.0.0
		*
		* @param string $path        Le chemin du plugin.
		* @param string $plugin_slug Le slug principale du plugin défini dans le fichier config.json principale.
		*
		* @return void
		*/
		private function init_external( $path, $plugin_slug ) {
			if ( empty( Config_Util::$init['external'] ) ) {
				Config_Util::$init['external'] = new \stdClass();
			}

			\eoxia\External_Util::g()->exec( $path, $plugin_slug );
		}

		/**
		 * Appelle la méthode exec_module de \eoxia\Module_Util pour initialiser tous les modules
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $path        Le chemin du plugin.
		 * @param string $plugin_slug Le slug principale du plugin défini dans le fichier config.json principale.
		 *
		 * @return void
		 */
		private function init_module( $path, $plugin_slug ) {
			$init_module_status = \eoxia\Module_Util::g()->exec_module( $path, $plugin_slug );

			if ( \is_wp_error( $init_module_status ) ) {
				exit( $init_module_status->errors['broke'][0] );
			}
		}
	}
} // End if().
