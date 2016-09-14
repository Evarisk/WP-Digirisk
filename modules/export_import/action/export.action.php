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
class export_action {

	private $export_directory;

	public function __construct() {
		/** Enqueue les javascripts pour l'administration / Enqueue scripts into backend */
		// add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ) );

		/** Ecoute l'événement ajax d'export des données / Listen ajax event for datas export */
		add_action( 'wp_ajax_digi_export_data', array( $this, 'callback_export_data' ) );

		/** Définition des chemins vers les exports / Define path where export will be saved */
		$wp_upload_dir = wp_upload_dir();
		$this->export_directory = $wp_upload_dir[ 'basedir' ] . '/digirisk/export/';
		wp_mkdir_p( $this->export_directory );
	}

	/**
	 * Fonction de rappel des javascripts pour l'administration / Callback fonction for backend javascripts
	 */
	public function callback_admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( ( 'toplevel_page_digirisk-simple-risk-evaluation' == $screen->id ) || ( 'tools_page_digirisk-tools' == $screen->id ) ) {
			wp_enqueue_script( 'digi-export-js', WPDIGI_IMPEXP_URL . 'asset/js/export_import.backend.js', array(), WPDIGI_IMPEXP_VERSION, false );
		}
	}

	/**
	 * Fonction de rappel pour l'export des données / Callback function for exporting datas
	 */
	public function callback_export_data() {
		check_ajax_referer( 'digi_export_data' );

		$response = array(
			'message' => __( 'Digirisk datas exported successfully', 'digirisk' ),
		);

		$list_group = group_class::g()->get(
			array(
				'posts_per_page' => 5,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group', 'list_workunit', 'list_risk', 'danger', 'danger_category', 'comment', 'evaluation', 'evaluation_method' ) );
		$list_data_exported = array();



		if ( !empty( $list_group ) ) {
		  foreach ( $list_group as $element ) {
				$element_to_export = new wpeo_export_class( $element );
				$list_data_exported[] = $element_to_export->export();
		  }
		}



		$current_time = current_time( 'YmdHis' );
		$filename = 'global';
		$export_base = $this->export_directory . $current_time . '_' . $filename . '_export';
		$json_filename = $export_base . '.json';
		file_put_contents( $json_filename, json_encode( $list_data_exported, JSON_PRETTY_PRINT ) );

		/** Ajout du fichier json au fichier zip / Add the json file to zip file */
		$sub_response = document_class::g()->create_zip( $export_base . '.zip', array( array( 'link' => $json_filename, 'filename' => basename( $json_filename ) ) ), $element, null );
		$response = array_merge( $response, $sub_response );

		/** Suppression du fichier json après l'enregistrement dans le fichier zip / Delete the json file after zip saving */
		@unlink( $json_filename );
		$upload_dir = wp_upload_dir();
		$response['url_to_file'] = $upload_dir['baseurl'] . '/digirisk/export/' . $current_time . '_' . $filename . '_export.zip';
		$response['filename'] = current_time( 'YmdHis' ) . '_' . $filename . '_export.zip';
		wp_send_json_success( $response );
	}

}

new export_action();
