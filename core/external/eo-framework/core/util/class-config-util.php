<?php
/**
 * Gestion de l'objet Config_Util::$init.
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

if ( ! class_exists( '\eoxia\Config_Util' ) ) {

	/**
	 * Gestion de l'objet Config_Util::$init.
	 */
	class Config_Util extends \eoxia\Singleton_Util {

		/**
		 * Un tableau contenant toutes les configurations des fichies config.json
		 *
		 * @var array
		 */
		public static $init = array();

		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @return void nothing
		 */
		protected function construct() {}

		/**
		 * Initialise les fichiers de configuration
		 *
		 * @since 0.1.0
		 * @version 1.0.1
		 *
		 * @param string $path_to_config_file Le chemin vers le fichier config.json.
		 * @param string $plugin_slug         Le SLUG du plugin définis dans le fichier principale de config.json.
		 *
		 * @return \WP_Error|boolean {
		 *																		WP_Error Si le fichier est inexistant ou si le plugin ne contient pas de slug.
		 *                                    boolean  True si aucune erreur s'est produite.
		 *}.
		 */
		public function init_config( $path_to_config_file, $plugin_slug = '' ) {
			if ( empty( $path_to_config_file ) ) {
				return new \WP_Error( 'broke', __( 'Unable to load file', 'eoxia' ) );
			}

			if ( ! file_exists( $path_to_config_file ) ) {
				return new \WP_Error( 'broke', __( sprintf( 'File %s is not found', $path_to_config_file ) ) );
			}

			$tmp_config = JSON_Util::g()->open_and_decode( $path_to_config_file );
			if ( empty( $tmp_config->slug ) ) {
				return new \WP_Error( 'broke', __( 'This plugin need to have a slug', 'eoxia' ) );
			}

			$type = isset( $tmp_config->modules ) ? 'main' : 'module';

			if ( 'main' === $type ) {
				if ( $tmp_config->slug !== $plugin_slug && '' !== $plugin_slug ) {
					return new \WP_Error( 'broke', __( sprintf( 'Slug of plugin is not equal main config json file name %s => %s. Set correct slug in the file: %s', $plugin_slug, $tmp_config->slug, $path_to_config_file ), 'eoxia' ) );
				}
			}

			if ( ! empty( $plugin_slug ) ) {
				if ( ! isset( self::$init[ $plugin_slug ] ) ) {
					self::$init[ $plugin_slug ] = $tmp_config;
				} else {
					$abspath = str_replace( '\\', '/', ABSPATH );

					$slug = $tmp_config->slug;
					$tmp_path = str_replace( '\\', '/', self::$init[ $plugin_slug ]->path );
					$tmp_config->module_path = $tmp_config->path;

					$tmp_config->url = str_replace( $abspath, site_url('/'), $tmp_path . $tmp_config->path );
					$tmp_config->url = str_replace( '\\', '/', $tmp_config->url );
					$tmp_config->path = $tmp_path . $tmp_config->path;
					if ( isset( $tmp_config->external ) && ! empty( $tmp_config->external ) ) {
						self::$init['external']->$slug = $tmp_config;
					} else {
						self::$init[ $plugin_slug ]->$slug = $tmp_config;
					}
				}
			} else {
				self::$init[ $tmp_config->slug ] = $tmp_config;
			}
		}
	}
} // End if().
