<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_import_class extends singleton_util {
	private $index;
	private $data;

	protected function construct() {}

	public function render() {
		view_util::exec( 'user', 'import' );
	}

	public function create( $data ) {
		$this->index = 0;
		$this->data = $data;

		if ( !empty( $this->data ) ) {
			foreach( $this->data as $key => &$user_data ) {
				if( ($key - 1) >= user_import_action::$response['index_element'] ) {
					$user = \digi\user_class::g()->get( array( 'search' => $user_data['email'] ) );

					if ( !empty( $user ) && !empty( $user[0] ) && $user[0]->email === $user_data['email'] ) {
					}
					else {
						$user = \digi\user_class::g()->update( $user_data );
					}

					user_import_action::$response['index_element']++;
					$this->index++;

					$this->check_index();
				}
		}

		}
	}

	public function check_index() {
		if ( user_import_action::$response['index_element'] >= user_import_action::$response['count_element'] ) {
			user_import_action::g()->fast_response( true );
		}

		if ( $this->index >= 10 ) {
			user_import_action::g()->fast_response();
		}
	}
}
