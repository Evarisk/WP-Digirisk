<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * CRUD Functions pour les comments
 * @author Jimmy Latour
 * @version 0.1
 */
class comment_class extends singleton_util {
	protected $model_name = '\digi\comment_model';
	protected $meta_key = '_comment';
	protected $comment_type	= '';
	protected $base = 'comment';
	protected $version = '0.1';
	protected $identifier_helper = 'comment';
	protected $after_model_get_function = array( '\digi\construct_current_date' );
	protected $before_post_function = array( '\digi\convert_date' );
	protected $before_put_function = array( '\digi\convert_date' );

	protected function construct() {}

	public function get_schema() {
		$model = new $this->model_name( array(), array() );
		return $model->get_model();
	}

	public function get( $args = array( 'post_id' => 0, 'parent' => 0 ), $field_wanted = array() ) {
		$array_model = array();
		$array_comment = array();

		if ( !empty( $this->comment_type ) ) {
			$args['type'] = $this->comment_type;
			$args['status'] = '-34070';
		}


		if ( !empty( $args['id'] ) ) {
			$array_comment[] = get_comment( $args['id'], ARRAY_A );
		}
		else if( isset( $args['schema'] ) ) {
			$array_comment[] = array();
		}
		else {
			$array_comment = get_comments( $args );
		}

		$list_comment = array();

		if( !empty( $array_comment ) ) {
			foreach( $array_comment as $key => $comment ) {
				$comment = (array) $comment;

				if ( !empty( $comment['comment_ID'] ) ) {
					$list_meta = get_comment_meta( $comment['comment_ID'] );
					foreach ( $list_meta as &$meta ) {
						$meta = array_shift( $meta );
					}

					$comment = array_merge( $comment, $list_meta );

					if ( !empty( $comment[$this->meta_key] ) ) {
						$comment = array_merge( $comment, json_decode( $comment[$this->meta_key], true ) );
						unset( $comment[$this->meta_key] );
					}
				}

				$list_comment[$key] = new $this->model_name( $comment, $field_wanted );

				if ( !empty( $this->after_model_get_function ) ) {
					foreach( $this->after_model_get_function as $model_function ) {
						$list_comment[$key] = call_user_func( $model_function, $list_comment[$key] );
					}
				}
			}
		}
		else {
			$list_comment[0] = new $this->model_name( array(), $field_wanted );

			if ( !empty( $this->after_model_get_function ) ) {
				foreach( $this->after_model_get_function as $model_function ) {
					$list_comment[0] = call_user_func( $model_function, $list_comment[0] );
				}
			}
		}

		return $list_comment;
	}

	public function create( $data ) {
		return $this->update( $data );
	}

	public function update( $data ) {
		$data = (array) $data;

		if ( empty( $data['id'] ) ) {
			if ( !empty( $this->before_model_post_function ) ) {
				foreach( $this->before_model_post_function as $model_function ) {
					$data = call_user_func( $model_function, $data );
				}
			}

			$data = new $this->model_name( $data, array( false ) );


			// Ajout du post type si il est vide
			if ( empty( $data->type ) ) {
				$data->type = $this->comment_type;
				$data->status = '-34070';
			}

			if ( !empty( $this->before_post_function ) ) {
				foreach ( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			if ( !empty( $data->error ) && $data->error ) {
				return false;
			}

			$data->id = wp_insert_comment( $data->do_wp_object() );
		}
		else {
			if ( !empty( $this->before_model_put_function ) ) {
				foreach( $this->before_model_put_function as $model_function ) {
					$data = call_user_func( $model_function, $data );
				}
			}

			$current_data = $this->get( array( 'id' => $data['id'] ), array( false ) );
			$current_data = $current_data[0];
			$obj_merged = (object) array_merge((array) $current_data, (array) $data);
			$data = new $this->model_name( (array) $obj_merged, array( false ) );

			if ( !empty( $this->before_put_function ) ) {
				foreach ( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
			}

			if ( !empty( $data->error ) && $data->error ) {
				return false;
			}

			wp_update_comment( $data->do_wp_object() );
		}

		save_meta_class::g()->save_meta_data( $data, 'update_comment_meta', $this->meta_key );

		return $data;
	}

	public function get_type() {
		return $this->comment_type;
	}

	public function get_post_type() {
		return $this->comment_type;
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
