<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_action_01 {
  public function __construct() {
    add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 );
  }

  public function callback_save_legal_display( $detective_work_third, $occupational_health_service_third ) {
    global $legal_display_ctr;

    // Récupère les tableaux
    $emergency_service = !empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
    $working_hour = !empty( $_POST['working_hour'] ) ? (array) $_POST['working_hours'] : array();
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

    $this->generate_sheet( $legal_display );

    wp_send_json_success();
  }

  public function generate_sheet( $legal_display ) {
    global $legal_display_ctr;
    global $wpdigi_group_ctr;
    global $third_class;
    global $wpdigi_address_ctr;

    $group = $wpdigi_group_ctr->show( $parent_id );
    $response = array(
			'status' 	=> false,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'wpdigi-i18n' ),
		);

		/**	Début de la génération du document / Start document generation	*/
		$document_controller = new document_controller_01();

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$group_model_to_use = null;
		$group_model_id_to_use = !empty( $_POST ) && !empty( $_POST[ 'document_model_id' ] ) && is_int( (int)$_POST[ 'document_model_id' ] ) ? (int)$_POST[ 'document_model_id' ] : null ;

		/**	Récupération de la liste des modèles existants pour l'élément actuel / Get model list for current group	*/
		if ( null === $group_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'affichage_legal', ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

      $group_model_to_use = $response['model_path'];
    }

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'affichage_legal' ), $legal_display->id );

    $third_inspector = $third_class->show( $legal_display->option['detective_work_id'] );
    $third_inspector_address = $wpdigi_address_ctr->show( $third_inspector->option['contact']['address_id'] );

    $third_doctor = $third_class->show( $legal_display->option['occupational_health_service_id'] );
    $third_doctor_address = $wpdigi_address_ctr->show( $third_doctor->option['contact']['address_id'] );

		/**	Définition finale de l'affichage légal	*/
		$legal_display_sheet_details = array(
      'inspection_du_travail_nom' => $third_inspector->option['full_name'],
      'inspection_du_travail_adresse' => $third_inspector_address->option['address'],
      'inspection_du_travail_code_postal' => $third_inspector_address->option['postcode'],
      'inspection_du_travail_ville' => $third_inspector_address->option['town'],
      'inspection_du_travail_telephone' => max( $third_inspector->option['contact']['phone'] ),
      'service_de_sante_au_travail_nom' => $third_doctor->option['full_name'],
      'service_de_sante_au_travail_adresse' => $third_doctor_address->option['address'],
      'service_de_sante_au_travail_code_postal' => $third_doctor_address->option['postcode'],
      'service_de_sante_au_travail_ville' => $third_doctor_address->option['town'],
      'service_de_sante_au_travail_telephone' => max( $third_doctor->option['contact']['phone'] ),
      'samu' => $legal_display->option['emergency_service']['samu'],
      'police' => $legal_display->option['emergency_service']['police'],
      'pompiers' => $legal_display->option['emergency_service']['pompier'],
      'toute_urgence' => $legal_display->option['emergency_service']['emergency'],
      'defenseur_des_droits' => $legal_display->option['emergency_service']['right_defender'],
      'anti_poison' => $legal_display->option['emergency_service']['poison_control_center'],
      'responsable_a_prevenir' => $legal_display->option['safety_rule']['responsible_for_preventing'],
      'telephone' => $legal_display->option['safety_rule']['phone'],
      'emplacement_des_consignes_detaillees' => $legal_display->option['safety_rule']['location_of_detailed_instruction'],
      'permanente' => $legal_display->option['derogation_schedule']['permanent'],
      'occasionnelle' => $legal_display->option['derogation_schedule']['occasional'],
      'intitule' => $legal_display->option['document']['title_of_the_applicable_collective_agreement'],
      'lieu_et_modalites' => $legal_display->option['document']['location_and_access_terms_of_the_agreement'],
      'lieu_affichage' => $legal_display->option['document']['the_rule_of_procedure_display_location'],
      'modalite_access' => $legal_display->option['document']['how_access_to_duer'],
		);


    $document_creation = $document_controller->create_document( $group_model_to_use, $legal_display_sheet_details, $group->type. '/' . $group->id . '/affichage_legal.odt' , null );
    $upload_dir = wp_upload_dir();
    $response['path'] = $upload_dir['baseurl'] . '/digirisk/' . $group->type. '/' . $group->id . '/affichage_legal.odt';
		wp_send_json_success( $response );
	}


}

new legal_display_action_01();
