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
DEFINE( 'USER_DASHBOARD_VERSION', '1.0');

/**     Définition des constantes pour le module / Define constant for module  */
DEFINE( 'USER_DASHBOARD_DIR', basename(dirname(__FILE__)));
DEFINE( 'USER_DASHBOARD_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'USER_DASHBOARD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'USER_DASHBOARD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', USER_DASHBOARD_PATH ) );

/**     Définition du chemin absolu vers les templates / Define the templates absolute directories     */
DEFINE( 'USER_DASHBOARD_VIEW', USER_DASHBOARD_PATH . 'view/');

?>
