<?php
/**
 * Bootstrap file
 *
 * @author Development team <dev@evarisk.com>
 * @version 1.0
 */
if ( !defined( 'ABSPATH' ) ) exit;

DEFINE( 'DIGI_DTRANS_VERSION', '1.0' );
DEFINE( 'DIGI_DTRANS_DIR', basename( dirname( __FILE__ ) ) );
DEFINE( 'DIGI_DTRANS_PATH', str_replace( DIGI_DTRANS_DIR, "", dirname( __FILE__ ) ) );
DEFINE( 'DIGI_DTRANS_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', str_replace( "\\", "/", DIGI_DTRANS_PATH ) ) );
DEFINE( 'DIGI_DTRANS_TEMPLATES_MAIN_DIR', DIGI_DTRANS_PATH . DIGI_DTRANS_DIR . '/view/' );
DEFINE( 'DIGI_DTRANS_NB_ELMT_PER_PAGE', 10 );
DEFINE( 'DIGI_DTRANS_MEDIAN_MAX_STEP', 3 );
DEFINE( 'DIGI_DTRANS_MAX_STEP', 4 );
DEFINE( 'TRANSFER_DATA_STATE', false );
