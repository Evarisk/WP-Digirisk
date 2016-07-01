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
DEFINE( 'USERS_VERSION', '1.0');

/**     Définition des constantes pour le module / Define constant for module  */
DEFINE( 'USERS_DIR', basename(dirname(__FILE__)));
DEFINE( 'USERS_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'USERS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'USERS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', USERS_PATH ) );

/**     Définition du chemin absolu vers les templates / Define the templates absolute directories     */
DEFINE( 'USERS_VIEW', USERS_PATH . '/view/');

?>
