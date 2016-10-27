<?php
/**
 * Initialise les fichiers .config.json
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les fichiers .config.json
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Config_util extends Singleton_util {
	/**
	 * Un tableau contenant toutes les configurations des fichies config.json
	 *
	 * @var array
	 */
	public static $init = array();

	/**
	 * Le constructeur obligatoirement pour utiliser la classe singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Initialise les fichiers de configuration
	 *
	 * @param  string $path_to_config_file Le chemin vers le fichier config.json.
	 *
	 * @return mixed                       WP_Error si il ne trouve pas le fichier config du module
	 */
	public function init_config( $path_to_config_file ) {
		$path_to_config_file = PLUGIN_DIGIRISK_PATH . $path_to_config_file;
		if ( empty( $path_to_config_file ) ) {
			return new \WP_Error( 'broke', __( 'Impossible de charger le fichier', 'digirisk' ) );
		}

		$tmp_config = json_util::g()->open_and_decode( $path_to_config_file );

		if ( empty( $tmp_config->slug ) ) {
			return new \WP_Error( 'broke', __( 'Le module nécessite un slug', 'digirisk' ) );
		}

		self::$init[ $tmp_config->slug ] = $tmp_config;
	}
}
