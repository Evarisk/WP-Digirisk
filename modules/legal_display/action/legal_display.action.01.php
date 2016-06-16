<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_action_01 {
  public function __construct() {
    // add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ) );
  }

  public function callback_save_legal_display() {
    check_ajax_referer( 'save_legal_display' );

    // Récupère les tableaux
    $emergency_service = !empty( $_POST['emergency_service'] ) ? (array) $_POST['emergency_service'] : array();
    $safety_rule = !empty( $_POST['safety_rule'] ) ? (array) $_POST['safety_rule'] : array();
    $derogation_schedule = !empty( $_POST['derogation_schedule'] ) ? (array) $_POST['derogation_schedule'] : array();
    $document = !empty( $_POST['document'] ) ? (array) $_POST['document'] : array();

    // Sécurises les données


    wp_send_json_success();
  }


}

new legal_display_action_01();
