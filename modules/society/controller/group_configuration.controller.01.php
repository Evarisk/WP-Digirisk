<?php if ( !defined( 'ABSPATH' ) ) exit;

class wpdigi_group_configuration_ctr {
  public function display( $element ) {
    global $wpdigi_address_ctr;

    // Récupère la dernière adresse lié à ce groupement
    $address_id = $element->option['contact']['address'][count( $element->option['contact']['address'] ) - 1];
    $address = $wpdigi_address_ctr->show( $address_id );

    // Récupère le dernier numéro de téléphone
    $phone = $element->option['contact']['phone'][count( $element->option['contact']['phone'] ) - 1];

    require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/configuration', 'form' ) );
  }
}

global $wpdigi_group_configuration_ctr;
$wpdigi_group_configuration_ctr = new wpdigi_group_configuration_ctr();
