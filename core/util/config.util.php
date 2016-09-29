<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class config_util extends singleton_util {
	public static $init = array();

	protected function construct() {}

	public function init_config( $path_to_config_file ) {
		$path_to_config_file = PLUGIN_PATH . $path_to_config_file;
		if ( empty( $path_to_config_file ) ) {
			trigger_error( 'Impossible de charger le fichier : ' . $path_to_config_file, E_USER_ERROR );
		}

		$tmp_config = json_util::g()->open_and_decode( $path_to_config_file );

		if ( empty( $tmp_config->slug ) ) {
			trigger_error( 'Le module ' . $path_to_config_file . ' nécessite un slug dans sa configuration.', E_USER_ERROR );
		}

		self::$init[$tmp_config->slug] = $tmp_config;
	}

	public function get_config_data( $path_to_config_file ) {

	}
}
