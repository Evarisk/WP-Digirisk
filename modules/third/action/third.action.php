<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class third_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_legal_display
	*/
  public function __construct() {
    add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ), 1 );
  }

	/**
  * Sauvegardes les données de tier pour l'affichage légal
  *
	* array $_POST['detective_work'] Les données envoyées par le formulaire pour l'inspecteur du travail
	* array $_POST['occupational_health_service'] Les données envoyées par le formulaire pour le service de santé au travail
	*
  * @param array $_POST Les données envoyées par le formulaire
  */
  public function callback_save_legal_display() {
    check_ajax_referer( 'save_legal_display' );

    // Récupère les tableaux
    $detective_work = !empty( $_POST['detective_work'] ) ? (array) $_POST['detective_work'] : array();
    $occupational_health_service = !empty( $_POST['occupational_health_service'] ) ? (array) $_POST['occupational_health_service'] : array();

    // On enregistre les addresses
    $detective_work_address = address_class::g()->save( $detective_work['address'] );
    $occupational_health_service_address = address_class::g()->save( $occupational_health_service['address'] );

    $detective_work['contact']['address_id'] = $detective_work_address->id;
    $occupational_health_service['contact']['address_id'] = $occupational_health_service_address->id;

    $detective_work['opening_time'] = $detective_work['opening_time'];
    $occupational_health_service['opening_time'] = $occupational_health_service['opening_time'];

    $detective_work_third = third_class::g()->save_data( $detective_work );
    $occupational_health_service_third = third_class::g()->save_data( $occupational_health_service );

    do_action( 'save_legal_display', $detective_work_third, $occupational_health_service_third );
  }


}

new third_action();
