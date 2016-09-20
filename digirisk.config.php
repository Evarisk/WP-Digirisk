<?php
/**
* WPDIGI_VERSION : The module version
* WPDIGI_DIR : The directory path to the module
* WPDIGI_PATH : The path to the module
* WPDIGI_URL : The url to the module
* WPDIGI_VIEW_DIR : The path to the folder view of the module
* WPDIGI_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package digirisk
* @subpackage digirisk
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'EVA_PLUGIN_VERSION', '6.1.5.10' );

DEFINE( 'WPDIGI_VERSION', EVA_PLUGIN_VERSION );
DEFINE( 'WPDIGI_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'WPDIGI_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_PATH ) );
DEFINE( 'WPDIGI_CORE_OPTION_NAME', '_digirisk_core' );
DEFINE( 'WPDIGI_VIEW_DIR', WPDIGI_PATH . 'core/view/' );
DEFINE( 'WPDIGI_MODEL', WPDIGI_PATH . 'core/model/' );
DEFINE( 'WPDIGI_DEBUG', false );
