<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class include_util extends singleton_util {
	protected function construct() {}

	public function in_folder( $folder_path ) {
		$folder_path = PLUGIN_DIGIRISK_PATH . $folder_path;
		if ( !file_exists( $folder_path ) ) {

		}

		$list_file_name = scandir( $folder_path );

		if ( !empty( $list_file_name ) ) {
		  foreach ( $list_file_name as $file_name ) {
				if ( $file_name != '.' && $file_name != '..' && $file_name != 'index.php' ) {
					$file_path = realpath( $folder_path . $file_name );
					\digi\log_class::g()->start_ms( 'digi_boot_module_in_folder' );
					$file_success = require_once ( $file_path );
					if ( class_exists( '\digi\log_service_class' ) ) {
						\digi\log_class::g()->exec('digi_boot', 'digi_boot_module_in_folder', 'Inclus le fichier : ' . $file_name, array( 'path' => $file_path, 'success' => $file_success ) );
					}
				}
		  }
		}

	}
}
