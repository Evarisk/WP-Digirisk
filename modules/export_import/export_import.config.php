<?php
/**
* EXPORT_IMPORT_VERSION : The module version
* EXPORT_IMPORT_DIR : The directory path to the module
* EXPORT_IMPORT_PATH : The path to the module
* EXPORT_IMPORT_URL : The url to the module
* EXPORT_IMPORT_VIEW_DIR : The path to the folder view of the module
* EXPORT_IMPORT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package export_import
* @subpackage export_import
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'EXPORT_IMPORT_VERSION', '0.1');
DEFINE( 'EXPORT_IMPORT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'EXPORT_IMPORT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'EXPORT_IMPORT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', EXPORT_IMPORT_PATH ) );
DEFINE( 'EXPORT_IMPORT_VIEW_DIR', EXPORT_IMPORT_PATH . '/view/');
DEFINE( 'EXPORT_IMPORT_MODEL', EXPORT_IMPORT_PATH . '/model/');
DEFINE( 'EXPORT_IMPORT_STATE', false);
?>
