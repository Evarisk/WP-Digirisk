<?php
/**
 * Fichier boot du plugin
 *
 * @package Evarisk\Plugin
 */

namespace digi;

/**
 * Plugin Name: Digirisk
 * Plugin URI:  http://www.evarisk.com/document-unique-logiciel
 * Description: Avec le plugin Digirisk vous pourrez réaliser, de façon simple et intuitive, le ou les documents uniques de vos entreprises et gérer toutes les données liées à la sécurité de votre personnel.
 * Version:     6.6.0
 * Author:      Evarisk
 * Author URI:  http://www.evarisk.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /core/assets/languages
 * Text Domain: digirisk
 */

DEFINE( 'PLUGIN_DIGIRISK_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_DIR', basename( __DIR__ ) );

require_once 'core/external/eo-framework/eo-framework.php';

\eoxia\Init_Util::g()->exec( PLUGIN_DIGIRISK_PATH, basename( __FILE__, '.php' ) );

/** Call WordPress hook when the plugin is activaed */
register_activation_hook( __FILE__, array( Digirisk_Class::g(), 'activation' ) );
