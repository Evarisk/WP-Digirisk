<?php
/**
* EPI_VERSION : The module version
* EPI_DIR : The directory path to the module
* EPI_PATH : The path to the module
* EPI_URL : The url to the module
* EPI_VIEW_DIR : The path to the folder view of the module
* EPI_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package epi
* @subpackage epi
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'EPI_VERSION', '0.1');
DEFINE( 'EPI_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'EPI_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'EPI_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', EPI_PATH ) );
DEFINE( 'EPI_VIEW_DIR', EPI_PATH . '/view/');
DEFINE( 'EPI_MODEL', EPI_PATH . '/model/');
DEFINE( 'EPI_STATE', false );
?>
