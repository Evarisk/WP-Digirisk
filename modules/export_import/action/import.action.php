<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
class import_action extends singleton_util {
	private $destination_directory;
	public static $response;

	protected function construct() {
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
		ini_set( 'memory_limit', '-1' );

		import_action::$response = array(
			'message' => __( 'Digirisk datas imported successfully', 'digirisk' ),
		);

		if ( empty( $_POST['path_to_json'] ) ) {
			if ( empty( $_FILES ) || empty( $_FILES['file'] ) ) {
				wp_send_json_error();
			}

			$danger_created = danger_default_data_class::g()->create();
			$recommendation_created = recommendation_default_data_class::g()->create();
			$evaluation_method_created = evaluation_method_default_data_class::g()->create();

			// Met à jours l'option pour dire que l'installation est terminée
			update_option( config_util::$init['digirisk']->core_option, array( 'installed' => true, 'db_version' => 1 ) );

			$zip_file = $_FILES['file'];

			$zip_info = zip_util::g()->unzip( $zip_file['tmp_name'], $this->destination_directory );
			if ( !$zip_info['state'] && empty( $zip_info['list_file'][0] ) ) {
				wp_send_json_error();
			}

			$path_to_json = $this->destination_directory . $zip_info['list_file'][0];
		}
		else {
			$path_to_json = sanitize_text_field( $_POST['path_to_json'] );
		}

		import_action::$response['path_to_json'] = str_replace( '\\\\', '/', str_replace( '\\', '/', $path_to_json) );
		$file_content = file_get_contents( $path_to_json );
		$data = json_decode( $file_content, true );
		import_action::$response['count_element'] = array_util::g()->count_recursive( $data, true, array( 'list_group', 'list_workunit', 'danger', 'comment', 'list_risk', 'danger_category', 'evaluation_method', 'variable', 'evaluation' ) ) + 1;
		import_action::$response['index_element'] = (int) $_POST['index_element'];

		import_class::g()->create( $data );

		wp_send_json_success( import_action::$response );
	}

	public function fast_response( $end = false ) {
		import_action::$response['end'] = $end;
		if ( import_action::$response['end'] ) {
			tools_class::g()->reset_method_evaluation();
		}
		wp_send_json_success( import_action::$response );
	}
}

import_action::g();
