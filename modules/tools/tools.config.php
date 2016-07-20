<?php if ( !defined( 'ABSPATH' ) ) exit;

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
