<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Define the current version for the plugin. Interresting for clear cache for plugin style and script
 * @var string Plugin current version number
 */
DEFINE('DIGI_NODIST_VERSION', '1.0');

/**
 * Get the plugin main dirname. Allows to avoid writing path directly into code
 * @var string Dirname of the plugin
 */
DEFINE('DIGI_NODIST_DIR', basename( dirname( __FILE__ ) ) );
DEFINE('DIGI_NODIST_PATH', str_replace( DIGI_NODIST_DIR, "", dirname( __FILE__ ) ) );
DEFINE('DIGI_NODIST_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', str_replace( "\\", "/", DIGI_NODIST_PATH ) ) );

/**	Load plugin translation	*/
load_plugin_textdomain( 'wp-digi-dtrans-i18n', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**	Define the templates directories	*/
DEFINE( 'DIGI_NODIST_TEMPLATES_MAIN_DIR', DIGI_NODIST_PATH . DIGI_NODIST_DIR . '/templates/' );

/** Plugin initialisation */
require_once( DIGI_NODIST_PATH . DIGI_NODIST_DIR . '/controller/nodistraction.controller.01.php' );
// new Digi_odistraction_controller_01();
