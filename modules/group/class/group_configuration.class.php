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
		require( WPDIGI_STES_TEMPLATES_MAIN_DIR . 'group/configuration/form.php' );
  }

	public function save( $data ) {
		group_class::g()->update( $data );
	}
}

group_configuration_class::g();
