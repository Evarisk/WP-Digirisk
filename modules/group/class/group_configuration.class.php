<?php if ( !defined( 'ABSPATH' ) ) exit;

class group_configuration_class extends singleton_util {
	/**
	* Le constructeur
	*/
	protected function construct() {}

	/**
	* Affiche le formulaire pour configurer un groupement
	*
	* @param object $element L'élement du groupement
	*/
  public function display( $element ) {
    require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/configuration', 'form' ) );
  }

	public function save( $data ) {
		group_class::g()->update( $data );
	}
}

group_configuration_class::g();
