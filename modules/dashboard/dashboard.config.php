<?php
/**
* DASHBOARD_VERSION : The module version
* DASHBOARD_DIR : The directory path to the module
* DASHBOARD_PATH : The path to the module
* DASHBOARD_URL : The url to the module
* DASHBOARD_VIEW_DIR : The path to the folder view of the module
* DASHBOARD_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package dashboard
* @subpackage dashboard
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'DASHBOARD_VERSION', '0.1');
DEFINE( 'DASHBOARD_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'DASHBOARD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'DASHBOARD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', DASHBOARD_PATH ) );
DEFINE( 'DASHBOARD_VIEW_DIR', DASHBOARD_PATH . '/view/');
DEFINE( 'DASHBOARD_MODEL', DASHBOARD_PATH . '/model/');
DEFINE( 'DASHBOARD_STATE', false);
?>
