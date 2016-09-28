<?php
/**
* SOCIETY_VERSION : The module version
* SOCIETY_DIR : The directory path to the module
* SOCIETY_PATH : The path to the module
* SOCIETY_URL : The url to the module
* SOCIETY_VIEW_DIR : The path to the folder view of the module
* SOCIETY_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage society
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'SOCIETY_VERSION', '0.1');
DEFINE( 'SOCIETY_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'SOCIETY_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'SOCIETY_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', SOCIETY_PATH ) );
DEFINE( 'SOCIETY_VIEW_DIR', SOCIETY_PATH . '/view/');
DEFINE( 'SOCIETY_MODEL', SOCIETY_PATH . '/model/');
DEFINE( 'SOCIETY_STATE', false);
?>
