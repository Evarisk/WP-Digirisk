<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Module bootstrap file
 * @author Evarisk development team <dev@evarisk.com>
 * @version 1.0
 */

/**
 * Define the current version for the plugin. Interresting for clear cache for plugin style and script
 * @var string Plugin current version number
 */
DEFINE( 'OPENING_TIME_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'OPENING_TIME_DIR', basename(dirname(__FILE__)));
DEFINE( 'OPENING_TIME_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'OPENING_TIME_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'OPENING_TIME_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', OPENING_TIME_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'OPENING_TIME_TEMPLATES_MAIN_DIR', OPENING_TIME_PATH . '/view/');


/**	Inclusion des controlleurs principaux du module / Include main module controller	*/
include( OPENING_TIME_PATH . '/class/opening_time.class.01.php' );
include( OPENING_TIME_PATH . '/action/opening_time.action.01.php' );
include( OPENING_TIME_PATH . '/shortcode/opening_time.shortcode.01.php' );
