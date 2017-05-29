<?php
/**
 * Les actions relatives à l'export du CSV.
 *
 * @since 6.2.6.0
 * @version 6.2.9.0
 *
 * @package export_import
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Les actions relatives à l'export du CSV
 */
class Export_CSV_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.6.0
	 * @version 6.2.6.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_digi_export_csv_data', array( $this, 'callback_export_csv_data' ) );

	}

	/**
	 * Gères la communication entre la classe et le JavaScript pour exporter les risques au format CSV.
	 *
	 * @since 6.2.6.0
	 * @version 6.2.6.0
	 */
	public function callback_export_csv_data() {
		check_ajax_referer( 'digi_export_csv_data' );
		ini_set( 'memory_limit', '-1' );

		$offset = ! empty( $_POST['offset'] ) ? (int) $_POST['offset'] : 0;
		$number_risks = ! empty( $_POST['number_risks'] ) ? (int) $_POST['number_risks'] : 0;
		$filepath = ! empty( $_POST['filepath'] ) ? stripslashes( sanitize_text_field( $_POST['filepath'] ) ) : '';
		$filename = ! empty( $_POST['filename'] ) ? stripslashes( sanitize_text_field( $_POST['filename'] ) ) : '';
		$url_to_file = ! empty( $_POST['url_to_file'] ) ? stripslashes( sanitize_text_field( $_POST['url_to_file'] ) ) : '';

		$response = Export_CSV_Class::g()->exec( array(
			'offset' => $offset,
			'number_risks' => $number_risks,
			'filepath' => $filepath,
			'filename' => $filename,
			'url_to_file' => $url_to_file,
		) );

		wp_send_json_success( $response );
	}

}

new Export_CSV_Action();
