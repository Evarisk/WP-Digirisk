<?php
/**
 * Gestion des filtres relatifs aux affichages légaux.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Legal Display Filter Class.
 */
class Legal_Display_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since   6.0.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );

		$current_type = Legal_Display_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_legal_display' ), 10, 2 );

		add_filter( 'digi_affichage_legal_A4_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
		add_filter( 'digi_affichage_legal_A3_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet affichage légal dans les groupements.
	 *
	 * @since   6.0.0
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['legal_display'] = array(
			'type'  => 'text',
			'text'  => __( 'Affichage légal', 'digirisk' ),
			'title' => __( 'Les affichages légales', 'digirisk' ),
			'icon'  => '<i class="fas fa-file-certificate"></i>',
		);
		return $list_tab;
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement de l'affichage légal
	 * Inspection du travail avec son adresse, Nom du médecin avec son adresse
	 *
	 * @since   6.0.0
	 *
	 * @param  Legal_Display_Model $object L'objet.
	 * @param  array               $args   Les paramètres de la requête.
	 *
	 * @return Legal_Display_Model         L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_legal_display( $object, $args ) {
		$args_detective_work                      = array( 'schema' => true );
		$args_detective_work_address              = array( 'schema' => true );
		$args_occupational_health_service         = array( 'schema' => true );
		$args_occupational_health_service_address = array( 'schema' => true );

		if ( ! empty( $object->data['id'] ) ) {
			$args_detective_work              = array( 'id' => $object->data['detective_work_id'] );
			$args_occupational_health_service = array( 'id' => $object->data['occupational_health_service_id'] );
		}

		$object->data['detective_work'] = Third_Class::g()->get( $args_detective_work, true );

		if ( ! empty( $object->data['detective_work']->data['contact']['address_id'] ) ) {
			$args_detective_work_address = array( 'id' => $object->data['detective_work']->data['contact']['address_id'] );
		}

		$object->data['detective_work']->data['address'] = Address_Class::g()->get( $args_detective_work_address, true );

		$object->data['occupational_health_service'] = Third_Class::g()->get( $args_occupational_health_service, true );

		if ( ! empty( $object->data['occupational_health_service']->data['contact']['address_id'] ) ) {
			$args_occupational_health_service_address = array( 'id' => $object->data['occupational_health_service']->data['contact']['address_id'] );
		}

		$object->data['occupational_health_service']->data['address'] = Address_Class::g()->get( $args_occupational_health_service_address, true );

		return $object;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array         $data    Les données pour le registre des AT bénins.
	 * @param  Society_Model $society Les données de la société.
	 *
	 * @return array                  Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$legal_display = $args['legal_display'];

		$data = array(
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

		return $data;
	}
}

new Legal_Display_Filter();
