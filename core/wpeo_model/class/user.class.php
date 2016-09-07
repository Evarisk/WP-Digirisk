<?php if ( !defined( 'ABSPATH' ) ) exit;

class user_class extends singleton_util {
	protected $model_name = 'user_model';
	protected $meta_key = '_wpeo_user';
	protected $base = 'user';
	protected $version = '0.1';

	public $element_prefix = 'U';

	protected function construct() {}

	public function update( $data ) {
		$data = new $this->model_name( (array)$data );

		if ( empty( $data->password ) ) {
			$data->password = wp_generate_password();
		}

		if ( empty( $data->id ) ) {
			if ( !empty( $this->before_post_function ) ) {
				foreach( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			$data->id = wp_insert_user( $data->do_wp_object() );
		}
		else {

			if ( !empty( $this->before_put_function ) ) {
				foreach( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
			}

			wp_update_user( $data->do_wp_object() );
		}

		save_meta_class::g()->save_meta_data( $data, 'update_user_meta', $this->meta_key );

		return $data;
	}

	public function create( $data ) {
		return $this->update( $data );
	}

	public function delete( $id ) {
		wp_delete_user( $id );
	}

	public function get( $args = array(), $field_wanted = array() ) {
		$list_user = array();
		$list_model_user = array();

		if ( !empty( $args['id'] ) ) {
	 		$list_user[] = get_user_by( 'id', $args['id'] );
		}
		else {
			$list_user = get_users( $args );
		}

		if ( !empty( $list_user ) ) {
		  foreach ( $list_user as $element ) {
				$element = (array) $element;

				if ( !empty( $element['ID'] ) ) {
					$list_meta = get_user_meta( $element['ID'] );
					foreach ( $list_meta as &$meta ) {
						$meta = array_shift( $meta );
					}

					$element = array_merge( $element, $list_meta );

					if ( !empty( $element['data'] ) ) {
						$element = array_merge( $element, (array) $element['data'] );
						unset( $element['data'] );
					}

					if ( !empty( $element[$this->meta_key] ) ) {
						$element = array_merge( $element, json_decode( $element[$this->meta_key], true ) );
						unset( $element[$this->meta_key] );
					}
				}

				$data = new $this->model_name( $element, $field_wanted );

				if ( !empty( $this->after_get_function ) ) {
				  foreach ( $this->after_get_function as $get_function ) {
						$data = call_user_func( $get_function, $data );
				  }
				}

				$list_model_user[] = $data;
		  }
		}

		return $list_model_user;
	}
}
