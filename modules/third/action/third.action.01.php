<?php if ( !defined( 'ABSPATH' ) ) exit;

class third_action_01 {
  public function __construct() {
    // add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ), 2 );
  }

  public function callback_save_legal_display() {
    check_ajax_referer( 'save_legal_display' );

    // // Récupère les tableaux
    // $detective_work = !empty( $_POST['detective_work'] ) ? (array) $_POST['detective_work'] : array();
    // $occupational_health_service = !empty( $_POST['occupational_health_service'] ) ? (array) $_POST['occupational_health_service'] : array();
    //
    // // Sécurises les données



    wp_send_json_success();
  }


}

new third_action_01();
