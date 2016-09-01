<?php if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'WORKUNIT_VERSION', 				'1.0');
DEFINE( 'WORKUNIT_DIR', 						basename(dirname(__FILE__)));
DEFINE( 'WORKUNIT_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WORKUNIT_PATH', 					str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WORKUNIT_URL', 						str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WORKUNIT_PATH ) );
DEFINE( 'WORKUNIT_VIEW_DIR', 			WORKUNIT_PATH . '/view/');
