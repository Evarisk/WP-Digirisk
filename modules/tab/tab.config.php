<?php
/**
* TAB_VERSION : The module version
* TAB_DIR : The directory path to the module
* TAB_PATH : The path to the module
* TAB_URL : The url to the module
* TAB_VIEW_DIR : The path to the folder view of the module
* TAB_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package tab
* @subpackage tab
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'TAB_VERSION', '0.1');
DEFINE( 'TAB_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'TAB_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'TAB_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', TAB_PATH ) );
DEFINE( 'TAB_VIEW_DIR', TAB_PATH . '/view/');
