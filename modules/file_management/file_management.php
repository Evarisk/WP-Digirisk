<?php if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'FILE_MANAGEMENT_VERSION', '0.1');
DEFINE( 'FILE_MANAGEMENT_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'FILE_MANAGEMENT_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'FILE_MANAGEMENT_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', FILE_MANAGEMENT_PATH ) );
DEFINE( 'FILE_MANAGEMENT_VIEW_DIR', FILE_MANAGEMENT_PATH . '/view/');
DEFINE( 'FILE_MANAGEMENT_MODEL', FILE_MANAGEMENT_PATH . '/model/');

include( FILE_MANAGEMENT_PATH . '/class/file_management.class.php' );

include( FILE_MANAGEMENT_PATH . '/action/file_management.action.php' );
include( FILE_MANAGEMENT_PATH . '/action/gallery.action.php' );

include( FILE_MANAGEMENT_PATH . '/shortcode/file_management.shortcode.php' );
