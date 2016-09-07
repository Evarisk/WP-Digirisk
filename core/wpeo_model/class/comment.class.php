<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * CRUD Functions pour les comments
 * @author Jimmy Latour
 * @version 0.1
 */
class comment_class extends singleton_util {
	protected $model_name = 'comment_model';
	protected $meta_key = '_comment';
	protected $comment_type	= 'comment';
	protected $base = 'comment';
	protected $version = '0.1';

	protected function construct() {}

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
		else {
			$array_comment = get_comments( $args );
		}

		$list_comment = array();

		if( !empty( $array_comment ) ) {
			foreach( $array_comment as $comment ) {
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

				$list_comment[] = new $this->model_name( $comment, $field_wanted );
			}
		}
		else {
			$list_comment[] = new $this->model_name( array(), $field_wanted );
		}

		return $list_comment;
	}

	public function create( $data ) {
		return $this->update( $data );
	}

	public function update( $data ) {
		$data = new $this->model_name( (array) $data );

		// Ajout du post type si il est vide
		if ( empty( $data->type ) ) {
			$data->type = $this->comment_type;
			$data->status = '-34070';
		}

		if ( empty( $data->id ) ) {
			if ( !empty( $this->before_post_function ) ) {
				foreach ( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			$data->id = wp_insert_comment( $data->do_wp_object() );
		}
		else {
			if ( !empty( $this->before_put_function ) ) {
				foreach ( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
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
}
