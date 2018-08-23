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
		add_action( 'save_legal_display', array( $this, 'callback_save_legal_display' ), 10, 2 );
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

		$response = Legal_Display_A3_Class::g()->prepare_document( $parent_id, array(
			'legal_display' => $legal_display,
		) );

		Legal_Display_A3_Class::g()->create_document( $response['document']->data['id'] );

		$response = Legal_Display_A4_Class::g()->prepare_document( $parent_id, array(
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
}

new Legal_Display_Action();
