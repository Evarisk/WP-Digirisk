<?php
/**
* INSTALLER_VERSION : The module version
* INSTALLER_DIR : The directory path to the module
* INSTALLER_PATH : The path to the module
* INSTALLER_URL : The url to the module
* INSTALLER_VIEW_DIR : The path to the folder view of the module
* INSTALLER_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package installer
* @subpackage installer
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'INSTALLER_VERSION', '0.1');
DEFINE( 'INSTALLER_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'INSTALLER_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'INSTALLER_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', INSTALLER_PATH ) );
DEFINE( 'INSTALLER_VIEW_DIR', INSTALLER_PATH . '/view/');
DEFINE( 'INSTALLER_MODEL', INSTALLER_PATH . '/model/');
DEFINE( 'INSTALLER_STATE', false);
?>
