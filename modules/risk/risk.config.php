<?php
/**
* RISK_VERSION : The module version
* RISK_DIR : The directory path to the module
* RISK_PATH : The path to the module
* RISK_URL : The url to the module
* RISK_VIEW_DIR : The path to the folder view of the module
* RISK_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage risk
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'RISK_VERSION', '0.1');
DEFINE( 'RISK_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'RISK_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'RISK_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', RISK_PATH ) );
DEFINE( 'RISK_VIEW_DIR', RISK_PATH . '/view/');
DEFINE( 'RISK_MODEL', RISK_PATH . '/model/');
?>
