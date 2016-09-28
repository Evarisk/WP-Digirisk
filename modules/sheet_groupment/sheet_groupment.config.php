<?php
/**
* SHEET_GROUPMENT_VERSION : The module version
* SHEET_GROUPMENT_DIR : The directory path to the module
* SHEET_GROUPMENT_PATH : The path to the module
* SHEET_GROUPMENT_URL : The url to the module
* SHEET_GROUPMENT_VIEW_DIR : The path to the folder view of the module
* SHEET_GROUPMENT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package sheet_groupment
* @subpackage sheet_groupment
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'SHEET_GROUPMENT_VERSION', '0.1');
DEFINE( 'SHEET_GROUPMENT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'SHEET_GROUPMENT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'SHEET_GROUPMENT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', SHEET_GROUPMENT_PATH ) );
DEFINE( 'SHEET_GROUPMENT_VIEW_DIR', SHEET_GROUPMENT_PATH . '/view/');
DEFINE( 'SHEET_GROUPMENT_MODEL', SHEET_GROUPMENT_PATH . '/model/');
DEFINE( 'SHEET_GROUPMENT_STATE', false);
?>
