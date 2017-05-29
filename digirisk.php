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
 * Version:     6.2.9.1
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

require_once 'core/util/singleton.util.php';
require_once 'core/util/init.util.php';
require_once 'core/helper/model.helper.php';
require_once 'core/external/wpeo_log/class/log.class.php';

log_class::g()->start_ms( 'digi_boot' );
Init_util::g()->exec();
log_class::g()->exec( 'digi_boot', 'digi_boot', 'Boot l\'application Digirisk' );

/** Call WordPress hook when the plugin is activaed */
register_activation_hook( __FILE__, array( Digirisk_Class::g(), 'activation' ) );
