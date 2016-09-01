<?php
/**
* FILE8MANAGEMENT_VERSION : The module version
* FILE8MANAGEMENT_DIR : The directory path to the module
* FILE8MANAGEMENT_PATH : The path to the module
* FILE8MANAGEMENT_URL : The url to the module
* FILE8MANAGEMENT_VIEW_DIR : The path to the folder view of the module
* FILE8MANAGEMENT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package /
* @subpackage /
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'FILE_MANAGEMENT_VERSION', '0.1');
DEFINE( 'FILE_MANAGEMENT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'FILE_MANAGEMENT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'FILE_MANAGEMENT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', FILE_MANAGEMENT_PATH ) );
DEFINE( 'FILE_MANAGEMENT_VIEW_DIR', FILE_MANAGEMENT_PATH . '/view/');
DEFINE( 'FILE_MANAGEMENT_MODEL', FILE_MANAGEMENT_PATH . '/model/');
DEFINE( 'FILE_MANAGEMENT_STATE', true );
?>
