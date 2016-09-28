<?php
/**
* USER_VERSION : The module version
* USER_DIR : The directory path to the module
* USER_PATH : The path to the module
* USER_URL : The url to the module
* USER_VIEW_DIR : The path to the folder view of the module
* USER_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user
* @subpackage user
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'USER_VERSION', '0.1');
DEFINE( 'USER_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'USER_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'USER_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', USER_PATH ) );
DEFINE( 'USER_VIEW_DIR', USER_PATH . '/view/');
DEFINE( 'USER_MODEL', USER_PATH . '/model/');
DEFINE( 'USER_STATE', false);
?>
