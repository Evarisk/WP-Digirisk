<?php if ( !defined( 'ABSPATH' ) ) exit;

class wpdigi_group_configuration_ctr {
  public function display( $element ) {
    global $wpdigi_address_ctr;
    global $wpdigi_user_ctr;

    $address = $wpdigi_address_ctr->show( max( $element->option['contact']['address'] ) );

    // Récupère le dernier numéro de téléphone
    $phone = max( $element->option['contact']['phone'] );

    // Récupère le nom de l'utilisateur
    $user = $wpdigi_user_ctr->show( $element->option['user_info']['owner_id'] );

    require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/configuration', 'form' ) );
  }
}

global $wpdigi_group_configuration_ctr;
$wpdigi_group_configuration_ctr = new wpdigi_group_configuration_ctr();
