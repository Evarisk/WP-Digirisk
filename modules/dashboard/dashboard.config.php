<?php if ( !defined( 'ABSPATH' ) ) exit;

/** Définition de l'état du module / Define module state */
DEFINE( 'DASHBOARD_STATE', false );

DEFINE( 'WPDIGI_DASHBOARD_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'WPDIGI_DASHBOARD_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_DASHBOARD_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_DASHBOARD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_DASHBOARD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_DASHBOARD_PATH ) );

/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
DEFINE( 'WPDIGI_DASHBOARD_VIEW_DIR', WPDIGI_DASHBOARD_PATH . '/view/');
