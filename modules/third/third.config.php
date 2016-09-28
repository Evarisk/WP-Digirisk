<?php
/**
* THIRD_VERSION : The module version
* THIRD_DIR : The directory path to the module
* THIRD_PATH : The path to the module
* THIRD_URL : The url to the module
* THIRD_VIEW_DIR : The path to the folder view of the module
* THIRD_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package third
* @subpackage third
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'THIRD_VERSION', '0.1');
DEFINE( 'THIRD_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'THIRD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'THIRD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', THIRD_PATH ) );
DEFINE( 'THIRD_VIEW_DIR', THIRD_PATH . '/view/');
DEFINE( 'THIRD_MODEL', THIRD_PATH . '/model/');
DEFINE( 'THIRD_STATE', false);
?>
