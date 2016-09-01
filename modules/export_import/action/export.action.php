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
		//
		$group = group_class::g()->get();

		if ( !empty( $group ) ) {
		  foreach ( $group as $element ) {
				$element_to_export = new wpeo_export_class( $element );
				$data_exported = $element_to_export->export();
				echo "<pre>"; print_r($data_exported); echo "</pre>";
		  }
		}


		// $c = danger_category_class::g()->get( array( 'id' => 4 ) );
		// echo $c[0];

		// /** Vérification de l'existence d'un identifiant d'élément pour l'export. Si présent on exportera uniquement cet élément et ses enfants récursivement / Check if an element have been specified for export, if it is the case only this element and its children will be exported */
		// $first_element_id = null;
		// if ( !empty( $_POST && !empty( (int)$_POST[ 'element_id' ] ) && is_int( (int)$_POST[ 'element_id' ] ) ) ) {
		// 	$first_element_id = (int)$_POST[ 'element_id' ];
		// }
		//
		// /** Récupération des types de données a exporter / Get types to export */
		// $what_to_export = null;
		// if ( !empty( $_POST ) && !empty( $_POST[ 'type_to_export' ] ) && is_array( (array)$_POST[ 'type_to_export' ] ) ) {
		// 	$what_to_export = (array)$_POST[ 'type_to_export' ];
		// }
		//
		// /** Export des données / Datas export */
		// $element = null;
		//
		// if ( !empty( $first_element_id ) ) {
		// 	$export_content = export_class::g()->export( $first_element_id, $what_to_export );
		// 	/** Récupération de la définition de l'élément passé en paramètre / Get the definition of given element */
		// 	$element = society_class::g()->show_by_type( $first_element_id );
		// 	$filename = $element->option[ 'unique_identifier' ];
		// }
		// else {
		//
		// 	/** Récupération des groupements ne possédant pas de parent (ceux du premier niveau) pour débuter l'export / Get existing groups that have no parent for export (first level only) */
		// 	$group_list = group_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );
		//
		// 	foreach ( $group_list as $group ) {
		// 		$export_content = export_class::g()->export( $group->id, $what_to_export );
		// 	}
		// 	$filename = 'global';
		// }
		//
		// /** Nom de base pour l'export pour le fichier json contenant l'export et aussi pour le fichier zip contenant les différents fichiers / Basename for exported files (json with datas and zip with additionnal files) */
		// $export_base = $this->export_directory . current_time( 'YmdHis' ) . '_' . $filename . '_export';
		//
		// /** Ecriture du fichier contenant l'export complet / Save exported datas into a file */
		// $json_filename = $export_base . '.json';
		// file_put_contents( $json_filename, json_encode( $export_content, JSON_PRETTY_PRINT ) );
		//
		// /** Ajout du fichier json au fichier zip / Add the json file to zip file */
		// $sub_response = document_class::g()->create_zip( $export_base . '.zip', array( array( 'link' => $json_filename, 'filename' => basename( $json_filename ) ) ), $element, null );
		// $response = array_merge( $response, $sub_response );
		//
		// /** Suppression du fichier json après l'enregistrement dans le fichier zip / Delete the json file after zip saving */
		// @unlink( $json_filename );
		//



		wp_send_json_success( $response );
	}

}

new export_action();
