<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Bootstrap file
 *
 * @author Development team <dev@eoxia.com>
 * @version 1.0
 */

/**
 * Define the current version for the plugin. Interresting for clear cache for plugin style and script
 * @var string Plugin current version number
 */
DEFINE('DIGI_EVALMETHOD_VERSION', '1.0');

/**
 * Get the plugin main dirname. Allows to avoid writing path directly into code
 * @var string Dirname of the plugin
 */
DEFINE( 'WPDIGI_EVALMETHOD_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_EVALMETHOD_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_EVALMETHOD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_EVALMETHOD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_EVALMETHOD_PATH ) );

/**	Define the templates directories	*/
DEFINE( 'WPDIGI_EVALMETHOD_VIEW', WPDIGI_EVALMETHOD_PATH . '/view/' );

/** Plugin initialisation */
require_once( WPDIGI_EVALMETHOD_PATH . '/controller/evaluation_method.controller.01.php' );
require_once( WPDIGI_EVALMETHOD_PATH . '/controller/evaluation_method_variable.controller.01.php' );
require_once( WPDIGI_EVALMETHOD_PATH . '/action/evaluation_method.action.php' );
require_once( WPDIGI_EVALMETHOD_PATH . '/shortcode/evaluation_method.shortcode.php' );
require_once( WPDIGI_EVALMETHOD_PATH . '/util/scale.util.php' );
