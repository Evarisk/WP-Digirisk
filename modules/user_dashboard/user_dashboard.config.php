<?php
/**
* USER_DASHBOARD_VERSION : The module version
* USER_DASHBOARD_DIR : The directory path to the module
* USER_DASHBOARD_PATH : The path to the module
* USER_DASHBOARD_URL : The url to the module
* USER_DASHBOARD_VIEW_DIR : The path to the folder view of the module
* USER_DASHBOARD_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user_dashboard
* @subpackage user_dashboard
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'USER_DASHBOARD_VERSION', '0.1');
DEFINE( 'USER_DASHBOARD_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'USER_DASHBOARD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'USER_DASHBOARD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', USER_DASHBOARD_PATH ) );
DEFINE( 'USER_DASHBOARD_VIEW_DIR', USER_DASHBOARD_PATH . '/view/');
DEFINE( 'USER_DASHBOARD_MODEL', USER_DASHBOARD_PATH . '/model/');
DEFINE( 'USER_DASHBOARD_STATE', false);
?>
