<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Bootstrap file for plugin. Do main includes and create new instance for plugin components
 *
 * @author Eoxia <dev@eoxia.com>
 * @version 0.1
 */

DEFINE( 'WPEO_MODEL_VERSION', 0.2 );
DEFINE( 'WPEO_MODEL_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'WPEO_MODEL_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPEO_MODEL_STATE', true);


?>
