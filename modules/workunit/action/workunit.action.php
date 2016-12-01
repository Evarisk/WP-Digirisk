<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class workunit_action {

	/**
	 * CORE - Instanciation des actions ajax pour les unités de travail / Instanciate ajax treatment for work unit
	 */
	public function __construct() {
		if ( ! empty( Config_util::$init['workunit']->post_type_config ) ) {
			add_action( 'init', function() {
				Custom_Post_Type_Util::g()->init( Config_util::$init['workunit']->post_type_config );
			} );
		}

		/**	Affiche une fiche d'unité de travail / Display a work unit sheet	*/
		add_action( 'wp_ajax_wpdigi_workunit_sheet_display', array( $this, 'display_workunit_sheet' ) );

		/**	Création d'une unité de travail / Create a work unit	*/
		add_action( 'wp_ajax_save_workunit', array( $this, 'ajax_save_workunit' ) );

		/** Mise à jour d'une unité de travail / Update a work unit */
		add_action( 'wp_ajax_wpdigi_ajax_workunit_update', array( $this, 'update_workunit' ) );

		/**	Affichage de la liste des utilisateurs affectés à une unité de travail / Display user associated to a work unit	*/
		add_action( 'wp_ajax_wpdigi_loadsheet_workunit', array( $this, 'display_workunit_sheet_content' ), 9 );

		/**	Génération de la fiche d'une unité de travail / Generate sheet for a workunit	*/
		add_action( 'wp_ajax_wpdigi_save_sheet_digi-workunit', array( $this, 'generate_workunit_sheet' ) );
	}

	/**
	 * Affiche la fiche d'une unité de travail / Display a work unit sheet
	 */
	function display_workunit_sheet() {
		/**	Check if the ajax request come from a known source	*/
		check_ajax_referer( 'wpdigi_workunit_sheet_display', 'wpdigi_nonce' );

		/**	Check if requested workunit is weel formed	*/
		$workunit_id = null;
		if ( !empty( $_POST ) && !empty( $_POST[ 'workunit_id' ] ) && is_int( (int)$_POST[ 'workunit_id' ] ) && ( 0 < (int)$_POST[ 'workunit_id' ]) ) {
			$workunit_id = (int)$_POST[ 'workunit_id' ];
		}

		$this->display( $workunit_id );
		wp_die();
	}

	/**
	 * Création d'une unité de travail / Create a new workunit
	 */
	public function ajax_save_workunit() {
		/**	Check if the ajax request come from a known source	*/
		check_ajax_referer( 'wpdigi-workunit-creation', 'wpdigi_nonce' );

		if ( empty( $_POST['workunit'] ) ) {
			wp_send_json_error();
		}

		if ( 0 === ( int )$_POST['groupment_id'] )
			wp_send_json_error();
		else
			$parent_id = (int) $_POST['groupment_id'];

		$workunit = array(
			'title' => sanitize_text_field( $_POST['workunit']['title'] ),
			'parent_id' => $parent_id,
		);

		/**	Création de l'unité / Create the unit	*/
		$element = workunit_class::g()->create( $workunit );

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array( 'module' => 'workunit', 'callback_success' => 'save_workunit', 'template' => ob_get_clean(), 'id' => $element->id ) );
	}

	/**
	 * Enregistrement des modifications sur une unité de travail / Update data for a workunit
	 */
	public function update_workunit() {
		if ( 0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		wpdigi_utils::check( 'ajax_update_workunit_' . $workunit_id );

		$workunit = array(
			'id' 		=> $workunit_id,
			'date_modified'	=> current_time( 'mysql', 0 ),
		);

		$workunit['title'] = sanitize_text_field( $_POST['title'] );

		$updated_workunit = $this->update( $workunit );

		wp_send_json_success( $updated_workunit );
	}

	/**
	 * Affichage du contenu de l'onglet sur lequel l'utilisateur vient de cliquer / Display tab content corresponding to which one the user clic on
	 */
	public function display_workunit_sheet_content() {
		if ( 0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		$subaction = sanitize_text_field( $_POST['subaction'] );

		$this->current_workunit = $this->show( $workunit_id );

		$response = array(
			'status'		=> false,
			'output'		=> null,
			'message'		=> __( 'Element to load have not been found', 'digirisk' ),
		);

		ob_start();
		$this->display_workunit_tab_content( $this->current_workunit, $subaction );
		$response['output'] = ob_get_contents();
		ob_end_clean();

		wp_die( json_encode( $response ) );
	}

	/**
	 * Enregistrement et création de la fiche d'une unité de travail / Save and create file for a workunit sheet
	 */
	public function generate_workunit_sheet() {
		check_ajax_referer( 'digi_ajax_generate_element_sheet' );

		$element_id = !empty( $_POST ) && !empty( $_POST[ 'element_id' ] ) && is_int( (int)$_POST[ 'element_id' ] ) ? (int)$_POST[ 'element_id' ] : ( null !== $element_id  && is_int( (int)$element_id ) ? (int)$element_id : null );

		if ( 0 === $element_id ) {
			wp_send_json_error( array( 'message' => __( 'Requested element for sheet generation is invalid. Please check your request', 'digirisk' ), ) );
		}

		$generation_response = workunit_sheet_class::g()->generate_workunit_sheet( $element_id );
		$document = document_class::g()->get( array( 'id' => $generation_response[ 'id' ] ) );
		ob_start();
		view_util::exec( 'document', 'printed-list-item', array( 'document' => $document, 'element_id' => $element_id ) );
		$response[ 'output' ] = ob_get_contents();
		ob_end_clean();

		wp_send_json_success($response);
	}
}

new workunit_action();
