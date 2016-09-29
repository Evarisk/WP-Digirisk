<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class view_util extends singleton_util {
	protected function construct() {}

	public function exec( $module_name, $view_path_without_ext, $args = array() ) {
		$path_to_view = PLUGIN_PATH . 'modules/' . $module_name . '/view/' . $view_path_without_ext . '.view.php';

		\digi\log_class::g()->start_ms( 'view_util_exec' );

		if ( !file_exists( $path_to_view ) ) {
			\digi\log_class::g()->exec('digi_view', 'view_util_exec', 'Impossible de charger la vue : ' . $path_to_view, $args, 2 );
		}

		$args = apply_filters( $module_name . '-' . $view_path_without_ext, $args, $module_name, $view_path_without_ext );
		extract( $args );
		require( $path_to_view );
		\digi\log_class::g()->exec('view_util_exec', 'view_util_exec', 'Chargement de la vue : ' . $path_to_view, $args );
	}
}
