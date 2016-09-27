<?php if ( !defined( 'ABSPATH' ) ) exit;

class user_dashboard_class extends singleton_util {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {}

	public function display_list_user() {
		$list_user = \digi\user_class::g()->get( array( 'exclude' => array( 1 ) ) );
		require( USER_DASHBOARD_VIEW . 'list.view.php' );
	}
}

new user_dashboard_class();
