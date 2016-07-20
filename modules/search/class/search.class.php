<?php if ( !defined( 'ABSPATH' ) ) exit;

class search_class extends singleton_util {
	/**
	* Le constructeur
	*/
  protected function construct() {}

	public function search( $data ) {
		$list_user = array();

		$data['type'] .= '_class';

		$list_user = get_users( array(
			'fields' => 'ID',
			'search' => '*' . $data['term'] . '*',
			'search_columns' => array( 'user_login', 'display_name', 'user_email' ),
		) );

		return $list_user;
	}
}

search_class::get();
