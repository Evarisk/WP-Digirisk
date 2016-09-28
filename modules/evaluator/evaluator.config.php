<?php
/**
* EVALUATOR_VERSION : The module version
* EVALUATOR_DIR : The directory path to the module
* EVALUATOR_PATH : The path to the module
* EVALUATOR_URL : The url to the module
* EVALUATOR_VIEW_DIR : The path to the folder view of the module
* EVALUATOR_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluator
* @subpackage evaluator
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'EVALUATOR_VERSION', '0.1');
DEFINE( 'EVALUATOR_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'EVALUATOR_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'EVALUATOR_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', EVALUATOR_PATH ) );
DEFINE( 'EVALUATOR_VIEW_DIR', EVALUATOR_PATH . '/view/');
DEFINE( 'EVALUATOR_MODEL', EVALUATOR_PATH . '/model/');
DEFINE( 'EVALUATOR_STATE', false);
?>
