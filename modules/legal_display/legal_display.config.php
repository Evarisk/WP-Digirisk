<?php
/**
* LEGAL_DISPLAY_VERSION : The module version
* LEGAL_DISPLAY_DIR : The directory path to the module
* LEGAL_DISPLAY_PATH : The path to the module
* LEGAL_DISPLAY_URL : The url to the module
* LEGAL_DISPLAY_VIEW_DIR : The path to the folder view of the module
* LEGAL_DISPLAY_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package legal_display
* @subpackage legal_display
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'LEGAL_DISPLAY_VERSION', '0.1');
DEFINE( 'LEGAL_DISPLAY_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'LEGAL_DISPLAY_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'LEGAL_DISPLAY_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', LEGAL_DISPLAY_PATH ) );
DEFINE( 'LEGAL_DISPLAY_VIEW_DIR', LEGAL_DISPLAY_PATH . '/view/');
DEFINE( 'LEGAL_DISPLAY_MODEL', LEGAL_DISPLAY_PATH . '/model/');
DEFINE( 'LEGAL_DISPLAY_STATE', false);
?>
