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
class wpdigi_workunit_action_01 extends wpdigi_workunit_ctr_01 {

	/**
	 * CORE - Instanciation des actions ajax pour les unités de travail / Instanciate ajax treatment for work unit
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_asset' ) );

		/**	Affiche une fiche d'unité de travail / Display a work unit sheet	*/
		add_action( 'wp_ajax_wpdigi_workunit_sheet_display', array( $this, 'display_workunit_sheet' ) );

		/**	Création d'une unité de travail / Create a work unit	*/
		add_action( 'wp_ajax_wpdigi_ajax_workunit_create', array( $this, 'create_workunit' ) );

		/** Suppresion d'une unité de travail / Delete a work unit */
		add_action( 'wp_ajax_wpdigi_ajax_workunit_delete', array( $this, 'delete_workunit' ) );

		/** Mise à jour d'une unité de travail / Update a work unit */
		add_action( 'wp_ajax_wpdigi_ajax_workunit_update', array( $this, 'update_workunit' ) );

		/**	Affichage de la liste des utilisateurs affectés à une unité de travail / Display user associated to a work unit	*/
		add_action( 'wp_ajax_wpdigi_loadsheet_workunit', array( $this, 'display_workunit_sheet_content' ), 9 );

		/**	Association de fichiers à une unité de travail / Associate file to a workunit	*/
		add_action( 'wp_ajax_wpfile_associate_file_digi-workunit', array( $this, 'associate_file_to_workunit' ) );

