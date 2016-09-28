<?php
/**
* WORKUNIT_VERSION : The module version
* WORKUNIT_DIR : The directory path to the module
* WORKUNIT_PATH : The path to the module
* WORKUNIT_URL : The url to the module
* WORKUNIT_VIEW_DIR : The path to the folder view of the module
* WORKUNIT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package workunit
* @subpackage workunit
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'WORKUNIT_VERSION', '0.1');
DEFINE( 'WORKUNIT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'WORKUNIT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WORKUNIT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WORKUNIT_PATH ) );
DEFINE( 'WORKUNIT_VIEW_DIR', WORKUNIT_PATH . '/view/');
DEFINE( 'WORKUNIT_MODEL', WORKUNIT_PATH . '/model/');
DEFINE( 'WORKUNIT_STATE', false);
?>
