<?php if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'GROUP_VERSION', 				'1.0');
DEFINE( 'GROUP_DIR', 						basename(dirname(__FILE__)));
DEFINE( 'GROUP_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'GROUP_PATH', 					str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'GROUP_URL', 						str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', GROUP_PATH ) );
DEFINE( 'GROUP_VIEW_DIR', 			GROUP_PATH . '/view/');
