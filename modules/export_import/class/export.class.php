<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/
class export_class extends singleton_util {

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

	public function get_full_data_for_export( $group ) {

	}

	public function generate_zip() {
		$current_time = current_time( 'YmdHis' );
		$filename = 'global';
		$export_base = $this->export_directory . $current_time . '_' . $filename . '_export';
		$json_filename = $export_base . '.json';
		file_put_contents( $json_filename, wp_json_encode( $list_data_exported, JSON_PRETTY_PRINT ) );

		/** Ajout du fichier json au fichier zip / Add the json file to zip file */
		$sub_response = document_class::g()->create_zip( $export_base . '.zip', array( array( 'link' => $json_filename, 'filename' => basename( $json_filename ) ) ), $element, null );
		$response = array_merge( $response, $sub_response );

		/** Suppression du fichier json après l'enregistrement dans le fichier zip / Delete the json file after zip saving */
		@unlink( $json_filename );
		$upload_dir = wp_upload_dir();
		$response['url_to_file'] = $upload_dir['baseurl'] . '/digirisk/export/' . $current_time . '_' . $filename . '_export.zip';
		$response['filename'] = current_time( 'YmdHis' ) . '_' . $filename . '_export.zip';
	}
}
