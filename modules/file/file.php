<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Bootstrap file for plugin. Do main includes and create new instance for plugin components
 *
 * @author Eoxia <dev@eoxia.com>
 * @version 1.0
 */

DEFINE( 'WPEOMTM_FILES_VERSION', '1.0' );
DEFINE( 'WPEOMTM_FILES_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPEOMTM_FILES_PATH', dirname( __FILE__ ) );
DEFINE( 'WPEOMTM_FILES_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', str_replace( "\\", "/", WPEOMTM_FILES_PATH ) ) );

/**	Define the templates directories	*/
DEFINE( 'WPEOMTM_FILES_TEMPLATES_MAIN_DIR', WPEOMTM_FILES_PATH . '/templates/');

require_once( WPEOMTM_FILES_PATH . '/controller/file.controller.01.php' );
require_once( WPEOMTM_FILES_PATH . '/controller/file.action.01.php' );

/**	Instanciate task management*/
$wpdigi_file_ctr = new wpdigi_file_ctr_01();
