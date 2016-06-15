<?php
/*
Plugin Name: Digirisk
Plugin URI:  http://www.evarisk.com/document-unique-logiciel
Description: Avec le plugin Digirisk vous pourrez réaliser, de façon simple et intuitive, le ou les documents uniques de vos entreprises et gérer toutes les données liées à la sécurité de votre personnel.
Version:     6.1.2.0
Author:      Evarisk
Author URI:  http://www.evarisk.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /core/assets/languages
Text Domain: wpdigi-i18n
*/

DEFINE( 'EVA_PLUGIN_VERSION', '6.1.2.0');

/**	New plugin definition way	*/
DEFINE( 'WPDIGI_VERSION', EVA_PLUGIN_VERSION );
DEFINE( 'WPDIGI_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'WPDIGI_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_PATH ) );
DEFINE( 'WPDIGI_CORE_OPTION_NAME', '_digirisk_core' );

/**	Chargement des fichiers de traductions / Load plugin translation	*/
load_plugin_textdomain( 'wpdigi-i18n', false, dirname( plugin_basename( __FILE__ ) ) . '/core/assets/languages/' );

/**	Chargement de la gestion des modules automatique / Load modules automatic management	*/
include_once( WPDIGI_PATH . 'core/module_management/module_management.php');

/**	Appel automatique des modules présent dans le plugin / Install automatically modules into module directory	*/
digi_module_management::extra_modules();

/**	Instancation principale de l'extension digirisk pour wordpress / Main instanciation of digirisk plugin for wordpress	*/
require_once( WPDIGI_PATH . 'core/digirisk/digirisk.ctr.01.php' );
require_once( WPDIGI_PATH . 'core/digirisk/digirisk.action.01.php' );
$wp_digirisk = new digirisk_controller_01();

/**	Lors de l'activation de l'extension on créé les contenus par défaut / When plugin is activated create default content	*/
register_activation_hook( __FILE__, array( $wp_digirisk, 'activation' ) );

/**	Instanciation des composants du module digirisk / Instaciate digirisk components spécifications	*/
/**	Choix de l'onglet par défaut pour les unité de travail / Choose default tab displayed for workunit	*/
add_filter( 'wpdigi_workunit_default_tab', function( $default ) {
	$current_tab = !empty( $_REQUEST['current_tab'] ) ? sanitize_text_field( $_REQUEST['current_tab'] ) : 'digi-risk';
	return $current_tab;
}, 1 );
add_filter( 'wpdigi_group_default_tab', function( $default ) {
	$current_tab = !empty( $_REQUEST['current_tab'] ) ? sanitize_text_field( $_REQUEST['current_tab'] ) : 'legal-display';
	return $current_tab;
}, 1 );

add_filter( 'upload_size_limit', 'change_upload_size', 10, 3 );
function change_upload_size( $current_min, $upload_max_filesize, $post_max_size ) {
	return '10240000000';
}
