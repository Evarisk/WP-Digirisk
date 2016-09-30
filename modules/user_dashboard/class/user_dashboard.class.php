<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_dashboard_class extends singleton_util {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {}

	public function display_list_user() {
		$list_user = \digi\user_digi_class::g()->get( array( 'exclude' => array( 1 ) ) );
		view_util::exec( 'user_dashboard', 'list', array( 'list_user' => $list_user ) );
	}
}

new user_dashboard_class();
