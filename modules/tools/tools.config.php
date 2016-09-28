<?php
/**
* TOOLS_VERSION : The module version
* TOOLS_DIR : The directory path to the module
* TOOLS_PATH : The path to the module
* TOOLS_URL : The url to the module
* TOOLS_VIEW_DIR : The path to the folder view of the module
* TOOLS_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package tools
* @subpackage tools
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'TOOLS_VERSION', '0.1');
DEFINE( 'TOOLS_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'TOOLS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'TOOLS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', TOOLS_PATH ) );
DEFINE( 'TOOLS_VIEW_DIR', TOOLS_PATH . '/view/');
DEFINE( 'TOOLS_MODEL', TOOLS_PATH . '/model/');
DEFINE( 'TOOLS_STATE', false);
?>
