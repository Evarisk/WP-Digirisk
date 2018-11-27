<?php
/**
 * Plugin Name: Digirisk
 * Plugin URI:  http://www.evarisk.com/document-unique-logiciel
 * Description: Avec le plugin Digirisk vous pourrez réaliser, de façon simple et intuitive, le ou les documents uniques de vos entreprises et gérer toutes les données liées à la sécurité de votre personnel.
 * Version:     7.0.2
 * Author:      Evarisk
 * Author URI:  http://www.evarisk.com
 * License:     AGPLv3
 * License URI: https://spdx.org/licenses/AGPL-3.0-or-later.html
 * Domain Path: /core/assets/languages
 * Text Domain: digirisk
 *
 * @package DigiRisk.
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

DEFINE( 'PLUGIN_DIGIRISK_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_DIR', basename( __DIR__ ) );

require_once 'core/external/eo-framework/eo-framework.php';

$active_plugins   = get_option( 'active_plugins' );
$key_task_manager = false;

if ( ! empty( $active_plugins ) ) {
	foreach ( $active_plugins as $key => $active_plugin ) {
		if ( strpos( $active_plugin, 'task-manager.php' ) != 0 ) {
			$key_task_manager = $key;
		}
	}
}

if ( false !== $key_task_manager ) {
	array_splice( $active_plugins, $key, 1 );
	update_option( 'active_plugins', $active_plugins );
} else {
	\eoxia\Init_Util::g()->exec( PLUGIN_DIGIRISK_PATH, basename( __FILE__, '.php' ) );

	register_activation_hook( __FILE__, array( Digirisk::g(), 'activation' ) );
}
