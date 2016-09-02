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
      'parent_id' => $parent_id,
    );

    $legal_display = legal_display_class::g()->save_data( $legal_display_data );
		$legal_display = legal_display_class::g()->get( array( 'id' => $legal_display->id ), array( 'detective_work', 'address', 'occupational_health_service' ) );
		$legal_display = $legal_display[0];

		// Toutes les données de l'affichage légal
		// $all_data = legal_display_class::g()->load_data( $parent_id );
		$element_parent = group_class::g()->get( array( 'id' => $parent_id ) );

    $this->generate_sheet( $legal_display, $element_parent[0] );
    $this->generate_sheet( $legal_display, $element_parent[0], "A3" );

    wp_send_json_success();
  }

	/**
	* Génère l'ODT de l'affichage légal
	*
	* @param array $data Toutes les données de l'affichage légal
	* @param object $element_parent L'objet parent
	* @param string $format (Optional) Le format voulu A4 ou A3
	*/
  public function generate_sheet( $legal_display, $element_parent, $format = "A4" ) {
		// A déplacer dans la class
		/**	Définition finale de l'affichage légal	*/
		$legal_display_sheet_details = array(
      'inspection_du_travail_nom' => $legal_display->detective_work[0]->full_name,
      'inspection_du_travail_adresse' => $legal_display->detective_work[0]->address[0]->address,
      'inspection_du_travail_code_postal' => $legal_display->detective_work[0]->address[0]->postcode,
      'inspection_du_travail_ville' => $legal_display->detective_work[0]->address[0]->town,
      'inspection_du_travail_telephone' => $legal_display->detective_work[0]->contact['phone'],
      'inspection_du_travail_horaire' => $legal_display->detective_work[0]->opening_time,

      'service_de_sante_nom' => $legal_display->occupational_health_service[0]->full_name,
      'service_de_sante_adresse' => $legal_display->occupational_health_service[0]->address[0]->address,
      'service_de_sante_code_postal' => $legal_display->occupational_health_service[0]->address[0]->postcode,
      'service_de_sante_ville' => $legal_display->occupational_health_service[0]->address[0]->town,
      'service_de_sante_telephone' => $legal_display->occupational_health_service[0]->contact['phone'],
			'service_de_sante_horaire' => $legal_display->occupational_health_service[0]->opening_time,

      'samu' => $legal_display->emergency_service['samu'],
      'police' => $legal_display->emergency_service['police'],
      'pompier' => $legal_display->emergency_service['pompier'],
      'toute_urgence' => $legal_display->emergency_service['emergency'],
      'defenseur_des_droits' => $legal_display->emergency_service['right_defender'],
      'anti_poison' => $legal_display->emergency_service['poison_control_center'],

      'responsable_a_prevenir' => $legal_display->safety_rule['responsible_for_preventing'],
      'telephone' => $legal_display->safety_rule['phone'],
      'emplacement_des_consignes_detaillees' => $legal_display->safety_rule['location_of_detailed_instruction'],

      'permanente' => $legal_display->derogation_schedule['permanent'],
      'occasionnelle' => $legal_display->derogation_schedule['occasional'],

      'intitule' => $legal_display->collective_agreement['title_of_the_applicable_collective_agreement'],
      'lieu_modalite' => $legal_display->collective_agreement['location_and_access_terms_of_the_agreement'],

      'lieu_affichage' => $legal_display->rules['location'],
      'modalite_access' => $legal_display->DUER['how_access_to_duer'],

			'lundi_matin' => $legal_display->working_hour['monday_morning'],
			'mardi_matin' => $legal_display->working_hour['tuesday_morning'],
			'mercredi_matin' => $legal_display->working_hour['wednesday_morning'],
			'jeudi_matin' => $legal_display->working_hour['thursday_morning'],
			'vendredi_matin' => $legal_display->working_hour['friday_morning'],
			'samedi_matin' => $legal_display->working_hour['saturday_morning'],
			'dimanche_matin' => $legal_display->working_hour['sunday_morning'],

			'lundi_aprem' => $legal_display->working_hour['monday_afternoon'],
			'mardi_aprem' => $legal_display->working_hour['tuesday_afternoon'],
			'mercredi_aprem' => $legal_display->working_hour['wednesday_afternoon'],
			'jeudi_aprem' => $legal_display->working_hour['thursday_afternoon'],
			'vendredi_aprem' => $legal_display->working_hour['friday_afternoon'],
			'samedi_aprem' => $legal_display->working_hour['saturday_afternoon'],
			'dimanche_aprem' => $legal_display->working_hour['sunday_afternoon'],
		);

		$document_creation = document_class::g()->create_document( $element_parent, array( 'affichage_legal_' . $format ), $legal_display_sheet_details );

		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		$element_parent->associated_document_id['document'][] = $document_creation['id'];
		group_class::g()->update( $element_parent );
	}


}

new legal_display_action();
