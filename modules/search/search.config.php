<?php
/**
* SEARCH_VERSION : The module version
* SEARCH_DIR : The directory path to the module
* SEARCH_PATH : The path to the module
* SEARCH_URL : The url to the module
* SEARCH_VIEW_DIR : The path to the folder view of the module
* SEARCH_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package search
* @subpackage search
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'SEARCH_VERSION', '0.1');
DEFINE( 'SEARCH_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'SEARCH_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'SEARCH_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', SEARCH_PATH ) );
DEFINE( 'SEARCH_VIEW_DIR', SEARCH_PATH . '/view/');
DEFINE( 'SEARCH_MODEL', SEARCH_PATH . '/model/');
DEFINE( 'SEARCH_STATE', false);
?>
