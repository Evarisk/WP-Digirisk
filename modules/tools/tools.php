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
DEFINE( 'TOOLS_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'TOOLS_DIR', basename(dirname(__FILE__)));
DEFINE( 'TOOLS_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'TOOLS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'TOOLS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', TOOLS_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'TOOLS_TEMPLATES_MAIN_DIR', TOOLS_PATH . '/templates/');

/**	Définition des types d'éléments ( post type ) à générer / Define elements types ( post type ) to generate */
DEFINE( 'TOOLS_POSTTYPE_MAIN', 'digi-group' );
DEFINE( 'TOOLS_POSTTYPE_SUB', 'digi-workunit' );

/**	Inclusion des controlleurs principaux du module / Include main module controller	*/
include( TOOLS_PATH . '/controller/tools.controller.01.php' );
include( TOOLS_PATH . '/action/tools.action.01.php' );
