<?php if ( !defined( 'ABSPATH' ) ) exit;
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
class wpdigi_group_action_01 extends wpdigi_group_ctr_01 {

	/**
	 * CORE - Instanciation des actions ajax pour les groupement / Instanciate ajax treatment for group
	 */
	function __construct() {
		add_action( 'wp_ajax_wpdigi-create-group', array( $this, 'ajax_create_group' ) );
		add_action( 'wp_ajax_wpdigi-delete-group', array( $this, 'ajax_delete_group' ) );

		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );

		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );

		add_action( 'wp_ajax_display_ajax_sheet_content', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );

		add_action( 'wp_ajax_wpdigi_loadsheet_group', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_generate_duer_' . $this->get_post_type(), array( $this, 'ajax_generate_duer' ) );
	}

	public function ajax_create_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', $this->post_type );
		$last_unique_key++;

		$group = $this->create( array(
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => $this->element_prefix . $last_unique_key,
			),
			'parent_id' => $group_id,
			'title' => __( 'Undefined', 'wpdigi-i18n' ),
		) );

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group->id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $group->id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	public function ajax_delete_group() {
		global $wpdigi_group_ctr;
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		wp_delete_post( $group_id );

		$group_list = $wpdigi_group_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );

		global $default_selected_group_id;
		global $wpdigi_workunit_ctr;
		$default_selected_group_id = ( $default_selected_group_id == null ) && ( !empty( $group_list ) ) ? $group_list[0]->id : $default_selected_group_id;

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $default_selected_group_id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $default_selected_group_id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	public function ajax_load_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group_id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $group_id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	public function ajax_group_update() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$title = sanitize_text_field( $_POST['title'] );

		wpdigi_utils::check( 'ajax_update_group_' . $group_id );

		$group = $this->show( $group_id );
		$group->title = $title;

		if ( !empty( $_POST['send_to_group_id'] ) ) {
			$send_to_group_id = (int) $_POST['send_to_group_id'];
			$group->parent_id = $_POST['send_to_group_id'];
		}

		$this->update( $group );

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group->id );
		wp_send_json_success( array( 'template_left' => ob_get_clean() ) );
	}

	public function ajax_display_ajax_sheet_content() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$group = $this->show( $group_id );

		$response = array(
			'status'		=> false,
			'output'		=> null,
			'message'		=> __( 'Element to load have not been found', 'wpdigi-i18n' ),
		);

		$subaction = sanitize_text_field( $_POST['subaction'] );

		ob_start();
		$this->display_group_tab_content( $group, $subaction );
		$response['output'] = ob_get_contents();
		ob_end_clean();

		wp_die( json_encode( $response ) );
	}

	public function ajax_group_sheet_display( ) {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$group = $this->show( $group_id );

		$group_default_tab = apply_filters( 'wpdigi_group_default_tab', '' );

		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'sheet', 'simple' ) );
		wp_die();
	}

	public function ajax_generate_duer() {
		// wpdigi_utils::check( 'digi_ajax_generate_element_duer' );

		ini_set('display_errors', true);
		error_reporting(E_ALL);

		$response = array(
			'status' 	=> false,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'wpdigi-i18n' ),
		);

		if ( 0 === (int) $_POST['element_id'] )
			wp_send_json_error();
		else
			$element_id = (int) $_POST['element_id'];

		/**	Début de la génération du document / Start document generation	*/
		$document_controller = new document_controller_01();

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$element_model_to_use = null;
		$element_model_id_to_use = !empty( $_POST ) && !empty( $_POST['document_model_id'] ) && (int)$_POST['document_model_id'] ? (int)$_POST['document_model_id'] : null ;

		/**	Récupération du modèle de document pour l'élément actuel / Get model for current workunit	*/
		if ( null === $element_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'document_unique', ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

			$element_model_to_use = $response[ 'model_path' ];
		}

		$element = $this->show( $element_id );

		/**	Définition des composants du fichier / Define the file component	*/
		$audit_date = '';
		if ( !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_start_date' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_start_date' ] ) )
			$audit_date .= sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_start_date' ] ) );
		if ( !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_end_date' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_end_date' ] ) && ( $audit_date != $_POST[ 'wpdigi_duer' ][ 'audit_end_date' ] ) ) {
			if ( !empty( $audit_date ) ) {
				$audit_date .= ' - ';
			}
			$audit_date .= sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_end_date' ] ) );
		}

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'document_unique' ), $element->id );

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$src_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );

		/**	Définition de la structure des données du document par défaut / Define the default data structure for document	*/
		$element_file_details = array(
// 			'a' => array(
// 				'type'		=> 'picture',
// 				'value'		=> str_replace( site_url( '/' ), ABSPATH, $src_logo[0] ),
// 				'option'	=> array(
// 					'size'	=> 2,
// 				),
// 			),

			'identifiantElement'		=> $element->option[ 'unique_identifier' ],
			'nomEntreprise'					=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'company_name' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'company_name' ] ) ) : $element->title,
			'dateAudit'							=> $audit_date,
			'emetteurDUER'					=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_transmitter' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_transmitter' ] ) ) : $element->title,
			'destinataireDUER'			=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient' ] ) ) : $element->title,
			'dateGeneration'				=> mysql2date( get_option( 'date_format' ), current_time( 'mysql', 0 ), true ),
			'telephone'							=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient_phone' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient_phone' ] ) ) : implode( ',', $element->option[ 'contact' ][ 'phone' ] ),
			'portable'							=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient_cellphone' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient_cellphone' ] ) ) : '',

			'methodologie'					=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_methodology' ] ) ? sanitize_text_field( strip_tags( stripslashes( $_POST[ 'wpdigi_duer' ][ 'audit_methodology' ] ) ) ) : '',
			'sources'								=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_sources' ] ) ? sanitize_text_field( strip_tags( stripslashes( $_POST[ 'wpdigi_duer' ][ 'audit_sources' ] ) ) ) : '',
			'remarqueImportante'		=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_important_note' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_important_note' ] ) ) : '',
			'dispoDesPlans'					=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_location' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_location' ] ) ) : '',

			'elementParHierarchie'	=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risq'									=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risq48'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risq51'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risq80'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risqueFiche'						=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risqPA'									=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risqPA48'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risqPA51'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'risqPA80'								=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDactionRisq'				=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'planDactionRisq48'			=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'planDactionRisq51'			=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
			'planDactionRisq80'			=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDaction'						=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
		);

		/**	Récupération de la liste des risques pour l'élément actuel et ses sous-éléments	de façon récursive / Get risks list for current element and recursivly sub elements */
		$risk_details = $this->get_element_tree_risk( $element );

		/**	Construction de la liste des risques unitaires / Build unit risk list	*/
		global $wpdigi_evaluation_method_controller;
		$result_treshold = $wpdigi_evaluation_method_controller->get_method_treshold( 'score' );

		$risk_per_element = array();

		foreach ( $risk_details as $risk_for_export ) {
			$final_level = !empty( $result_treshold[ $risk_for_export[ 'niveauRisque' ] ] ) ? $result_treshold[ $risk_for_export[ 'niveauRisque' ] ] : '';
			$element_file_details[ 'risq' . $final_level ][ 'value' ][] = $risk_for_export;
			$element_file_details[ 'risqPA' . $final_level ][ 'value' ][] = $risk_for_export;

			if ( !isset( $risk_per_element[ $risk_for_export[ 'idElement' ] ] ) ) {
				$risk_per_element[ $risk_for_export[ 'idElement' ] ][ 'quotationTotale' ] = 0;
			}
			$risk_per_element[ $risk_for_export[ 'idElement' ] ][ 'quotationTotale' ] += $risk_for_export[ 'quotationRisque' ];
		}

		/**	Construction de l'arborescence contenue dans l'élément sur lequel on est placé / Build tree under element we are on	*/
		$element_tree = $this->get_element_sub_tree( $element );
		$element_file_details[ 'elementParHierarchie' ][ 'value' ] = $element_tree;

		/***/
		$element_tree = $this->get_element_sub_tree( $element , '', array( 'default' => array( 'quotationTotale' => 0, ), 'value' => $risk_per_element, ) );
		$element_file_details[ 'risqueFiche' ][ 'value' ] = $element_tree;

		$element_duer_id = 0;
		$element_duer_media_args = array(
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_author'		 => get_current_user_id(),
			'post_date'			 => current_time( 'mysql', 0 ),
			'post_title'		 => !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_name' ] ) ? str_replace( '.odt', '', sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_name' ] ) ) ) . '_V' . $document_revision : ( mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->option[ 'unique_identifier' ] . '_' . sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V' . $document_revision ),
			'id' 							=> $element->id,
			'type'						=> $element->type,
		);

		if( !empty( $_POST['return'] ) )
			$element_duer_media_args['post_title'] = mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->option[ 'unique_identifier' ] . '_' . sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V' . $document_revision;

		$element_duer_id = wp_insert_attachment( $element_duer_media_args, '', $element->id );

		if ( !empty( $element_duer_id ) ) {
			$element->option[ 'associated_document_id' ][ 'document' ][] = $element_duer_id;
			$element = $this->update( $element );
			wp_set_object_terms( $element_duer_id, array( 'printed', 'document_unique', ), $document_controller->attached_taxonomy_type );
		}

		/**	On créé le document / Create the document	*/
		$element_file_details = apply_filters( 'wpdigi_element_duer_details', $element_file_details );

		$document_creation = $document_controller->create_document( $element_model_to_use, $element_file_details, $element->type. '/' . $element->id . '/' . $element_duer_media_args[ 'post_title' ] . '.odt', $element_duer_id );
		$response['name'] = $element_duer_media_args[ 'post_title' ] . '.odt';
		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		/**	On met à jour les informations concernant le document dans la base de données / Update data for document into database	*/
		$next_document_key = ( wpdigi_utils::get_last_unique_key( 'post', $document_controller->get_post_type() ) + 1 );
		$work_unit_sheet_args = array(
			'id'					=> $element_duer_id,
			'status'    	=> 'inherit',
			'author_id'		=> get_current_user_id(),
			'date'			 	=> current_time( 'mysql', 0 ),
			'mime_type'		=> $filetype[ 'type' ],
			'option'			=> array (
				'unique_key'					=> $next_document_key,
				'unique_identifier' 	=> $document_controller->element_prefix . $next_document_key,
				'model_id' 						=> $element_model_to_use,
				'document_meta' 			=> json_encode( $element_file_details ),
			),
		);
		$document = $document_controller->update( $work_unit_sheet_args );

		// Generate children

		$list_id = array();
		if( empty($_POST['return']) ) {
			$list_id = $this->get_element_sub_tree_id( $element->id, $list_id );

			global $wpdigi_workunit_ctr;
			$work_unit_list = $wpdigi_workunit_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );

			$response['file'] = array();

			global $workunit_action;
			global $sheet_groupment_action;

			$_POST['element_id'] = $element->id;
			$_POST['element_type'] = 'digi-group';
			$_POST['return'] = true;
			$response['file'][] = $sheet_groupment_action->generate_sheet();

			foreach( $work_unit_list as $workunit ) {
				$_POST['element_id'] = $workunit->id;
				$_POST['element_type'] = 'digi-workunit';
				$_POST['return'] = true;
				$response['file'][] = $workunit_action->generate_workunit_sheet();
				// do_action( 'wp_ajax_wpdigi_save_sheet_digi-workunit' );
			}

			if ( !empty( $list_id ) ) {
				foreach( $list_id as $element ) {
					if( !empty( $element['workunit'] ) ) {
						if( !empty( $element['id'] ) ) {
							$_POST['element_id'] = $element['id'];
							$_POST['element_type'] = 'digi-group';
							$_POST['return'] = true;
							$response['file'][] = $sheet_groupment_action->generate_sheet();
							// do_action( 'wp_ajax_wpdigi_generate_duer_digi-group', $response['file'][0] );
						}
						foreach( $element['workunit'] as $workunit_id ) {
							$_POST['element_id'] = $workunit_id['id'];
							$_POST['element_type'] = 'digi-workunit';
							$_POST['return'] = true;
							$response['file'][] = $workunit_action->generate_workunit_sheet();
							// do_action( 'wp_ajax_wpdigi_save_sheet_digi-workunit' );
						}
					}
					else {
						if( !empty( $element['id'] ) ) {
							$_POST['element_id'] = $element['id'];
							$_POST['element_type'] = 'digi-group';
							$_POST['return'] = true;
							$response['file'][] = $sheet_groupment_action->generate_sheet();
							// do_action( 'wp_ajax_wpdigi_generate_duer_digi-group', $response['file'][0] );
						}
					}
				}
			}

			unset( $_POST['return'] );
		}

		if( !empty($_POST['return']) ) {
			$response['link'] = $document_creation[ 'link' ];
			return $response;
		}

		$response['link'] = $document_creation[ 'link' ];

		$upload_dir = wp_upload_dir();
		$path = $upload_dir[ 'basedir' ] . '/digirisk/' . $element_duer_media_args['type'] . '/' . $element_duer_media_args['id'] . '/' . $element_duer_media_args[ 'post_title' ] . '_merged.zip';

		$zip = new ZipArchive();



		if( $zip->open( $path, ZipArchive::CREATE) !== TRUE ) {
			$response['status'] = false;
			$response['message'] = __( 'An error occured while getting element to generate sheet for.', 'wpdigi-i18n' );
		}

		$zip->addFile( $response['link'], $response['name'] );

		if( !empty( $response['file'] ) ) {
			foreach( $response['file'] as $file ) {
					$zip->addFile( $file['link'], $file['name'] );
			}
		}
		$zip->close();

		$element_zip_id = wp_insert_attachment( $element_duer_media_args, '', $element_duer_media_args['id'] );

		$element_file_details['zip'] = true;

		$work_unit_sheet_args = array(
			'id'					=> $element_zip_id,
			'status'    	=> 'inherit',
			'author_id'		=> get_current_user_id(),
			'date'			 	=> current_time( 'mysql', 0 ),
			'mime_type'		=> $filetype[ 'type' ],
			'option'			=> array (
				'unique_key'					=> $next_document_key,
				'unique_identifier' 	=> 'ZIP' . $next_document_key,
				'model_id' 						=> $element_model_to_use,
				'document_meta' 			=> json_encode( $element_file_details ),
			),
		);
		$document = $document_controller->update( $work_unit_sheet_args );

		if ( !empty( $element_zip_id ) ) {
			$element = $this->show( $element_duer_media_args['id'] );
			$element->option[ 'associated_document_id' ][ 'document' ][] = $element_zip_id;
			$element = $this->update( $element );
			wp_set_object_terms( $element_zip_id, array( 'printed', 'document_unique', ), $document_controller->attached_taxonomy_type );
		}

		wp_die(json_encode( $response ) );
	}

	public function get_element_sub_tree( $element, $tabulation = '', $extra_params = null ) {
		global $wpdigi_workunit_ctr;
		$element_children = array();
		$element_tree = '';

		$element_children[ $element->option[ 'unique_identifier' ] ] = array( 'nomElement' => $tabulation . ' ' . $element->option[ 'unique_identifier' ] . ' - ' . $element->title, ) ;
		if ( !empty( $extra_params ) ) {
			if ( !empty( $extra_params[ 'default' ] ) ) {
				$element_children[ $element->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'default' ], $element_children[ $element->option[ 'unique_identifier' ] ] );
			}
			if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $element->option[ 'unique_identifier' ], $extra_params[ 'value' ] ) ) {
				$element_children[ $element->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'value' ][ $element->option[ 'unique_identifier' ] ], $element_children[ $element->option[ 'unique_identifier' ] ] );
			}
		}
		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id , 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$element_children = array_merge( $element_children, $this->get_element_sub_tree( $group, $tabulation . '-', $extra_params ) );
		}

		$tabulation = $tabulation . '-';
		$work_unit_list = $wpdigi_workunit_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $work_unit_list as $workunit ) {
			$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = array( 'nomElement' => $tabulation . ' ' . $workunit->option[ 'unique_identifier' ] . ' - ' . $workunit->title, );

			if ( !empty( $extra_params ) ) {
				if ( !empty( $extra_params[ 'default' ] ) ) {
					$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'default' ], $workunit_definition[ $workunit->option[ 'unique_identifier' ] ] );
				}
				if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $workunit->option[ 'unique_identifier' ], $extra_params[ 'value' ] ) ) {
					$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'value' ][ $workunit->option[ 'unique_identifier' ] ], $workunit_definition[ $workunit->option[ 'unique_identifier' ] ] );
				}
			}
			$element_children = array_merge( $element_children, $workunit_definition );
		}

		return $element_children;
	}

	public function get_element_sub_tree_id( $element_id, $list_id ) {
		global $wpdigi_workunit_ctr;

		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id , 'post_status' => array( 'publish', 'draft', ), ), false );
		if( !empty( $group_list ) ) {
			foreach ( $group_list as $group ) {
				$list_id[] = array( 'id' => $group->id, 'workunit' => array() );
				// $list_id[count($list_id) - 1] = array();
				// $list_id[count($list_id) - 1]['workunit'] = array();
				$work_unit_list = $wpdigi_workunit_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => $group->id, 'post_status' => array( 'publish', 'draft', ), ), false );
				foreach ( $work_unit_list as $workunit ) {
					$list_id[count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
				}
				$list_id = $this->get_element_sub_tree_id( $group->id, $list_id );
			}
		}
		else {
			$work_unit_list = $wpdigi_workunit_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id, 'post_status' => array( 'publish', 'draft', ), ), false );
			foreach ( $work_unit_list as $workunit ) {
				// $list_id[count($list_id) - 1 == -1 ? 0 : count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
			}
		}


		return $list_id;
	}


	/**
	 * Construction du tableau contenant les risques pour l'arborescence complète du premier élément demandé / Build an array with all risks for element and element's subtree
	 *
	 * @param Object $element L'élément actuel dont il faut récupérer la liste des risques de manière récursive / Current element where we have to get risk list recursively
	 *
	 * @return array Les risques pour l'arborescence complète non ordonnées mais construits de façon pour l'export / Unordered risks list for complete tree, already formatted for export
	 */
	public function get_element_tree_risk( $element ) {
		global $wpdigi_workunit_ctr;
		$risks_in_tree = array();

		$risks_in_tree = $this->build_risk_list_for_export( $element );

		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$risks_in_tree = array_merge( $risks_in_tree, $this->get_element_tree_risk( $group ) );
		}

		$work_unit_list = $wpdigi_workunit_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $work_unit_list as $workunit ) {
			$risks_in_tree = array_merge( $risks_in_tree, $this->build_risk_list_for_export( $workunit ) );
		}

		return $risks_in_tree;
	}

	/**
	 * Construction de la liste des risques pour un élément donné / Build risks' list for a given element
	 *
	 * @param object $element La définition complète de l'élément dont il faut retourner la liste des risques / The entire element we want to get risks list for
	 *
	 * @return array La liste des risques construite pour l'export / Risks' list builded for export
	 */
	public function build_risk_list_for_export( $element ) {
		if ( empty( $element->option[ 'associated_risk' ] ) )
			return array();

		global $wpdigi_risk_ctr;
		$risk_list = $wpdigi_risk_ctr->index( array(
			'include' => $element->option[ 'associated_risk' ],
		) );
		$element_duer_details = array();
		foreach ( $risk_list as $risk ) {
			$complete_risk = $wpdigi_risk_ctr->get_risk( $risk->id );
			$comment_list = '';
			if ( !empty( $complete_risk->comment ) ) :
				foreach ( $complete_risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$element_duer_details[] = array(
				'idElement'					=> $element->option[ 'unique_identifier' ],
				'nomElement'				=> $element->option[ 'unique_identifier'] . ' - ' . $element->title,
				'identifiantRisque'	=> $risk->option[ 'unique_identifier' ] . '-' . $complete_risk->evaluation->option[ 'unique_identifier' ],
				'quotationRisque'		=> $complete_risk->evaluation->option[ 'risk_level' ][ 'equivalence' ],
				'niveauRisque'			=> $complete_risk->evaluation->option[ 'risk_level' ][ 'scale' ],
				'nomDanger'					=> $complete_risk->danger->name,
				'commentaireRisque'	=> $comment_list,
				'est' => 'hahaha',
			);
		}

		if ( !empty( $risk_list_to_order ) ) {
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = !empty( $result_treshold[ $risk_level ] ) ? $result_treshold[ $risk_level ] : '';
				$element_duer_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
				$element_duer_details[ 'risqPA' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}

		return $element_duer_details;
	}

}

new wpdigi_group_action_01();
