<?php if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'WPDIGI_STES_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'WPDIGI_STES_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_STES_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_STES_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_STES_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_STES_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'WPDIGI_STES_TEMPLATES_MAIN_DIR', WPDIGI_STES_PATH . '/templates/');
DEFINE( 'SOCIETY_VIEW_DIR', WPDIGI_STES_PATH . '/view/');

/**	Définition des types d'éléments ( post type ) à générer / Define elements types ( post type ) to generate */
DEFINE( 'WPDIGI_STES_POSTTYPE_MAIN', 'digi-group' );
DEFINE( 'WPDIGI_STES_POSTTYPE_SUB', 'digi-workunit' );
