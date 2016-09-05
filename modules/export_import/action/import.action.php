<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des actions pour l'export des données de Digirisk / File managing actions for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */

/**
 * Classe de gestion des actions pour l'export des données de Digirisk / Class for managing actions for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */
class import_action {
	private $destination_directory;

	public function __construct() {
		add_action( 'wp_ajax_digi_import_data', array( $this, 'callback_import_data' ) );

		$wp_upload_dir = wp_upload_dir();
		$this->destination_directory = $wp_upload_dir[ 'basedir' ] . '/digirisk/export/';
		wp_mkdir_p( $this->destination_directory );
	}

	/**
	 * Fonction de rappel pour l'export des données / Callback function for exporting datas
	 */
	public function callback_import_data() {
		check_ajax_referer( 'digi_import_data' );

		$response = array(
			'message' => __( 'Digirisk datas imported successfully', 'digirisk' ),
		);

		if ( empty( $_FILES ) || empty( $_FILES['file'] ) ) {
			wp_send_json_error();
		}

		$zip_file = $_FILES['file'];

		$zip_info = zip_util::g()->unzip( $zip_file['tmp_name'], $this->destination_directory );
		if ( !$zip_info['state'] && empty( $zip_info['list_file'][0] ) ) {
			wp_send_json_error();
		}

		$danger_created = danger_default_data_class::g()->create();
		$recommendation_created = recommendation_default_data_class::g()->create();
		$evaluation_method_created = evaluation_method_default_data_class::g()->create();

		$file_content = file_get_contents( $this->destination_directory . $zip_info['list_file'][0] );
		$data = json_decode( $file_content, true );
		import_class::g()->create( $data );

		update_option( WPDIGI_CORE_OPTION_NAME, array( 'installed' => true, 'db_version' => 1 ) );

		wp_send_json_success( $response );
	}

}

new import_action();
