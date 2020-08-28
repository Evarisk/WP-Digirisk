<?php
/**
 * Les actions relatives aux affichages légaux
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.1.5
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
	 */
	public function __construct() {
		add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 ); // OLD 24/09/2019
		add_action( 'wp_ajax_generate_legal_display', array( $this, 'callback_generate_legal_display' ) );

		add_action( 'wp_ajax_save_society_information', array( $this, 'callback_save_society_information' ) );
		add_action( 'wp_ajax_save_society_information_more', array( $this, 'callback_save_society_information_more' ) );

		add_action( 'wp_ajax_save_detective_work', array( $this, 'callback_save_detective_work' ) );
		add_action( 'wp_ajax_save_emergency_work', array( $this, 'callback_save_emergency_work' ) );
		add_action( 'wp_ajax_save_health_service', array( $this, 'callback_save_health_service' ) );
		add_action( 'wp_ajax_save_others_informations', array( $this, 'callback_save_others_informations' ) );

		add_action( 'wp_ajax_save_staff_representatives', array( $this, 'callback_save_staff_representatives' ) );

		add_action( 'wp_ajax_save_working_hours', array( $this, 'callback_save_working_hours' ) );
	}

	/**
	 * Sauvegardes les données de l'affichage légal dans la base de donnée
	 *
	 * @since   6.1.5
	 *
	 * @param Third_Model $detective_work_third Les données de l'inspecteur du travail.
	 * @param Third_Model $occupational_health_service_third Les données du service de santé au travail.
	 *
	 * @todo: Sécurité.
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

		ob_start();
		Legal_Display_Class::g()->display( $parent_id, array( '\digi\Legal_Display_A3_Class', '\digi\Legal_Display_A4_Class' ), false );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'legalDisplay',
			'callback_success' => 'generatedSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_generate_legal_display() {
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

//		$legal_display = Legal_Display_Class::g()->get_legal_display( array(
//			'ID'    => $parent_id,
//			'posts_per_page' => 1,
//		), true );

		$legal_display = Legal_Display_Class::g()->get_legal_display( $parent_id );

		$society = Society_Class::g()->show_by_type( $parent_id );

		$response = Legal_Display_A3_Class::g()->prepare_document( $society, array(
			'legal_display' => $legal_display,
		) );

		Legal_Display_A3_Class::g()->create_document( $response['document']->data['id'] );

		$response = Legal_Display_A4_Class::g()->prepare_document( $society, array(
			'legal_display' => $legal_display,
		) );

		Legal_Display_A4_Class::g()->create_document( $response['document']->data['id'] );

		ob_start();
		Legal_Display_Class::g()->display( $parent_id, array( '\digi\Legal_Display_A3_Class', '\digi\Legal_Display_A4_Class' ), false );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'legalDisplay',
			'callback_success' => 'generatedSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_save_society_information() {
		check_ajax_referer( 'save_society_information' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display      = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		$society->data['title'] = ! empty( $_POST['society']['title'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['title'] ) ) : $society->data['title']; // WPCS: input var ok.
		$society->data['siret_id'] = ! empty( $_POST['society']['siret_id'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['siret_id'] ) ) : ''; // WPCS: input var ok.
		$society->data['number_of_employees'] = ! empty( $_POST['society']['number_of_employees'] ) ? (int) $_POST['society']['number_of_employees'] : 0; // WPCS: input var ok.
		$society->data['owner_id'] = ! empty( $_POST['society']['owner_id'] ) ? (int) $_POST['society']['owner_id'] : 0; // WPCS: input var ok.
		$society->data['date'] = ! empty( $_POST['society']['date'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['date'] ) ) : ''; // WPCS: input var ok.
		$society->data['contact']['phone'] = end( $society->data['contact']['phone'] );

		$address_data                       = array();
		$address_data['post_id']            = $society->data['id'];
		$address_data['address']            = ! empty( $_POST['address']['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['address'] ) ) : ''; // WPCS: input var ok.
		$address_data['additional_address'] = ! empty( $_POST['address']['additional_address'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['additional_address'] ) ) : ''; // WPCS: input var ok.
		$address_data['postcode']           = ! empty( $_POST['address']['postcode'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['postcode'] ) ) : ''; // WPCS: input var ok.
		$address_data['town']               = ! empty( $_POST['address']['town'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['town'] ) ) : ''; // WPCS: input var ok.

		$address                               = Address_Class::g()->save( $address_data );
		$society->data['contact']['address_id'] = $address->data['id'];
		$society = Society_Configuration_Class::g()->save( $society->data );
		$id = $society->data[ 'id' ];
		// $society = Society_Class::g()->show_by_type( $id );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_society_information_more() {
		check_ajax_referer( 'save_society_information_more' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		$society->data['contact']['phone']    = ! empty( $_POST['society']['contact']['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['contact']['phone'] ) ) : ''; // WPCS: input var ok.
		$society->data['contact']['email']    = ! empty( $_POST['society']['contact']['email'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['contact']['email'] ) ) : ''; // WPCS: input var ok.
		$society->data['content']             = ! empty( $_POST['society']['content'] ) ? wp_unslash( $_POST['society']['content'] ) : ''; // WPCS: input var ok.
		$society->data['moyen_generaux']      = ! empty( $_POST['society']['moyen'] ) ? wp_unslash( $_POST['society']['moyen'] ) : ''; // WPCS: input var ok.
		$society->data['consigne_generale']   = ! empty( $_POST['society']['consigne'] ) ? wp_unslash( $_POST['society']['consigne'] ) : ''; // WPCS: input var ok.

		$society->data['date'] = $society->data['date'][ 'raw' ]; // WPCS: input var ok.
		$society->data[ 'contact' ][ 'address_id'] = end( $society->data[ 'contact' ][ 'address_id'] );

		$society = Society_Configuration_Class::g()->save( $society->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_health_service() {
		check_ajax_referer( 'save_health_service' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		$occupational_health_service = ! empty( $_POST['occupational_health_service'] ) ? (array) $_POST['occupational_health_service'] : array();

		$occupational_health_service_address = Address_Class::g()->save( $occupational_health_service['address'] );
		$occupational_health_service['contact']['address_id'] = $occupational_health_service_address->data['id'];
		$occupational_health_service_third = Third_Class::g()->save_data( $occupational_health_service );

		$legal_display->data[ 'occupational_health_service_id' ] = $occupational_health_service_third->data['id'];
		$legal_display = Legal_Display_Class::g()->save_data( $legal_display->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_detective_work() {
		check_ajax_referer( 'save_detective_work' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display      = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		$detective_work = ! empty( $_POST['detective_work'] ) ? (array) $_POST['detective_work'] : array();

		$detective_work_address = Address_Class::g()->save( $detective_work['address'] );
		$detective_work['contact']['address_id'] = $detective_work_address->data['id'];
		$detective_work_third = Third_Class::g()->save_data( $detective_work );

		$legal_display->data[ 'detective_work_id' ] = $detective_work_third->data['id'];

		$legal_display = Legal_Display_Class::g()->save_data( $legal_display->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_emergency_work(){
		check_ajax_referer( 'save_emergency_work' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display      = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		// Récupère les tableaux.
		$emergency_service       = ! empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
		$safety_rule             = ! empty( $_POST['safety_rule'] ) ? (array) $_POST['safety_rule'] : array();

		$legal_display->data[ 'emergency_service' ] = $emergency_service;
		$legal_display->data[ 'safety_rule' ] = $safety_rule;
		$legal_display = Legal_Display_Class::g()->save_data( $legal_display->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_working_hours(){
		check_ajax_referer( 'save_working_hours' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		// Récupère les tableaux.
		$working_hour            = ! empty( $_POST['working_hour'] ) ? (array) $_POST['working_hour'] : array();
		$derogation_schedule     = ! empty( $_POST['derogation_schedule'] ) ? (array) $_POST['derogation_schedule'] : array();

		$legal_display->data[ 'working_hour' ] = $working_hour;
		$legal_display->data[ 'derogation_schedule' ] = $derogation_schedule;
		$legal_display = Legal_Display_Class::g()->save_data( $legal_display->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_others_informations(){
		check_ajax_referer( 'save_others_informations' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display      = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];

		// Récupère les tableaux.
		$collective_agreement    = ! empty( $_POST['collective_agreement'] ) ? (array) $_POST['collective_agreement'] : array();
		$rules                   = ! empty( $_POST['rules'] ) ? (array) $_POST['rules'] : array();
		$duer                    = ! empty( $_POST['DUER'] ) ? (array) $_POST['DUER'] : array();
		$participation_agreement = ! empty( $_POST['participation_agreement'] ) ? (array) $_POST['participation_agreement'] : array();

		$legal_display->data[ 'collective_agreement' ] = $collective_agreement;
		$legal_display->data[ 'participation_agreement' ] = $participation_agreement;
		$legal_display->data[ 'DUER' ] = $duer;
		$legal_display->data[ 'rules' ] = $rules;
		$legal_display = Legal_Display_Class::g()->save_data( $legal_display->data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}

	public function callback_save_staff_representatives(){
		check_ajax_referer( 'save_staff_representatives' );

		$return = Legal_Display_Class::g()->get_default_data_save();
		$society            = $return[ 'society' ];
		$legal_display      = $return[ 'legal_display' ];
		$diffusion_information = $return[ 'diffusion_information' ];


		$data = array(
			'parent_id'                               => $society->data[ 'id' ],
			'status'                                  => 'inherit',
			'delegues_du_personnels_date'             => ! empty( $_POST['delegues_du_personnels_date'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_date'] ) : '',
			'delegues_du_personnels_titulaires'       => ! empty( $_POST['delegues_du_personnels_titulaires'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_titulaires'] ) : '',
			'delegues_du_personnels_suppleants'       => ! empty( $_POST['delegues_du_personnels_suppleants'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_suppleants'] ) : '',
			'membres_du_comite_entreprise_date'       => ! empty( $_POST['membres_du_comite_entreprise_date'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_date'] ) : '',
			'membres_du_comite_entreprise_titulaires' => ! empty( $_POST['membres_du_comite_entreprise_titulaires'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_titulaires'] ) : '',
			'membres_du_comite_entreprise_suppleants' => ! empty( $_POST['membres_du_comite_entreprise_suppleants'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_suppleants'] ) : '',
		);
		$diffusion_information = Diffusion_Informations_Class::g()->update( $data );

		Legal_Display_Class::g()->display_configuration_view( $society ); // WP SEND JSON SUCCESS
	}
}

new Legal_Display_Action();
