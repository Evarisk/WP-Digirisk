<?php
/**
* WPEO_EXPORT_VERSION : The module version
* WPEO_EXPORT_DIR : The directory path to the module
* WPEO_EXPORT_PATH : The path to the module
* WPEO_EXPORT_URL : The url to the module
* WPEO_EXPORT_VIEW_DIR : The path to the folder view of the module
* WPEO_EXPORT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1.0.0
* @copyright 2015-2016 Eoxia
* @package wpeo_export
* @subpackage wpeo_export
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'WPEO_EXPORT_VERSION', "0.1.0.0" );
DEFINE( 'WPEO_EXPORT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'WPEO_EXPORT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPEO_EXPORT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPEO_EXPORT_PATH ) );
DEFINE( 'WPEO_EXPORT_CORE_OPTION_NAME', '_digirisk_core' );
DEFINE( 'WPEO_EXPORT_DEBUG', false );