		/**	Génération de la fiche d'une unité de travail / Generate sheet for a workunit	*/
		add_action( 'wp_ajax_wpdigi_save_sheet_digi-workunit', array( $this, 'generate_workunit_sheet' ) );
	}

	public function admin_asset() {
		wp_enqueue_script( 'wpdigi-workunit-backend-js', WPDIGI_STES_URL . 'asset/js/workunit.backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
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
	public function create_workunit() {
		/**	Check if the ajax request come from a known source	*/
		check_ajax_referer( 'wpdigi-workunit-creation', 'wpdigi_nonce' );

		if ( 0 === ( int )$_POST['workunit']['parent_id'] )
			wp_send_json_error();
		else
			$parent_id = (int) $_POST['workunit']['parent_id'];

		/**	Génération des identifiants unique pour l'unité / Create the unique identifier for workunit	*/
		$next_identifier = wpdigi_utils::get_last_unique_key( 'post', $this->get_post_type() );

		$workunit = array(
			'title' => sanitize_text_field( $_POST['workunit']['title'] ),
			'parent_id' => $parent_id,
			'option' => array(
				'unique_key' => (int)( $next_identifier + 1 ),
				'unique_identifier' => 'UT' . ( $next_identifier + 1 ),
			)
		);

		/**	Création de l'unité / Create the unit	*/
		$workunit = $this->create( $workunit );

		if ( !empty( $workunit->id ) ) {
			$args['workunit_id'] = $workunit->id;
			/**	Define a nonce for display sheet using ajax	*/
			$workunit_display_nonce = wp_create_nonce( 'wpdigi_workunit_sheet_display' );

			$workunit = $this->show( $workunit->id );

			$status = true;
			$message = __( 'Work unit have been created succesfully', 'wpdigi-i18n' );
			/**	Affichage de la liste des unités de travail pour le groupement actuellement sélectionné / Display the work unit list for current selected group	*/
			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list', 'item' ) );
			$output = ob_get_contents();
			ob_end_clean();
		}
		else {
			$status = false;
			$message = __( 'An error occured while creating work unit', 'wpdigi-i18n' );
			$output = null;

			wpeologs_ctr::log_datas_in_files( $this->get_post_type(), array( 'object_id' => null, 'message' => sprintf( __( 'Work unit could not been create. request: %s response: %s', 'wpdigi-i18n'), json_encode( $_POST ), json_encode( $workunit ) ), ), 2 );
		}

		ob_start();
		global $wpdigi_group_ctr; $wpdigi_group_ctr->display_all_group( $workunit->parent_id );

		wp_die( json_encode( array( 'template' => ob_get_clean(), 'status' => $status, 'message' => $message, 'element' => $workunit, 'output' => $output, ) ) );
	}

	/**
	 * Suppression d'une unité de travail / Delete a workunit
	 */
	public function delete_workunit() {
		if ( 0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		wpdigi_utils::check( 'ajax_delete_workunit_' . $workunit_id );
		global $wpdigi_workunit_ctr;

		$workunit = array(
			'id' 		=> $workunit_id,
			'status'	=> 'trash',
			'date_modified'	=> current_time( 'mysql', 0 ),
		);

		$wpdigi_workunit_ctr->update( $workunit );
		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		ob_start();
		global $wpdigi_group_ctr; $wpdigi_group_ctr->display_all_group( $workunit->parent_id );

		wp_send_json_success( array( 'template' => ob_get_clean() ) );
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
			'message'		=> __( 'Element to load have not been found', 'wpdigi-i18n' ),
		);

		ob_start();
		$this->display_workunit_tab_content( $this->current_workunit, $subaction );
		$response['output'] = ob_get_contents();
		ob_end_clean();

		wp_die( json_encode( $response ) );
	}

	/**
	 * Affectation de fichiers a une unité de travail / Associate file to a workunit
	 */
	public function associate_file_to_workunit() {
		if ( 0 === (int) $_POST['element_id'] )
			wp_send_json_error();
		else
			$element_id = (int) $_POST['element_id'];

		if( !isset( $_POST['thumbnail'] ) )
			wp_send_json_error();
		else {
			$thumbnail = (bool) $_POST['thumbnail'];
		}

		wpdigi_utils::check( 'ajax_file_association_' . $element_id );

		if ( empty( $_POST ) || empty( $_POST[ 'files_to_associate'] ) || !is_array( $_POST[ 'files_to_associate'] ) )
			wp_send_json_error( array( 'message' => __( 'Nothing has been founded for association', 'wpdigi-i18n' ), ) );


		$workunit = $this->show( $element_id );


		$response = null;
		foreach ( $_POST[ 'files_to_associate'] as $file_id ) {
			if ( true === is_int( (int)$file_id ) ) {
				if ( wp_attachment_is_image( $file_id ) ) {
					$workunit->option[ 'associated_document_id' ][ 'image' ][] = (int)$file_id;

					if ( !empty( $thumbnail ) ) {
						set_post_thumbnail( $element_id , (int)$file_id );
					}
				}
				else {
					$workunit->option[ 'associated_document_id' ][ 'document' ][] = (int)$file_id;
				}
			}
		}
		$updated_workunit = $this->update( $workunit );
		$workunit = $this->show( $element_id );
		$workunit_display_nonce = wp_create_nonce( 'wpdigi_workunit_sheet_display' );

		$this->current_workunit = $workunit;

		$workunit_default_tab = apply_filters( 'wpdigi_workunit_default_tab', '' );

		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list', 'item' ) );
		$list_item_workunit = ob_get_clean();

		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', 'simple' ) );
		$sheet_simple = ob_get_clean();

		wp_send_json_success( array( 'workunit_id' => $element_id, 'list_item_workunit' => $list_item_workunit, 'sheet_simple' => $sheet_simple ) );
	}

	/**
	 * Enregistrement et création de la fiche d'une unité de travail / Save and create file for a workunit sheet
	 */
	public function generate_workunit_sheet() {
		// wpdigi_utils::check( 'digi_ajax_generate_element_sheet' );
 ini_set("display_errors", true);
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
		$workunit_model_to_use = null;
		$workunit_model_id_to_use = !empty( $_POST ) && !empty( $_POST[ 'document_model_id' ] ) && is_int( (int)$_POST[ 'document_model_id' ] ) ? (int)$_POST[ 'document_model_id' ] : null ;

		/**	Récupération de la liste des modèles existants pour l'élément actuel / Get model list for current workunit	*/
		if ( null === $workunit_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'fiche_de_poste', ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

			$workunit_model_to_use = $response[ 'model_path' ];
		}

		$workunit = $this->show( $element_id );
		$element = $workunit;

		/**	Définition des détails de l'unité de travail a imprimer / Define workunit details for print	*/
		/**	Définition de la photo de l'unité de travail / Define workunit main picture	*/
		$picture = __( 'No picture defined', 'wpdigi-i18n' );
		if ( !empty( $workunit->thumbnail_id ) && ( true === is_int( (int)$workunit->thumbnail_id ) ) ) {
			$picture_definition = wp_get_attachment_image_src( $workunit->thumbnail_id, 'digirisk-element-thumbnail' );
			$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
			$picture = '';
			if ( is_file( $picture_final_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> $picture_final_path,
					'option'	=> array(
						'size'	=> 8,
					),
				);
			}
		}

		/**	Définition des informations de l'adresse de l'unité de travail / Define informations about workunit address	*/
		$option[ 'address' ] = $option[ 'postcode' ] = $option[ 'town' ] = '-';
		if ( !empty( $workunit->option[ 'contact' ][ 'address' ] ) && ( true === is_int( (int)$workunit->option[ 'contact' ][ 'address' ] ) ) ) {
			global $wpdigi_address_ctr;
			$work_unit_address_definition = $wpdigi_address_ctr->show( (int)$workunit->option[ 'contact' ][ 'address' ][ 0 ] );
			extract( get_object_vars( $work_unit_address_definition ) );
		}

		/**	Définition finale de l'unité de travail / Final definition for workunit	*/
		$workunit_sheet_details = array(
			'referenceUnite'	=> $workunit->option[ 'unique_identifier' ],
			'nomUnite'				=> $workunit->title,
			'photoDefault'		=> $picture,
			'description'			=> $workunit->content,
			'adresse'					=> $option[ 'address' ],
			'codePostal'			=> $option[ 'postcode' ],
			'ville'						=> $option[ 'town' ],
			'telephone'				=> implode( ', ', $workunit->option[ 'contact' ][ 'phone' ] ),
		);

		/**	Ajout des utilisateurs dans le document final / Add affected users' into final document	*/
		$workunit_sheet_details[ 'utilisateursAffectes' ] = $workunit_sheet_details[ 'utilisateursDesaffectes' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] ) ) {
			global $wpdigi_user_ctr;
			$user_affectation_for_export = $wpdigi_user_ctr->build_list_for_document_export( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] );
			if ( null !== $user_affectation_for_export ) {
				$workunit_sheet_details[ 'utilisateursAffectes' ] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export[ 'affected' ],
				);
				if ( !empty( $user_affectation_for_export[ 'unaffected' ] ) ) {
					$workunit_sheet_details[ 'utilisateursDesaffectes' ] = array(
						'type'	=> 'segment',
						'value'	=> $user_affectation_for_export[ 'unaffected' ],
					);
				}
			}
		}

		/**	Ajout des préconisations affectées a l'unité de travail / Add recommendation affected to workunit	*/
		$affected_recommendation = array( );
		$workunit_sheet_details[ 'affectedRecommandation' ] = array( 'type' => 'segment', 'value' => array(), );
		if ( !empty( $workunit->option[ 'associated_recommendation' ] ) ) {
			global $digi_recommendation_controller, $digi_recommendation_category_controller;

			foreach ( $workunit->option[ 'associated_recommendation' ] as $recommendation_id => $recommendation_detail ) {
				foreach ( $recommendation_detail as $recommendation ) {
					if ( 'valid' == $recommendation[ 'status' ] ) {

						$the_recommendation = $digi_recommendation_controller->show( $recommendation_id );

						if ( !empty( $the_recommendation ) && !empty( $the_recommendation->parent_id ) ) {

							if ( empty( $affected_recommendation ) || empty( $affected_recommendation[ $the_recommendation->id ] ) ) {
								$the_recommendation_category = $digi_recommendation_category_controller->show( $the_recommendation->parent_id );

								$picture_definition = wp_get_attachment_image_src( $the_recommendation_category->option[ 'thumbnail_id' ], 'digirisk-element-thumbnail' );
								$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
								$picture = '';
								if ( is_file( $picture_final_path ) ) {
									$picture = array(
										'type'		=> 'picture',
										'value'		=> $picture_final_path,
										'option'	=> array(
												'size'	=> 2,
										),
									);
								}
								$affected_recommendation[ $the_recommendation->id ] = array(
									'recommandationCategoryIcon' => $picture,
									'recommandationCategoryName' => $the_recommendation_category->name,
								);
							}

							$picture_definition = wp_get_attachment_image_src( $the_recommendation->option[ 'thumbnail_id' ], 'digirisk-element-thumbnail' );
							$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
							$picture = '';
							if ( is_file( $picture_final_path ) ) {
								$picture = array(
									'type'		=> 'picture',
									'value'		=> $picture_final_path,
									'option'	=> array(
										'size'	=> 8,
									),
								);
							}
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'type' ] = 'sub_segment';
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'value' ][] = array(
								'identifiantRecommandation'	=> $recommendation[ 'unique_identifier' ],
								'recommandationIcon'		=> $picture,
								'recommandationName'		=> $the_recommendation->name,
								'recommandationComment'		=> $recommendation[ 'comment' ],
							);
						}
					}
				}
			}
		}
		$workunit_sheet_details[ 'affectedRecommandation' ] = array(
			'type'	=> 'segment',
			'value'	=> $affected_recommendation,
		);

		/**	Ajout des personnes présentes lors de l'évaluation dans le document final / Add users' who were present when evaluation have been done into final document	*/
		$workunit_sheet_details[ 'utilisateursPresents' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) ) {
			global $wpdigi_evaluator_ctr;
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = $wpdigi_evaluator_ctr->get_list_affected_evaluator( $workunit );
			if ( !empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' == $evaluator_affectation_info[ 'affectation_info' ][ 'status' ] ) {
							$affected_users[] = array(
								'idUtilisateur'			=> $wpdigi_evaluator_ctr->element_prefix . $evaluator_affectation_info[ 'user_info' ]->id,
								'nomUtilisateur'		=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'lastname' ],
								'prenomUtilisateur'	=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'firstname' ],
								'dateEntretien'			=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info[ 'affectation_info' ][ 'start' ][ 'date' ], true ),
								'dureeEntretien'		=> $wpdigi_evaluator_ctr->get_duration( $evaluator_affectation_info[ 'affectation_info' ] ),
							);
						}
					}
				}

				$workunit_sheet_details[ 'utilisateursPresents' ] = array(
					'type'	=> 'segment',
					'value'	=> $affected_users,
				);
			}
		}

		/**	Construction de l'affichage des risques dans la fiche imprimée / Build risks display into printed sheet	*/
		$workunit_sheet_details[ 'risq80' ] = $workunit_sheet_details[ 'risq51' ] = $workunit_sheet_details[ 'risq48' ] = $workunit_sheet_details[ 'risq' ] = array( 'type' => 'segment', 'value' => array(), );
		/**	On récupère la définition des risques associés à l'unité de travail / Get definition of risks associated to workunit	*/
		global $wpdigi_risk_ctr;
		$risk_list = array();

		if ( !empty( $workunit->option[ 'associated_risk' ] ) ) {
			$risk_list = $wpdigi_risk_ctr->index( array(
				'include' => $workunit->option[ 'associated_risk' ],
			) );
		}

		$risk_list_to_order = array();
		foreach ( $risk_list as $risk ) {
			$complete_risk = $wpdigi_risk_ctr->get_risk( $risk->id );
			$comment_list = '';
			if ( !empty( $complete_risk->comment ) ) :
				foreach ( $complete_risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$risk_list_to_order[ $complete_risk->evaluation->option[ 'risk_level' ][ 'scale' ] ][] = array(
				'nomDanger'			=> $complete_risk->danger->name,
				'identifiantRisque'	=> $risk->option[ 'unique_identifier' ] . '-' . $complete_risk->evaluation->option[ 'unique_identifier' ],
				'quotationRisque'	=> $complete_risk->evaluation->option[ 'risk_level' ][ 'equivalence' ],
				'commentaireRisque'	=> $comment_list,
			);
		}
		krsort( $risk_list_to_order );

		if ( !empty( $risk_list_to_order ) ) {
			global $wpdigi_evaluation_method_controller;
			$result_treshold = $wpdigi_evaluation_method_controller->get_method_treshold( 'score' );
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = !empty( $result_treshold[ $risk_level ] ) ? $result_treshold[ $risk_level ] : '';

				$workunit_sheet_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'fiche_de_poste' ), $workunit->id );

		/**	Enregistrement de la fiche de l'unité de travail dans la base de donnée / Save workunit sheet into database	*/
		$workunit_sheet_id = 0;
		$workunit_sheet_media_args = array(
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_author'		 => get_current_user_id(),
			'post_date'			 => current_time( 'mysql', 0 ),
			'post_title'		 => mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $workunit->option[ 'unique_identifier' ] . '_' . sanitize_title( str_replace( ' ', '_', $workunit->title ) ) . '_V' . $document_revision,
		);
		$workunit_sheet_id = wp_insert_attachment( $workunit_sheet_media_args, '', $workunit->id );

		if ( !empty( $workunit_sheet_id ) ) {
			$workunit->option[ 'associated_document_id' ][ 'document' ][] = $workunit_sheet_id;
			$workunit = $this->update( $workunit );
			wp_set_object_terms( $workunit_sheet_id, array( 'printed', 'fiche_de_poste', ), $document_controller->attached_taxonomy_type );
		}

		/**	On créé le document / Create the document	*/
		$workunit_sheet_details = apply_filters( 'wpdigi_workunit_sheet_details', $workunit_sheet_details );
		$document_creation = $document_controller->create_document( $workunit_model_to_use, $workunit_sheet_details, $workunit->type. '/' . $workunit->id . '/' . $workunit_sheet_media_args[ 'post_title' ] . '.odt' , $workunit_sheet_id );
		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		/**	On met à jour les informations concernant le document dans la base de données / Update data for document into database	*/
		$next_document_key = ( wpdigi_utils::get_last_unique_key( 'post', $document_controller->get_post_type() ) + 1 );
		$work_unit_sheet_args = array(
			'id'					=> $workunit_sheet_id,
			'status'    	=> 'inherit',
			'author_id'		=> get_current_user_id(),
			'date'			 	=> current_time( 'mysql', 0 ),
			'mime_type'		=> $filetype[ 'type' ],
			'option'			=> array (
				'unique_key'						=> $next_document_key,
				'unique_identifier' 		=> $document_controller->element_prefix . $next_document_key,
				'model_id' 							=> $workunit_model_to_use,
				'document_meta' 				=> json_encode( $workunit_sheet_details ),
				'version'								=> '',
			),
		);
		$document = $document_controller->update( $work_unit_sheet_args );

		$document = $document_controller->show( $workunit_sheet_id );
		$document_full_path = null;
		if ( is_file( $document_controller->get_document_path( 'basedir' ) . '/' . $workunit->type . '/' . $workunit->id . '/' . $document->title . '.odt' ) ) {
			$document_full_path = $document_controller->get_document_path( 'baseurl' ) . '/' . $workunit->type . '/' . $workunit->id . '/' . $document->title . '.odt';
		}
		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'common', 'printed-list', 'item' ) );
		$response[ 'output' ] = ob_get_contents();
		ob_end_clean();

		if( !empty( $_POST['return'] ) ) {
			$response['name'] = $workunit_sheet_media_args[ 'post_title' ] . '.odt';
			$response['link'] = $document_creation[ 'link' ];
			return $response;
		}

		wp_die( json_encode( $response ) );
	}
}

global $workunit_action;
$workunit_action = new wpdigi_workunit_action_01();
