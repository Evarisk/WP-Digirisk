<?php
/**
 * Fichier boot du framework
 *
 * @package EO-Framework
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Init_Util' ) ) {
	DEFINE( 'PLUGIN_EO_FRAMEWORK_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
	DEFINE( 'PLUGIN_EO_FRAMEWORK_URL', plugins_url( basename( __DIR__ ) ) . '/' );
	DEFINE( 'PLUGIN_EO_FRAMEWORK_DIR', basename( __DIR__ ) );

	require_once( 'core/class/singleton.class.php' );
	require_once( 'core/class/init.class.php' );

	Init_Util::g()->exec( PLUGIN_EO_FRAMEWORK_PATH, basename( __FILE__, '.php' ) );
}
