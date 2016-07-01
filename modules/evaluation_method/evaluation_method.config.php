<?php
/**
* EVALUATION_METHOD_VERSION : The module version
* EVALUATION_METHOD_DIR : The directory path to the module
* EVALUATION_METHOD_PATH : The path to the module
* EVALUATION_METHOD_URL : The url to the module
* EVALUATION_METHOD_VIEW_DIR : The path to the folder view of the module
* EVALUATION_METHOD_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package installer
* @subpackage installer
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'EVALUATION_METHOD_VERSION', '0.1');
DEFINE( 'EVALUATION_METHOD_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'EVALUATION_METHOD_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'EVALUATION_METHOD_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', EVALUATION_METHOD_PATH ) );
DEFINE( 'EVALUATION_METHOD_VIEW', EVALUATION_METHOD_PATH . '/view/');
DEFINE( 'EVALUATION_METHOD_MODEL', EVALUATION_METHOD_PATH . '/model/');
?>
