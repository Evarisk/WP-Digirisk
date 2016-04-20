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
DEFINE('DIGI_RECO_VERSION', '1.0');

/**
 * Get the plugin main dirname. Allows to avoid writing path directly into code
 * @var string Dirname of the plugin
 */
DEFINE( 'WPDIGI_RECOM_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_RECOM_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_RECOM_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_RECOM_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_RECOM_PATH ) );

/**	Define the templates directories	*/
DEFINE( 'DIGI_RECOM_TEMPLATES_MAIN_DIR', WPDIGI_RECOM_PATH . '/templates/' );

/** Plugin initialisation */
require_once( WPDIGI_RECOM_PATH . 'controller/recommendation_category.controller.01.php' );
require_once( WPDIGI_RECOM_PATH . 'controller/recommendation.controller.01.php' );
require_once( WPDIGI_RECOM_PATH . 'controller/recommendation.action.01.php' );
