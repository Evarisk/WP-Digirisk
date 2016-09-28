<?php
/**
* ADDRESS_VERSION : The module version
* ADDRESS_DIR : The directory path to the module
* ADDRESS_PATH : The path to the module
* ADDRESS_URL : The url to the module
* ADDRESS_VIEW_DIR : The path to the folder view of the module
* ADDRESS_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package address
* @subpackage address
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'ADDRESS_VERSION', '0.1');
DEFINE( 'ADDRESS_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'ADDRESS_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'ADDRESS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', ADDRESS_PATH ) );
DEFINE( 'ADDRESS_VIEW_DIR', ADDRESS_PATH . '/view/');
DEFINE( 'ADDRESS_MODEL', ADDRESS_PATH . '/model/');
DEFINE( 'ADDRESS_STATE', false );
?>
