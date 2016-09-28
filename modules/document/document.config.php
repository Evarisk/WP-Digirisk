<?php
/**
* DOCUMENT_VERSION : The module version
* DOCUMENT_DIR : The directory path to the module
* DOCUMENT_PATH : The path to the module
* DOCUMENT_URL : The url to the module
* DOCUMENT_VIEW_DIR : The path to the folder view of the module
* DOCUMENT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage document
*/
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'DOCUMENT_VERSION', '0.1');
DEFINE( 'DOCUMENT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'DOCUMENT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'DOCUMENT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', DOCUMENT_PATH ) );
DEFINE( 'DOCUMENT_VIEW_DIR', DOCUMENT_PATH . '/view/');
DEFINE( 'DOCUMENT_MODEL', DOCUMENT_PATH . '/model/');
DEFINE( 'DOCUMENT_STATE', false);
?>
