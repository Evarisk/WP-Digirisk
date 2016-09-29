<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */
class init_util extends singleton_util {
	protected function construct() {}

	public function exec() {
		self::read_core_util_file_and_inculde();
		self::init_main_config();
		self::init_module();
	}

	/**
	 * Listes la liste des fichiers ".utils" dans le dossier ./core/util/
	 * @return [type] [description]
	 */
	private function read_core_util_file_and_inculde() {
		$path_to_core_folder_util = PLUGIN_PATH . 'core/util/';
		if ( !file_exists( $path_to_core_folder_util ) ) {
			trigger_error( 'Impossible de charger les fichiers ".utils"', E_USER_ERROR );
		}

		if ( !is_dir( $path_to_core_folder_util ) ) {
			trigger_error( '$path_to_core_folder_util n\'est pas un dossier', E_USER_ERROR );
		}

		$list_file_name = scandir( $path_to_core_folder_util );

		if ( !$list_file_name || !is_array( $list_file_name ) ) {
			trigger_error( 'Impossible de charger les fichiers ".utils"', E_USER_ERROR );
		}

		if ( !empty( $list_file_name ) ) {
		  foreach ( $list_file_name as $file_name ) {
				if ( $file_name != '.' && $file_name != '..' ) {
					$file_path = realpath( $path_to_core_folder_util . $file_name );
					require_once ( $file_path );
				}
		  }
		}
	}

	private function init_main_config() {
		$main_config_path = 'digirisk.config.json';
		config_util::g()->init_config( $main_config_path );
	}

	private function init_module() {
		module_util::g()->exec_module();
	}
}
