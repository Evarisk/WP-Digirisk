<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_detail_action extends \eoxia001\Singleton_Util {
	/**
	* Le constructeur appelle les actions suivantes:
	*/
	protected function construct() {
		add_action( 'wp_ajax_load_user_details', array( $this, 'load_user_detail' ) );
		add_action( 'wp_ajax_load_data', array( $this, 'load_data' ) );
	}

	public function load_user_detail() {
		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		
		if ( empty( $id ) ) {
			wp_send_json_error();
		}
		
		$societies = Group_Class::g()->get( array(
			'posts_per_page' => -1,
		) );
		
		$affected_to = array();
		
		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
					foreach ( $society->user_info['affected_id']['evaluator'] as $user_id => $data ) {
						if ( $id === $user_id && ! array_key_exists( $society->id, $affected_to ) ) {
							$affected_to[ $society->id ] = $society;
						}
					}
				}
			}
		}
		
		$societies = Workunit_Class::g()->get( array(
			'posts_per_page' => -1,
		) );
		
		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
					foreach ( $society->user_info['affected_id']['evaluator'] as $user_id => $data ) {
						if ( $id === $user_id && ! array_key_exists( $society->id, $affected_to ) ) {
							$affected_to[ $society->id ] = $society;
						}
					}
				}
			}
		}
		
		ob_start();
		\eoxia001\View_Util::exec( 'digirisk', 'user_dashboard', 'society/main', array(
			'affected_to' => $affected_to,
		) );		
		$view = ob_get_clean();
		wp_send_json_success( array(
			'view' => $view,
		) );
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
