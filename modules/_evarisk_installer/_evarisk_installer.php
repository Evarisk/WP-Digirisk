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
DEFINE( 'DIGI_INSTAL_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'DIGI_INSTAL_DIR', basename(dirname(__FILE__)));
DEFINE( 'DIGI_INSTAL_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'DIGI_INSTAL_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'DIGI_INSTAL_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', DIGI_INSTAL_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'DIGI_INSTAL_TEMPLATES_MAIN_DIR', DIGI_INSTAL_PATH . '/templates/');

/**	Inclusion des controlleurs principaux du module / Include main module controller	*/
include( DIGI_INSTAL_PATH . '/controller/installer.controller.01.php' );
include( DIGI_INSTAL_PATH . '/controller/installer.action.01.php' );
