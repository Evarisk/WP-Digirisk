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
DEFINE('ADDRESS_VERSION', '1.0');

/**
 * Get the plugin main dirname. Allows to avoid writing path directly into code
 * @var string Dirname of the plugin
 */
DEFINE( 'ADDRESS_DIR', basename(dirname(__FILE__)));
DEFINE( 'ADDRESS_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'ADDRESS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'ADDRESS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', ADDRESS_PATH ) );

/**	Define the templates directories	*/
DEFINE( 'ADDRESS_TEMPLATES_MAIN_DIR', ADDRESS_PATH . '/templates/' );
