<?php if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'SETTING_VERSION', 				'1.0');
DEFINE( 'SETTING_DIR', 						basename(dirname(__FILE__)));
DEFINE( 'SETTING_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'SETTING_PATH', 					str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'SETTING_URL', 						str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', SETTING_PATH ) );
DEFINE( 'SETTING_VIEW_DIR', 			SETTING_PATH . '/view/');
DEFINE( 'SETTING_OPTION_NAME_ACCRONYM', '_digirisk_accronym' );
