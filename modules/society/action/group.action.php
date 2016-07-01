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
class group_action {

	/**
	 * CORE - Instanciation des actions ajax pour les groupement / Instanciate ajax treatment for group
	 */
	public function __construct() {
		add_action( 'wp_ajax_wpdigi-create-group', array( $this, 'ajax_create_group' ) );
		add_action( 'wp_ajax_wpdigi-delete-group', array( $this, 'ajax_delete_group' ) );

		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );

		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );

		add_action( 'wp_ajax_display_ajax_sheet_content', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );

		add_action( 'wp_ajax_wpdigi_loadsheet_group', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_generate_duer_' . group_class::get()->get_post_type(), array( $this, 'ajax_generate_duer' ) );
	}

	public function ajax_create_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', group_class::get()->get_post_type() );
		$last_unique_key++;

		$group = group_class::get()->create( array(
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => group_class::get()->element_prefix . $last_unique_key,
			),
			'parent_id' => $group_id,
			'title' => __( 'Undefined', 'digirisk' ),
		) );

		ob_start();
		$display_mode = 'simple';
		group_class::get()->display_society_tree( $display_mode, $group->id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		group_class::get()->display( $group->id );
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
			'message'		=> __( 'Element to load have not been found', 'digirisk' ),
		);

		$subaction = sanitize_text_field( $_POST['subaction'] );

		ob_start();
		$this->display_group_tab_content( $group, $subaction );
		$response['output'] = ob_get_contents();
		ob_end_clean();

		wp_die( json_encode( $response ) );
	}

	public function ajax_generate_duer() {
		check_ajax_referer( 'digi_ajax_generate_element_duer' );

		$response = array(
			'status' 	=> false,
			'message'	=> __( 'An error occured while getting element to generate document for.', 'digirisk' ),
		);

		$element_id = (int)$_POST['element_id'];
		if ( 0 === $element_id )
			wp_send_json_error( array( 'message' => __( 'Requested element is invalid. Please check your request', 'digirisk' ), ) );

		$element = group_class::get()->show( $element_id );

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

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$src_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );

		/**	Définition de la structure des données du document par défaut / Define the default data structure for document	*/
		$element_file_details = array(
			'identifiantElement'	=> $element->option[ 'unique_identifier' ],
			'nomEntreprise'			=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'company_name' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'company_name' ] ) ) : $element->title,
			'dateAudit'				=> $audit_date,
			'emetteurDUER'			=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_transmitter' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_transmitter' ] ) ) : $element->title,
			'destinataireDUER'		=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient' ] ) ) : $element->title,
			'dateGeneration'		=> mysql2date( get_option( 'date_format' ), current_time( 'mysql', 0 ), true ),
			'telephone'				=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient_phone' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient_phone' ] ) ) : implode( ',', $element->option[ 'contact' ][ 'phone' ] ),
			'portable'				=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'document_recipient_cellphone' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'document_recipient_cellphone' ] ) ) : '',

			'methodologie'			=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_methodology' ] ) ? sanitize_text_field( strip_tags( stripslashes( $_POST[ 'wpdigi_duer' ][ 'audit_methodology' ] ) ) ) : '',
			'sources'				=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_sources' ] ) ? sanitize_text_field( strip_tags( stripslashes( $_POST[ 'wpdigi_duer' ][ 'audit_sources' ] ) ) ) : '',
			'remarqueImportante'	=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_important_note' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_important_note' ] ) ) : '',
			'dispoDesPlans'			=> !empty( $_POST ) && !empty( $_POST[ 'wpdigi_duer' ] ) && !empty( $_POST[ 'wpdigi_duer' ][ 'audit_location' ] ) ? sanitize_text_field( strip_tags( $_POST[ 'wpdigi_duer' ][ 'audit_location' ] ) ) : '',

			'elementParHierarchie'	=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risq'					=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risqueFiche'			=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risqPA'				=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDactionRisq'		=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDaction'			=> array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
		);
		$level_list = array( 48, 51, 80, );
		foreach ( $level_list as $level ) {
			$element_file_details[ 'risq' . $level ] = array(
				'type'	=> 'segment',
				'value'	=> array(),
			);
			$element_file_details[ 'risqPA' . $level ] = array(
				'type'	=> 'segment',
				'value'	=> array(),
			);
			$element_file_details[ 'planDactionRisq' . $level ] = array(
				'type'	=> 'segment',
				'value'	=> array(),
			);
		}

		/**	Récupération de la liste des risques pour l'élément actuel et ses sous-éléments	de façon récursive / Get risks list for current element and recursivly sub elements */
		$risk_details = $this->get_element_tree_risk( $element );

		$risk_per_element = array();
		foreach ( $risk_details as $risk_for_export ) {
			$final_level = scale_util::get_scale( $risk_for_export[ 'niveauRisque' ] );
			$element_file_details[ 'risq' . $final_level ][ 'value' ][] = $risk_for_export;
			$element_file_details[ 'risqPA' . $final_level ][ 'value' ][] = $risk_for_export;
			$element_file_details[ 'planDactionRisq' . $final_level ][ 'value' ][] = $risk_for_export;

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

		/**	Possibilité de filtrer les données envoyées au document pour ajout, suppression, traitement supplémentaire / Add capability to filter datas sended to the document for addition, deletion or other treatment	*/
		$element_file_details = apply_filters( 'wpdigi_element_duer_details', $element_file_details );

		/**	Call document creation function / Appel de la fonction de création du document	*/
		$document_creation_response = document_class::get()->create_document( $element, array( 'document_unique' ), $element_file_details );
		if ( !empty( $document_creation_response[ 'id' ] ) ) {
			$element->option[ 'associated_document_id' ][ 'document' ][] = $document_creation_response[ 'id' ];
			$element = group_class::get()->update( $element );
			$element = group_class::get()->show( $element->id );
		}

		/**	Merge response of current function and document generation function	*/
		$response = wp_parse_args( $document_creation_response, $response );

		// Generate children
		$list_id = array();

		/**	Build a file list to set into the final zip / Contruit la liste des fichiers a ajouter dans le zip lorsque les générations sont terminées	*/
		$response['file'] = array();
		$response['file'][] = sheet_groupment_class::get()->generate_sheet( $element->id );

		/**	Get workunit list for the current group / Récupération de la liste des unités de travail pour le groupement actuel	*/
		$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach( $work_unit_list as $workunit ) {
			$response['file'][] = workunit_class::get()->generate_workunit_sheet( $workunit->id );
		}

		$list_id = $this->get_element_sub_tree_id( $element->id, $list_id );
		if ( !empty( $list_id ) ) {
			foreach( $list_id as $element ) {
				if( !empty( $element['workunit'] ) ) {
					if( !empty( $element['id'] ) ) {
						$response['file'][] = sheet_groupment_class::get()->generate_sheet( $element['id'] );
					}
					foreach( $element['workunit'] as $workunit_id ) {
						$response['file'][] = workunit_class::get()->generate_workunit_sheet( $workunit_id['id'] );
					}
				}
				else {
					if( !empty( $element['id'] ) ) {
						$response['file'][] = sheet_groupment_class::get()->generate_sheet( $element['id'] );
					}
				}
			}
		}

		$response['link'] = $document_creation[ 'link' ];

		/**	Generate a zip file with all sheet for current group, sub groups, and sub work units / Génération du fichier zip contenant les fiches du groupement actuel, des sous groupements et des unités de travail	*/
		$zip_generation_result = document_class::get()->create_zip( document_class::get()->get_document_path() . '/' . $element_duer_media_args['type'] . '/' . $element_duer_media_args['id'] . '/' . $element_duer_media_args[ 'post_title' ] . '_merged.zip', $response['file'], $element );
		if ( !empty( $zip_generation_result[ 'file_id' ] ) ) {
			$element->option[ 'associated_document_id' ][ 'document' ][] = $zip_generation_result[ 'file_id' ];
			$element = group_class::get()->update( $element );
		}

		wp_die( json_encode( $response ) );
	}

	public function get_element_sub_tree( $element, $tabulation = '', $extra_params = null ) {
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
		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id , 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$element_children = array_merge( $element_children, $this->get_element_sub_tree( $group, $tabulation . '-', $extra_params ) );
		}

		$tabulation = $tabulation . '-';
		$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
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
		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id , 'post_status' => array( 'publish', 'draft', ), ), false );
		if( !empty( $group_list ) ) {
			foreach ( $group_list as $group ) {
				$list_id[] = array( 'id' => $group->id, 'workunit' => array() );
				// $list_id[count($list_id) - 1] = array();
				// $list_id[count($list_id) - 1]['workunit'] = array();
				$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $group->id, 'post_status' => array( 'publish', 'draft', ), ), false );
				foreach ( $work_unit_list as $workunit ) {
					$list_id[count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
				}
				$list_id = $this->get_element_sub_tree_id( $group->id, $list_id );
			}
		}
		else {
			$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id, 'post_status' => array( 'publish', 'draft', ), ), false );
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
		$risks_in_tree = array();

		$risks_in_tree = $this->build_risk_list_for_export( $element );

		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$risks_in_tree = array_merge( $risks_in_tree, $this->get_element_tree_risk( $group ) );
		}

		$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
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

		$risk_list = risk_class::get()->index( array(
			'include' => $element->option[ 'associated_risk' ],
		) );
		$element_duer_details = array();
		foreach ( $risk_list as $risk ) {
			$complete_risk = risk_class::get()->get_risk( $risk->id );
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

new group_action();
