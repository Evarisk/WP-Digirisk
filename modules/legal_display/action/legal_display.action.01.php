<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_action_01 {
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

    wp_send_json_success();
  }

  public function generate_sheet( $data, $element_parent ) {
		/**	Début de la génération du document / Start document generation	*/
		$document_controller = new document_controller_01();

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$group_model_to_use = null;
		$group_model_id_to_use = !empty( $_POST ) && !empty( $_POST[ 'document_model_id' ] ) && is_int( (int)$_POST[ 'document_model_id' ] ) ? (int)$_POST[ 'document_model_id' ] : null ;

		/**	Récupération de la liste des modèles existants pour l'élément actuel / Get model list for current group	*/
		if ( null === $group_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'affichage_legal_A4', ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

      $group_model_to_use = $response['model_path'];
    }

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'affichage_legal_A4' ), $data['legal_display']->id );

		ini_set("display_errors", true);
		error_reporting(E_ALL);

		/**	Définition finale de l'affichage légal	*/
		$legal_display_sheet_details = array(
      'inspection_du_travail_nom' => $data['detective_work']->option['full_name'],
      'inspection_du_travail_adresse' => $data['detective_work']->address->option['address'],
      'inspection_du_travail_code_postal' => $data['detective_work']->address->option['postcode'],
      'inspection_du_travail_ville' => $data['detective_work']->address->option['town'],
      'inspection_du_travail_telephone' => max( $data['detective_work']->option['contact']['phone'] ),
      'inspection_du_travail_horaire' => $data['detective_work']->option['opening_time'],

      'service_de_sante_au_travail_nom' => $data['occupational_health_service']->option['full_name'],
      'service_de_sante_au_travail_adresse' => $data['occupational_health_service']->address->option['address'],
      'service_de_sante_au_travail_code_postal' => $data['occupational_health_service']->address->option['postcode'],
      'service_de_sante_au_travail_ville' => $data['occupational_health_service']->address->option['town'],
      'service_de_sante_au_travail_telephone' => max( $data['occupational_health_service']->option['contact']['phone'] ),
			'service_de_sante_au_travail_horaire' => $data['occupational_health_service']->option['opening_time'],

      'samu' => $data['legal_display']->option['emergency_service']['samu'],
      'police' => $data['legal_display']->option['emergency_service']['police'],
      'pompiers' => $data['legal_display']->option['emergency_service']['pompier'],
      'toute_urgence' => $data['legal_display']->option['emergency_service']['emergency'],
      'defenseur_des_droits' => $data['legal_display']->option['emergency_service']['right_defender'],
      'anti_poison' => $data['legal_display']->option['emergency_service']['poison_control_center'],

      'responsable_a_prevenir' => $data['legal_display']->option['safety_rule']['responsible_for_preventing'],
      'telephone' => $data['legal_display']->option['safety_rule']['phone'],
      'emplacement_des_consignes_detaillees' => $data['legal_display']->option['safety_rule']['location_of_detailed_instruction'],

      'permanentes' => $data['legal_display']->option['derogation_schedule']['permanent'],
      'occasionnelles' => $data['legal_display']->option['derogation_schedule']['occasional'],

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

    $document_creation = $document_controller->create_document( $group_model_to_use, $legal_display_sheet_details, $element_parent->type. '/' . $element_parent->id . '/affichage_legal_A4.odt' , null );
    $upload_dir = wp_upload_dir();
    $response['path'] = $upload_dir['baseurl'] . '/digirisk/' . $element_parent->type. '/' . $element_parent->id . '/affichage_legal_A4.odt';
		wp_send_json_success( $response );
	}


}

new legal_display_action_01();
