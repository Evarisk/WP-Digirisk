<?php
/**
* CHEMICAL_PRODUCT_VERSION : The module version
* CHEMICAL_PRODUCT_DIR : The directory path to the module
* CHEMICAL_PRODUCT_PATH : The path to the module
* CHEMICAL_PRODUCT_URL : The url to the module
* CHEMICAL_PRODUCT_VIEW_DIR : The path to the folder view of the module
* CHEMICAL_PRODUCT_MODEL : The path to the folder model of the module
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package chemical_product
* @subpackage chemical_product
*/

if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'CHEMICAL_PRODUCT_VERSION', '0.1');
DEFINE( 'CHEMICAL_PRODUCT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'CHEMICAL_PRODUCT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'CHEMICAL_PRODUCT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', CHEMICAL_PRODUCT_PATH ) );
DEFINE( 'CHEMICAL_PRODUCT_VIEW_DIR', CHEMICAL_PRODUCT_PATH . '/view/');
DEFINE( 'CHEMICAL_PRODUCT_MODEL', CHEMICAL_PRODUCT_PATH . '/model/');
DEFINE( 'CHEMICAL_PRODUCT_STATE', false );
?>
