<?php
/**
* ACCIDENT_VERSION : The module version
* ACCIDENT_DIR : The directory path to the module
* ACCIDENT_PATH : The path to the module
* ACCIDENT_URL : The url to the module
* ACCIDENT_VIEW_DIR : The path to the folder view of the module
* ACCIDENT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package accident
* @subpackage accident
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'ACCIDENT_VERSION', '0.1');
DEFINE( 'ACCIDENT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'ACCIDENT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'ACCIDENT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', ACCIDENT_PATH ) );
DEFINE( 'ACCIDENT_VIEW_DIR', ACCIDENT_PATH . '/view/');
DEFINE( 'ACCIDENT_MODEL', ACCIDENT_PATH . '/model/');
DEFINE( 'ACCIDENT_STATE', false );
?>
