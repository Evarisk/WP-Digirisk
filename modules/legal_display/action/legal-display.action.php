<?php
/**
 * Les actions relatives aux affichages légaux
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.1.5
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux affichages légaux
 */
class Legal_Display_Action {

	/**
	 * Le constructeur appelle l'action personnalisée suivante: save_legal_display (Enregistres les données de l'affichage légal)
	 *
	 * @since   6.1.5
	 * @version 6.2.4
	 */
	public function __construct() {
		add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 );
	}

	/**
	 * Sauvegardes les données de l'affichage légal dans la base de donnée
	 *
	 * @since   6.1.5
	 * @version 7.0.0
	 *
	 * @param Third_Model $detective_work_third Les données de l'inspecteur du travail.
	 * @param Third_Model $occupational_health_service_third Les données du service de santé au travail.
	 */
	public function callback_save_legal_display( $detective_work_third, $occupational_health_service_third ) {
		check_ajax_referer( 'save_legal_display' );

		// Récupère les tableaux.
		$emergency_service       = ! empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
		$working_hour            = ! empty( $_POST['working_hour'] ) ? (array) $_POST['working_hour'] : array();
		$safety_rule             = ! empty( $_POST['safety_rule'] ) ? (array) $_POST['safety_rule'] : array();
		$derogation_schedule     = ! empty( $_POST['derogation_schedule'] ) ? (array) $_POST['derogation_schedule'] : array();
		$collective_agreement    = ! empty( $_POST['collective_agreement'] ) ? (array) $_POST['collective_agreement'] : array();
		$duer                    = ! empty( $_POST['DUER'] ) ? (array) $_POST['DUER'] : array();
		$rules                   = ! empty( $_POST['rules'] ) ? (array) $_POST['rules'] : array();
		$participation_agreement = ! empty( $_POST['participation_agreement'] ) ? (array) $_POST['participation_agreement'] : array();
		$parent_id               = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		// @todo sécurisé
		$legal_display_data = array(
			'detective_work_id'              => $detective_work_third->data['id'],
			'occupational_health_service_id' => $occupational_health_service_third->data['id'],
			'emergency_service'              => $emergency_service,
			'safety_rule'                    => $safety_rule,
			'working_hour'                   => $working_hour,
			'derogation_schedule'            => $derogation_schedule,
			'collective_agreement'           => $collective_agreement,
			'participation_agreement'        => $participation_agreement,
			'DUER'                           => $duer,
			'rules'                          => $rules,
			'parent_id'                      => $parent_id,
			'status'                         => 'inherit',
		);

		$legal_display = Legal_Display_Class::g()->save_data( $legal_display_data );

		$legal_display = Legal_Display_Class::g()->get( array(
			'id' => $legal_display->data['id'],
		), true );

		$element_parent = Society_Class::g()->get( array(
			'id' => $parent_id,
		), true );

		$result = array();

		$result['A3'] = $this->generate_sheet( $legal_display, $element_parent, 'A3' );
		$result['A4'] = $this->generate_sheet( $legal_display, $element_parent );

		ob_start();
		Legal_Display_Class::g()->display( $element_parent );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'legalDisplay',
			'callback_success' => 'generatedSuccess',
			'legal_display'    => $legal_display,
			'result'           => $result,
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Génère l'ODT de l'affichage légal
	 *
	 * @since   6.1.5
	 * @version 7.0.0
	 *
	 * @param array  $legal_display Toutes les données de l'affichage légal.
	 * @param object $element_parent L'objet parent.
	 * @param string $format (Optional) Le format voulu A4 ou A3.
	 *
	 * @return array $document_creation Les données de la création du document.
	 */
	public function generate_sheet( $legal_display, $element_parent, $format = 'A4' ) {
		$legal_display_sheet_details = array(
			'inspection_du_travail_nom'            => $legal_display->data['detective_work']->data['full_name'],
			'inspection_du_travail_adresse'        => $legal_display->data['detective_work']->data['address']->data['address'],
			'inspection_du_travail_code_postal'    => $legal_display->data['detective_work']->data['address']->data['postcode'],
			'inspection_du_travail_ville'          => $legal_display->data['detective_work']->data['address']->data['town'],
			'inspection_du_travail_telephone'      => $legal_display->data['detective_work']->data['contact']['phone'],
			'inspection_du_travail_horaire'        => $legal_display->data['detective_work']->data['opening_time'],

			'service_de_sante_nom'                 => $legal_display->data['occupational_health_service']->data['full_name'],
			'service_de_sante_adresse'             => $legal_display->data['occupational_health_service']->data['address']->data['address'],
			'service_de_sante_code_postal'         => $legal_display->data['occupational_health_service']->data['address']->data['postcode'],
			'service_de_sante_ville'               => $legal_display->data['occupational_health_service']->data['address']->data['town'],
			'service_de_sante_telephone'           => $legal_display->data['occupational_health_service']->data['contact']['phone'],
			'service_de_sante_horaire'             => $legal_display->data['occupational_health_service']->data['opening_time'],

			'samu'                                 => $legal_display->data['emergency_service']['samu'],
			'police'                               => $legal_display->data['emergency_service']['police'],
			'pompier'                              => $legal_display->data['emergency_service']['pompier'],
			'toute_urgence'                        => $legal_display->data['emergency_service']['emergency'],
			'defenseur_des_droits'                 => $legal_display->data['emergency_service']['right_defender'],
			'anti_poison'                          => $legal_display->data['emergency_service']['poison_control_center'],

			'responsable_a_prevenir'               => $legal_display->data['safety_rule']['responsible_for_preventing'],
			'telephone'                            => $legal_display->data['safety_rule']['phone'],
			'emplacement_des_consignes_detaillees' => $legal_display->data['safety_rule']['location_of_detailed_instruction'],

			'permanente'                           => $legal_display->data['derogation_schedule']['permanent'],
			'occasionnelle'                        => $legal_display->data['derogation_schedule']['occasional'],

			'intitule'                             => $legal_display->data['collective_agreement']['title_of_the_applicable_collective_agreement'],
			'lieu_modalite'                        => $legal_display->data['collective_agreement']['location_and_access_terms_of_the_agreement'],

			'lieu_affichage'                       => $legal_display->data['rules']['location'],
			'modalite_access'                      => $legal_display->data['DUER']['how_access_to_duer'],

			'lundi_matin'                          => $legal_display->data['working_hour']['monday_morning'],
			'mardi_matin'                          => $legal_display->data['working_hour']['tuesday_morning'],
			'mercredi_matin'                       => $legal_display->data['working_hour']['wednesday_morning'],
			'jeudi_matin'                          => $legal_display->data['working_hour']['thursday_morning'],
			'vendredi_matin'                       => $legal_display->data['working_hour']['friday_morning'],
			'samedi_matin'                         => $legal_display->data['working_hour']['saturday_morning'],
			'dimanche_matin'                       => $legal_display->data['working_hour']['sunday_morning'],

			'lundi_aprem'                          => $legal_display->data['working_hour']['monday_afternoon'],
			'mardi_aprem'                          => $legal_display->data['working_hour']['tuesday_afternoon'],
			'mercredi_aprem'                       => $legal_display->data['working_hour']['wednesday_afternoon'],
			'jeudi_aprem'                          => $legal_display->data['working_hour']['thursday_afternoon'],
			'vendredi_aprem'                       => $legal_display->data['working_hour']['friday_afternoon'],
			'samedi_aprem'                         => $legal_display->data['working_hour']['saturday_afternoon'],
			'dimanche_aprem'                       => $legal_display->data['working_hour']['sunday_afternoon'],

			'modalite_information_ap'              => $legal_display->data['participation_agreement']['information_procedures'],
		);

		$class             = '\digi\Legal_Display_' . $format . '_Class';
		$document_creation = $class::g()->create_document( $element_parent, array( 'affichage_legal_' . $format ), $legal_display_sheet_details );

		$filetype = 'unknown';
		if ( ! empty( $document_creation ) && ! empty( $document_creation['status'] ) && ! empty( $document_creation['link'] ) ) {
			$filetype = wp_check_filetype( $document_creation['link'], null );
		}

		$element_parent->associated_document_id['document'][] = $document_creation['id'];

		Society_Class::g()->update( $element_parent );

		return $document_creation;
	}


}

new Legal_Display_Action();
