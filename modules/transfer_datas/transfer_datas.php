<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Bootstrap file
 *
 * @author Development team <dev@eoxia.com>
 * @version 1.0
 */

/**
 * Define the current version for the plugin. Interresting for clear cache for plugin style and script
 * @var string Plugin current version number
 */
DEFINE('DIGI_DTRANS_VERSION', '1.0');

/**
 * Get the plugin main dirname. Allows to avoid writing path directly into code
 * @var string Dirname of the plugin
 */
DEFINE('DIGI_DTRANS_DIR', basename( dirname( __FILE__ ) ) );
DEFINE('DIGI_DTRANS_PATH', str_replace( DIGI_DTRANS_DIR, "", dirname( __FILE__ ) ) );
DEFINE('DIGI_DTRANS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', str_replace( "\\", "/", DIGI_DTRANS_PATH ) ) );

/**	Load plugin translation	*/
load_plugin_textdomain( 'wp-digi-dtrans-i18n', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**	Define the templates directories	*/
DEFINE( 'DIGI_DTRANS_TEMPLATES_MAIN_DIR', DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/templates/' );

/**	Define digirisk main database version number in order to display transfer menu	*/
$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );

if ( empty( $digirisk_core['installed'] ) && getDbOption( 'base_evarisk' ) > 0 ) {
	/** Plugin initialisation */
	/**	Define transfer vars	*/
	DEFINE( 'DIGI_DTRANS_NB_ELMT_PER_PAGE', 10 );
	DEFINE( 'DIGI_DTRANS_MEDIAN_MAX_STEP', 3 );
	DEFINE( 'DIGI_DTRANS_MAX_STEP', 4 );

	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData.controller.01.php' );
	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData_components.controller.01.php' );
	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData_ajax.controller.01.php' );
	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData_common.controller.01.php' );
	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData_task.controller.01.php' );
	require_once( DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/controller/TransferData_groupement.controller.01.php' );
}
