<?php if ( !defined( 'ABSPATH' ) ) exit;

class search_class extends singleton_util {
	/**
	* Le constructeur
	*/
  protected function construct() {}

	public function search( $data ) {
		$list = array();

		if ( $data['type'] === 'user' ) {
			$list = get_users( array(
				'fields' => 'ID',
				'search' => '*' . $data['term'] . '*',
				'search_columns' => array( 'user_login', 'display_name', 'user_email' ),
			) );
		}
		else if ( $data['type'] === 'post' ) {
			$list = $data['class']::get()->search( $data['term'], array(
				'option' => array( '_wpdigi_unique_identifier' ),
				'post_title'
			) );
		}

		return $list;
	}
}

search_class::get();
