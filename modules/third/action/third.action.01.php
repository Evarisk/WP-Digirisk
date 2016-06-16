<?php if ( !defined( 'ABSPATH' ) ) exit;

class third_action_01 {
  public function __construct() {
    add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ), 1 );
  }

  public function callback_save_legal_display() {
    check_ajax_referer( 'save_legal_display' );

    global $wpdigi_address_ctr;
    global $opening_time_class;
    global $third_class;

    // Récupère les tableaux
    $detective_work = !empty( $_POST['detective_work'] ) ? (array) $_POST['detective_work'] : array();
    $occupational_health_service = !empty( $_POST['occupational_health_service'] ) ? (array) $_POST['occupational_health_service'] : array();

    // On enregistre les addresses
    $detective_work_address = $wpdigi_address_ctr->save_data( $detective_work['address'] );
    $occupational_health_service_address = $wpdigi_address_ctr->save_data( $occupational_health_service['address'] );

    // On enregistre les horaires d'ouvertures
    $detective_work_opening_time = $opening_time_class->save_data( $detective_work['opening_time'] );
    $occupational_health_service_time = $opening_time_class->save_data( $occupational_health_service['opening_time'] );

    $detective_work['contact']['address_id'] = $detective_work_address->id;
    $occupational_health_service['contact']['address_id'] = $occupational_health_service_address->id;

    $detective_work['opening_time_id'] = $detective_work_opening_time->id;
    $occupational_health_service['opening_time_id'] = $occupational_health_service_time->id;

    $detective_work_third = $third_class->save_data( $detective_work );
    $occupational_health_service_third = $third_class->save_data( $occupational_health_service );

    do_action( 'save_legal_display', $detective_work_third, $occupational_health_service_third );
  }


}

new third_action_01();
