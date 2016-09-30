<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_import_action extends singleton_util {
	public static $response;
	/**
	* Le constructeur appelle les actions suivantes:
	*/
	protected function construct() {
		add_action( 'wp_ajax_digi_import_user', array( $this, 'callback_digi_import_user' ) );
	}

	public function callback_digi_import_user() {
		check_ajax_referer( 'digi_import_user' );
		ini_set( 'memory_limit', '-1' );

		user_import_action::$response = array(
			'message' => __( 'Digirisk datas imported successfully', 'digirisk' ),
		);

		if ( empty( $_FILES ) || empty( $_FILES['file'] ) ) {
			$path_to_csv = $_POST['path_to_csv'];
		}
		else {
			copy( $_FILES['file']['tmp_name'], USERS_PATH . '/asset/tmp/' . $_FILES['file']['name'] );
			$path_to_csv = USERS_PATH . '/asset/tmp/' . $_FILES['file']['name'];
		}

		$data_csv = \csv_util::g()->read_and_set_index( $path_to_csv, array( 'lastname', 'firstname', 'lastname_lower', 'firstname_lower', 'login', 'password', 'email' ) );

		user_import_action::$response['count_element'] = empty( $_POST['count_element'] ) ? count( $data_csv ) : $_POST['count_element'];
		user_import_action::$response['index_element'] = (int) $_POST['index_element'];
		user_import_action::$response['path_to_csv'] = empty( user_import_action::$response['path_to_csv'] ) ? $path_to_csv : user_import_action::$response['path_to_csv'];

		user_import_class::g()->create($data_csv);

		wp_send_json_success();
	}

	public function fast_response( $end = false ) {
		user_import_action::$response['end'] = $end;

		if ($end) {
			unlink(user_import_action::$response['path_to_csv']);
		}

		wp_send_json_success( user_import_action::$response );
	}
}

user_import_action::g();
