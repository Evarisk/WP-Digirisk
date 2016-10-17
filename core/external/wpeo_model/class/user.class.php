<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_class extends singleton_util {
	protected $model_name = '\digi\user_model';
	protected $meta_key = '_wpeo_user';
	protected $base = 'user';
	protected $version = '0.1';
	protected $identifier_helper = 'user';
	public $element_prefix = 'U';

	protected function construct() {}

	public function get_schema() {
		$model = new $this->model_name( array(), array() );
		return $model->get_model();
	}

	public function update( $data ) {
		$data = (array) $data;
		if ( empty( $data['id'] ) ) {
			if ( !empty( $this->before_model_post_function ) ) {
				foreach( $this->before_model_post_function as $model_function ) {
					$data = call_user_func( $model_function, $data );
				}
			}

			$data = new $this->model_name( (array)$data );

			if ( !empty( $this->before_post_function ) ) {
				foreach( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			if ( !empty( $data->error ) && $data->error ) {
				return false;
			}

			$data->id = wp_insert_user( $data->do_wp_object() );
		}
		else {
			$current_data = $this->get( array( 'id' => $data['id'] ), array( false ) );
			$current_data = $current_data[0];
			$obj_merged = (object) array_merge((array) $current_data, (array) $data);
			$data = new $this->model_name( (array)$obj_merged );

			if ( !empty( $this->before_put_function ) ) {
				foreach( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
			}

			if ( !empty( $data->error ) && $data->error ) {
				return false;
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
		else if( isset( $args['schema'] ) ) {
			$list_user[] = array();
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

	public function get_identifier_helper() {
		return $this->identifier_helper;
	}

	public function callback_register_route( $array_route ) {
		/** Récupération de la liste complète des éléments / Get all existing elements */
		$array_route['/' . $this->version . '/get/' . $this->base ] = array(
				array( array( $this, 'get' ), \WP_JSON_Server::READABLE | \WP_JSON_Server::ACCEPT_JSON )
		);
		/** Récupération d'un élément donné / Get a given element */
		$array_route['/' . $this->version . '/get/' . $this->base . '/(?P<id>\d+)'] = array(
				array( array( $this, 'get' ), \WP_JSON_Server::READABLE |  \WP_JSON_Server::ACCEPT_JSON )
		);
		$array_route['/' . $this->version . '/get/' . $this->base . '/schema'] = array(
				array( array( $this, 'get_schema' ), \WP_JSON_Server::READABLE |  \WP_JSON_Server::ACCEPT_JSON )
		);
		/** Mise à jour d'un élément / Update an element */
		// $array_route['/' . $this->version . '/post/' . $this->base . ''] = array(
		// 		array( array( $this, 'update' ), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
		// );
		// /** Suppression d'un élément / Delete an element */
		// $array_route['/' . $this->version . '/delete/' . $this->base . '/(?P<id>\d+)'] = array(
		// 		array( array( $this, 'delete' ), WP_JSON_Server::DELETABLE | WP_JSON_Server::ACCEPT_JSON ),
		// );

		return $array_route;
	}
}
