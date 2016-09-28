<?php
/**
* GROUP_VERSION : The module version
* GROUP_DIR : The directory path to the module
* GROUP_PATH : The path to the module
* GROUP_URL : The url to the module
* GROUP_VIEW_DIR : The path to the folder view of the module
* GROUP_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage document
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'GROUP_VERSION', '0.1');
DEFINE( 'GROUP_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'GROUP_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'GROUP_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', GROUP_PATH ) );
DEFINE( 'GROUP_VIEW_DIR', GROUP_PATH . '/view/');
DEFINE( 'GROUP_MODEL', GROUP_PATH . '/model/');
DEFINE( 'GROUP_STATE', false);
?>
