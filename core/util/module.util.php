<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class module_util extends singleton_util {
  protected function construct() {}

	public function exec_module() {
		if ( empty( config_util::$init['digirisk'] ) ) {
			trigger_error( 'Les configurations de base de digirisk ne sont pas initialisées.', E_USER_ERROR );
		}

		if ( empty( config_util::$init['digirisk']->modules ) ) {
			trigger_error( 'Aucun module trouvé dans les configuration de digirisk', E_USER_ERROR );
		}

		if ( !empty( config_util::$init['digirisk']->modules ) ) {
		  foreach ( config_util::$init['digirisk']->modules as $module_json_path ) {
				\digi\log_class::g()->start_ms( 'digi_boot_module' );
				self::inc_config_module( $module_json_path );
				self::inc_module( $module_json_path );
				\digi\log_class::g()->exec('digi_boot', 'digi_boot_module', 'Boot le module', array( 'module_path' => $module_json_path ) );
		  }
		}
	}

	public function inc_config_module( $module_json_path ) {
		config_util::g()->init_config( $module_json_path );
	}

	public function inc_module( $module_json_path ) {
		$module_name = basename( $module_json_path, '.config.json' );
		$module_path = dirname( $module_json_path );

		if ( !isset( config_util::$init[$module_name]->state ) || ( isset( config_util::$init[$module_name]->state ) && config_util::$init[$module_name]->state ) ) {
			if ( !empty( config_util::$init[$module_name]->dependencies ) ) {
			  foreach ( config_util::$init[$module_name]->dependencies as $dependence_folder => $list_option ) {
					$path_to_module_and_dependence_folder =  $module_path . '/' . $dependence_folder . '/';

					if ( !empty( $list_option->priority ) ) {
						$this->inc_priority_file( $path_to_module_and_dependence_folder, $dependence_folder, $list_option->priority );
					}

					include_util::g()->in_folder( $path_to_module_and_dependence_folder );
			  }
			}
		}
	}

	public function inc_priority_file( $path_to_module_and_dependence_folder, $dependence_folder, $list_priority_file ) {
		if ( !empty( $list_priority_file ) ) {
		  foreach ( $list_priority_file as $file_name ) {
				$path_file = realpath( PLUGIN_DIGIRISK_PATH . $path_to_module_and_dependence_folder . $file_name . '.' . $dependence_folder . '.php' );

				if ( !file_exists( $path_file ) ) {
				}

				require_once ( $path_file );
		  }
		}
	}
}
