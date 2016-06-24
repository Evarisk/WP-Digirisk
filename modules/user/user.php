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
DEFINE( 'WPDIGI_USERS_VERSION', '1.0');

/**     Définition des constantes pour le module / Define constant for module  */
DEFINE( 'WPDIGI_USERS_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_USERS_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_USERS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_USERS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_USERS_PATH ) );

/**     Définition du chemin absolu vers les templates / Define the templates absolute directories     */
DEFINE( 'WPDIGI_USERS_TEMPLATES_MAIN_DIR', WPDIGI_USERS_PATH . '/template/');

/**     Instanciation du model pour le module / Instanciate the plugin model    */
include( WPDIGI_USERS_PATH . '/model/user.model.01.php' );

/**     Instanciation du module / Instanciate module    */
include( WPDIGI_USERS_PATH . '/controller/user.controller.01.php' );
include( WPDIGI_USERS_PATH . '/controller/user.action.01.php' );

?>
