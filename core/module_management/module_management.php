<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Module bootstrap file
 * @author Eoxia development team <dev@eoxia.com>
 * @version 1.0
 */

/*	Check if file is include. No direct access possible with file url	*/
if ( !defined( 'EVA_PLUGIN_VERSION' ) ) {
	die( __('Access is not allowed by this way', 'digi-modmanager-i18n') );
}

if ( !defined( 'DIGIMODMAN_VERSION' ) ) {
	/**
	 * Define the current version for the plugin. Interresting for clear cache for plugin style and script
	 * @var string Plugin current version number
	 */
	DEFINE( 'DIGIMODMAN_VERSION', '1.0');

	/**	Définition des constantes pour le module / Define constant for module	*/
	DEFINE( 'DIGIMODMAN_DIR', basename(dirname(__FILE__)));
	DEFINE( 'DIGIMODMAN_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
	DEFINE( 'DIGIMODMAN_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
	DEFINE( 'DIGIMODMAN_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', DIGIMODMAN_PATH ) );

	/**	Appel des traductions pour le module / Call translation for module	*/
	load_plugin_textdomain( 'digi-modmanager-i18n', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	/**	Définition du chemin absolu vers les templates / Define the templates absolute directories	*/
	DEFINE( 'DIGIMODMAN_TEMPLATES_MAIN_DIR', DIGIMODMAN_PATH . '/templates/');

	include( DIGIMODMAN_PATH . '/controller/module_management.ctr.php' );
	$digi_module_management  = new digi_module_management();

	digi_module_management::core_util();
}
