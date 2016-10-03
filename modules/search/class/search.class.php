<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class search_class extends singleton_util {
	/**
	* Le constructeur
	*/
  protected function construct() {}

	public function search( $data ) {
		$list = array();

		if ( $data['type'] === 'user' ) {
			if ( !empty( $data['term'] ) ) {
				$list = get_users( array(
					'fields' => 'ID',
					'search' => '*' . $data['term'] . '*',
				) );

				$list = wp_parse_args( get_users( array(
					'fields' => 'ID',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'first_name',
							'value' => $data['term'],
							'compare' => 'LIKE'
						),
						array(
							'key' => 'last_name',
							'value' => $data['term'],
							'compare' => 'LIKE'
						),
					)
				) ) );
			}
			else {
				$list = get_users( array(
					'fields' => 'ID',
					'exclude' => array( 1 ),
				) );
			}
		}
		else if ( $data['type'] === 'post' ) {
			$model_name = '\digi\\' . $data['class'];
			$list = $model_name::g()->search( $data['term'], array(
				'option' => array( '_wpdigi_unique_identifier' ),
				'post_title'
			) );
		}

		return $list;
	}
}

search_class::g();
