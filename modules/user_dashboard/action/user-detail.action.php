<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_detail_action extends singleton_util {
	/**
	* Le constructeur appelle les actions suivantes:
	*/
	protected function construct() {
		add_action( 'wp_ajax_load_user_detail', array( $this, 'load_user_detail' ) );
		add_action( 'wp_ajax_load_data', array( $this, 'load_data' ) );
	}

	public function load_user_detail() {
		$user_id = !empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		if ( $user_id === 0) {
			wp_send_json_error();
		}

		check_ajax_referer( 'ajax_view_user_detail_' . $user_id );

		ob_start();
		do_shortcode( '[digi-user-detail id=' . $user_id . ']' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function load_data() {
		$user_id = !empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		if ( $user_id === 0) {
			wp_send_json_error();
		}

		$data_name = !empty( $_POST['data_name'] ) ? sanitize_text_field( $_POST['data_name'] ) : '';

		if ( empty( $data_name ) ) {
			wp_send_json_error();
		}

		check_ajax_referer( 'load_data_' . $user_id );

		$user = \digi\user_class::g()->get( array( 'include' => array( $user_id ) ) );

		if ( !empty( $user[0] ) ) {
			$user = $user[0];

			$method_name = "get_list_" . $data_name;

			$compiled_data_id = $user->dashboard_compiled_data['list_' . $data_name . '_id'];
			$list_element = user_detail_class::g()->$method_name($user->id, $compiled_data_id);
		}



		ob_start();
		require( USER_DASHBOARD_VIEW . 'user-detail/' . $data_name . '/list.view.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

user_detail_action::g();
