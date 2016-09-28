<?php
/**
* SETTING_VERSION : The module version
* SETTING_DIR : The directory path to the module
* SETTING_PATH : The path to the module
* SETTING_URL : The url to the module
* SETTING_VIEW_DIR : The path to the folder view of the module
* SETTING_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package setting
* @subpackage setting
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'SETTING_VERSION', '0.1');
DEFINE( 'SETTING_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'SETTING_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'SETTING_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', SETTING_PATH ) );
DEFINE( 'SETTING_VIEW_DIR', SETTING_PATH . '/view/');
DEFINE( 'SETTING_MODEL', SETTING_PATH . '/model/');
DEFINE( 'SETTING_STATE', false);
?>
