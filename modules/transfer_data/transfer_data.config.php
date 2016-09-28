<?php
/**
* TRANSFER_DATA_VERSION : The module version
* TRANSFER_DATA_DIR : The directory path to the module
* TRANSFER_DATA_PATH : The path to the module
* TRANSFER_DATA_URL : The url to the module
* TRANSFER_DATA_VIEW_DIR : The path to the folder view of the module
* TRANSFER_DATA_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage document
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'TRANSFER_DATA_VERSION', '0.1');
DEFINE( 'TRANSFER_DATA_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'TRANSFER_DATA_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'TRANSFER_DATA_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', TRANSFER_DATA_PATH ) );
DEFINE( 'TRANSFER_DATA_VIEW_DIR', TRANSFER_DATA_PATH . '/view/');
DEFINE( 'TRANSFER_DATA_MODEL', TRANSFER_DATA_PATH . '/model/');
DEFINE( 'TRANSFER_DATA_STATE', false);
?>
