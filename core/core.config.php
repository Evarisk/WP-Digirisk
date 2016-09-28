<?php
/**
* CORE_VERSION : The module version
* CORE_DIR : The directory path to the module
* CORE_PATH : The path to the module
* CORE_URL : The url to the module
* CORE_VIEW_DIR : The path to the folder view of the module
* CORE_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package core
* @subpackage core
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'CORE_VERSION', '6.1.5.10' );
DEFINE( 'CORE_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'CORE_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'CORE_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', CORE_PATH ) );
DEFINE( 'CORE_CORE_OPTION_NAME', '_digirisk_core' );
DEFINE( 'CORE_VIEW_DIR', CORE_PATH . 'core/view/' );
DEFINE( 'CORE_MODEL', CORE_PATH . 'core/model/' );
DEFINE( 'CORE_DEBUG', false );
DEFINE( 'CORE_LOG', false );
