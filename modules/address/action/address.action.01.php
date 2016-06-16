<?php if ( !defined( 'ABSPATH' ) ) exit;

class address_action_01 {
  public function __construct() {
    add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ), 1 );
  }

  public function callback_save_legal_display() {
    check_ajax_referer( 'save_legal_display' );

    // Récupère les tableaux
    $detective_work_address = !empty( $_POST['detective_work']['address'] ) ? (array) $_POST['detective_work']['address'] : array();
    $occupational_health_service_address = !empty( $_POST['occupational_health_service']['address'] ) ? (array) $_POST['occupational_health_service']['address'] : array();

    global $wpdigi_address_ctr;
    $wpdigi_address_ctr->save_address( $detective_work_address );
    $wpdigi_address_ctr->save_address( $occupational_health_service_address );

    wp_send_json_success();
  }


}

new address_action_01();
