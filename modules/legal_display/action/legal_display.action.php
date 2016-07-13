<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_action {
	/**
	* Le constructeur appelle l'action personnalisée suivante: save_legal_display (Enregistres les données de l'affichage légal)
	*/
  public function __construct() {
    add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 );
  }

	/**
	* Sauvegardes les données de l'affichage légal dans la base de donnée
	*
	* array $_POST['emergency_service'] Les données du formulaire pour le service d'urgence
	* array $_POST['working_hour'] Les données du formulaire pour les horaires de travail
	* array $_POST['safety_rule'] Les données du formulaire pour les consignes de sécurité
	* array $_POST['derogation_schedule'] Les données du formulaire pour les dérogations aux horaires de travail
	* array $_POST['collective_agreement'] Les données du formulaire pour les conventions collectives applicables
	* array $_POST['DUER'] Les données du formulaire pour le document unique d'évaluation des risques
	* array $_POST['rules'] Les données du formulaire pour le règlement intérieur
	* int $_POST['parent_id'] L'ID de l'élément parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
  public function callback_save_legal_display( $detective_work_third, $occupational_health_service_third ) {
    // Récupère les tableaux
    $emergency_service = !empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
    $working_hour = !empty( $_POST['working_hour'] ) ? (array) $_POST['working_hour'] : array();
    $safety_rule = !empty( $_POST['safety_rule'] ) ? (array) $_POST['safety_rule'] : array();
    $derogation_schedule = !empty( $_POST['derogation_schedule'] ) ? (array) $_POST['derogation_schedule'] : array();
    $collective_agreement = !empty( $_POST['collective_agreement'] ) ? (array) $_POST['collective_agreement'] : array();
    $DUER = !empty( $_POST['DUER'] ) ? (array) $_POST['DUER'] : array();
    $rules = !empty( $_POST['rules'] ) ? (array) $_POST['rules'] : array();
    $parent_id = !empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

    $last_unique_key = wpdigi_utils::get_last_unique_key( 'post', legal_display_class::get()->get_post_type() );
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
      'unique_identifier' => legal_display_class::get()->element_prefix . $last_unique_key,
      'unique_key' => $last_unique_key,
      'parent_id' => $parent_id,
    );

    $legal_display = legal_display_class::get()->save_data( $legal_display_data );

		// Toutes les données de l'affichage légal
		$all_data = legal_display_class::get()->load_data( $parent_id );
		$element_parent = group_class::get()->show( $parent_id );

    $this->generate_sheet( $all_data, $element_parent );

		// Bug des modèles
		$element_parent = group_class::get()->show( $parent_id );

    $this->generate_sheet( $all_data, $element_parent, "A3" );

    wp_send_json_success();
  }

	/**
	* Génère l'ODT de l'affichage légal
	*
	* @param array $data Toutes les données de l'affichage légal
	* @param object $element_parent L'objet parent
	* @param string $format (Optional) Le format voulu A4 ou A3
	*/
  public function generate_sheet( $data, $element_parent, $format = "A4" ) {
		// A déplacer dans la class
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

		$document_creation = document_class::get()->create_document( $element_parent, array( 'affichage_legal_' . $format ), $legal_display_sheet_details );

		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		$element_parent->option['associated_document_id']['document'][] = $document_creation['id'];
		group_class::get()->update( $element_parent );
	}


}

new legal_display_action();
