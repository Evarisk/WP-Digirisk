<?php if ( !defined( 'ABSPATH' ) ) exit;

class group_configuration_class extends singleton_util {
	protected function construct() {}

  public function display( $element ) {
    $address = address_class::get()->show( max( $element->option['contact']['address'] ) );

    // Récupère le dernier numéro de téléphone
    $phone = max( $element->option['contact']['phone'] );

    // Récupère le nom de l'utilisateur
    $user = \digi\user_class::get()->show( $element->option['user_info']['owner_id'] );

    require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/configuration', 'form' ) );
  }
}

group_configuration_class::get();
