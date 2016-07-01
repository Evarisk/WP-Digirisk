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
DEFINE( 'WPDIGI_DOC_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'WPDIGI_DOC_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_DOC_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_DOC_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_DOC_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_DOC_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'WPDIGI_DOC_TEMPLATES_MAIN_DIR', WPDIGI_DOC_PATH . '/templates/');

/**	Définition des types d'éléments ( post type ) à générer / Define elements types ( post type ) to generate */
DEFINE( 'WPDIGI_DOC_POSTTYPE_MAIN', 'digi-group' );
DEFINE( 'WPDIGI_DOC_POSTTYPE_SUB', 'digi-workunit' );
