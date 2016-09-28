<?php
/**
* RECOMMENDATION_VERSION : The module version
* RECOMMENDATION_DIR : The directory path to the module
* RECOMMENDATION_PATH : The path to the module
* RECOMMENDATION_URL : The url to the module
* RECOMMENDATION_VIEW_DIR : The path to the folder view of the module
* RECOMMENDATION_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage document
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'RECOMMENDATION_VERSION', '0.1');
DEFINE( 'RECOMMENDATION_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'RECOMMENDATION_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'RECOMMENDATION_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', RECOMMENDATION_PATH ) );
DEFINE( 'RECOMMENDATION_VIEW_DIR', RECOMMENDATION_PATH . '/view/');
DEFINE( 'RECOMMENDATION_MODEL', RECOMMENDATION_PATH . '/model/');
DEFINE( 'RECOMMENDATION_STATE', false);
?>
