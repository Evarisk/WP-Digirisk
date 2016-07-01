<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_action {
  public function __construct() {
    add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 );
  }

  public function callback_save_legal_display( $detective_work_third, $occupational_health_service_third ) {
    global $legal_display_ctr;
		global $wpdigi_group_ctr;

    // Récupère les tableaux
    $emergency_service = !empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
    $working_hour = !empty( $_POST['working_hour'] ) ? (array) $_POST['working_hour'] : array();
    $safety_rule = !empty( $_POST['safety_rule'] ) ? (array) $_POST['safety_rule'] : array();
    $derogation_schedule = !empty( $_POST['derogation_schedule'] ) ? (array) $_POST['derogation_schedule'] : array();
    $collective_agreement = !empty( $_POST['collective_agreement'] ) ? (array) $_POST['collective_agreement'] : array();
    $DUER = !empty( $_POST['DUER'] ) ? (array) $_POST['DUER'] : array();
    $rules = !empty( $_POST['rules'] ) ? (array) $_POST['rules'] : array();
    $parent_id = !empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

    $last_unique_key = wpdigi_utils::get_last_unique_key( 'post', $legal_display_ctr->get_post_type() );
		$last_unique_key++;

    // @todo sécurisé
    $legal_display_data = array(
      'detective_work_id' => $detective_work_third->id,
      'occupational_health_service_id' => $occupational_health_service_third->id,
      'emergency_service' => $emergency_service,
      'safety_rule' => $safety_rule,
      'working_hour' => $working_hour,
      'derogation_schedule' => $derogation_schedule,
      'collective_agreement' => $collective_agreement,
      'DUER' => $DUER,
      'rules' => $rules,
      'unique_identifier' => $legal_display_ctr->element_prefix . $last_unique_key,
      'unique_key' => $last_unique_key,
      'parent_id' => $parent_id,
    );

    $legal_display = $legal_display_ctr->save_data( $legal_display_data );

		// Toutes les données de l'affichage légal
		$all_data = $legal_display_ctr->load_data( $parent_id );
		$element_parent = $wpdigi_group_ctr->show( $parent_id );

    $this->generate_sheet( $all_data, $element_parent );

		// Bug des modèles
		$element_parent = $wpdigi_group_ctr->show( $parent_id );

    $this->generate_sheet( $all_data, $element_parent, "A3" );

    wp_send_json_success();
  }

  public function generate_sheet( $data, $element_parent, $format = "A4" ) {
		global $wpdigi_group_ctr;

		/**	Début de la génération du document / Start document generation	*/
		$document_controller = new document_controller_01();

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$group_model_to_use = null;
		$group_model_id_to_use = !empty( $_POST ) && !empty( $_POST[ 'document_model_id' ] ) && is_int( (int)$_POST[ 'document_model_id' ] ) ? (int)$_POST[ 'document_model_id' ] : null ;

		/**	Récupération de la liste des modèles existants pour l'élément actuel / Get model list for current group	*/
		if ( null === $group_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'affichage_legal_' . $format, ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

      $group_model_to_use = $response['model_path'];
    }

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'legal_display' ), $element_parent->id );

		/**	Définition finale de l'affichage légal	*/
		$legal_display_sheet_details = array(
      'inspection_du_travail_nom' => $data['detective_work']->option['full_name'],
      'inspection_du_travail_adresse' => $data['detective_work']->address->option['address'],
      'inspection_du_travail_code_postal' => $data['detective_work']->address->option['postcode'],
      'inspection_du_travail_ville' => $data['detective_work']->address->option['town'],
      'inspection_du_travail_telephone' => max( $data['detective_work']->option['contact']['phone'] ),
      'inspection_du_travail_horaire' => $data['detective_work']->option['opening_time'],

      'service_de_sante_nom' => $data['occupational_health_service']->option['full_name'],
      'service_de_sante_adresse' => $data['occupational_health_service']->address->option['address'],
      'service_de_sante_code_postal' => $data['occupational_health_service']->address->option['postcode'],
      'service_de_sante_ville' => $data['occupational_health_service']->address->option['town'],
      'service_de_sante_telephone' => max( $data['occupational_health_service']->option['contact']['phone'] ),
			'service_de_sante_horaire' => $data['occupational_health_service']->option['opening_time'],

      'samu' => $data['legal_display']->option['emergency_service']['samu'],
      'police' => $data['legal_display']->option['emergency_service']['police'],
      'pompier' => $data['legal_display']->option['emergency_service']['pompier'],
      'toute_urgence' => $data['legal_display']->option['emergency_service']['emergency'],
      'defenseur_des_droits' => $data['legal_display']->option['emergency_service']['right_defender'],
      'anti_poison' => $data['legal_display']->option['emergency_service']['poison_control_center'],

      'responsable_a_prevenir' => $data['legal_display']->option['safety_rule']['responsible_for_preventing'],
      'telephone' => $data['legal_display']->option['safety_rule']['phone'],
      'emplacement_des_consignes_detaillees' => $data['legal_display']->option['safety_rule']['location_of_detailed_instruction'],

      'permanente' => $data['legal_display']->option['derogation_schedule']['permanent'],
      'occasionnelle' => $data['legal_display']->option['derogation_schedule']['occasional'],

      'intitule' => $data['legal_display']->option['collective_agreement']['title_of_the_applicable_collective_agreement'],
      'lieu_modalite' => $data['legal_display']->option['collective_agreement']['location_and_access_terms_of_the_agreement'],

      'lieu_affichage' =>$data['legal_display']->option['rules']['location'],
      'modalite_access' =>$data['legal_display']->option['DUER']['how_access_to_duer'],

			'lundi_matin' => $data['legal_display']->option['working_hour']['monday_morning'],
			'mardi_matin' => $data['legal_display']->option['working_hour']['tuesday_morning'],
			'mercredi_matin' => $data['legal_display']->option['working_hour']['wednesday_morning'],
			'jeudi_matin' => $data['legal_display']->option['working_hour']['thursday_morning'],
			'vendredi_matin' => $data['legal_display']->option['working_hour']['friday_morning'],
			'samedi_matin' => $data['legal_display']->option['working_hour']['saturday_morning'],
			'dimanche_matin' => $data['legal_display']->option['working_hour']['sunday_morning'],

			'lundi_aprem' => $data['legal_display']->option['working_hour']['monday_afternoon'],
			'mardi_aprem' => $data['legal_display']->option['working_hour']['tuesday_afternoon'],
			'mercredi_aprem' => $data['legal_display']->option['working_hour']['wednesday_afternoon'],
			'jeudi_aprem' => $data['legal_display']->option['working_hour']['thursday_afternoon'],
			'vendredi_aprem' => $data['legal_display']->option['working_hour']['friday_afternoon'],
			'samedi_aprem' => $data['legal_display']->option['working_hour']['saturday_afternoon'],
			'dimanche_aprem' => $data['legal_display']->option['working_hour']['sunday_afternoon'],
		);

		$attachment_detail = array(
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_author'		 => get_current_user_id(),
			'post_date'			 => current_time( 'mysql', 0 ),
			'post_title'		 => mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_affichage_legal_' . $element_parent->option['unique_identifier'] . '_' . $format . '_V' . $document_revision,
			'id' 							=> $element_parent->id,
			'type'						=> $element_parent->type,
		);

		$legal_display_attachment_id = wp_insert_attachment( $attachment_detail, '', $element_parent->id );

    $document_creation = $document_controller->create_document( $group_model_to_use, $legal_display_sheet_details, $element_parent->type. '/' . $element_parent->id . '/' . $attachment_detail['post_title'] . '.odt', null );
		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		$element_parent->option['associated_document_id']['document'][] = $legal_display_attachment_id;
		$wpdigi_group_ctr->update( $element_parent );
		wp_set_object_terms( $legal_display_attachment_id, array( 'printed', 'legal_display', ), $document_controller->attached_taxonomy_type );

		/**	On met à jour les informations concernant le document dans la base de données / Update data for document into database	*/
		$next_document_key = ( wpdigi_utils::get_last_unique_key( 'post', $document_controller->get_post_type() ) + 1 );
		$sheet_args = array(
			'id'					=> $legal_display_attachment_id,
			'status'    	=> 'inherit',
			'author_id'		=> get_current_user_id(),
			'date'			 	=> current_time( 'mysql', 0 ),
			'mime_type'		=> $filetype[ 'type' ],
			'option'			=> array (
				'unique_key'						=> $next_document_key,
				'unique_identifier' 		=> $document_controller->element_prefix . $next_document_key,
				'model_id' 							=> $group_model_to_use,
				'document_meta' 				=> json_encode( $legal_display_sheet_details ),
				'version'								=> '',
			),
		);
		 $document_controller->update( $sheet_args );
	}


}

new legal_display_action();
