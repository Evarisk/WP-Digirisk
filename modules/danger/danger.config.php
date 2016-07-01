<?php
/**
* DANGER_VERSION : The module version
* DANGER_DIR : The directory path to the module
* DANGER_PATH : The path to the module
* DANGER_URL : The url to the module
* DANGER_VIEW_DIR : The path to the folder view of the module
* DANGER_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package danger
* @subpackage danger
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'DANGER_VERSION', '0.1');
DEFINE( 'DANGER_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'DANGER_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'DANGER_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', DANGER_PATH ) );
DEFINE( 'DANGER_VIEW_DIR', DANGER_PATH . '/view/');
DEFINE( 'DANGER_MODEL', DANGER_PATH . '/model/');
?>
