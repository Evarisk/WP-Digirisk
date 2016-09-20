<?php if ( !defined( 'ABSPATH' ) ) exit;

class post_class extends singleton_util {
	protected $model_name = 'post_model';
	protected $post_type = 'post';
	protected $meta_key = '_wpeo_post';
	protected $version = '0.1.0.0';

	protected function construct() {}

	public function get( $args = array( 'posts_per_page' => -1 ), $children_wanted = array()) {
		$array_posts = array();
		$args['post_type'] = $this->post_type;

		if ( !isset( $args['posts_per_page'] ) ) {
			$args['posts_per_page'] = -1;
		}

		if ( isset( $args['id'] ) ) {
			$array_posts[] = get_post( $args['id'], ARRAY_A );
		}
		else {
			$array_posts = get_posts( $args );
		}

		foreach ( $array_posts as $key => $post ) {
			$post = (array) $post;

			// Si post['ID'] existe, on récupère les meta
			if ( !empty( $post['ID'] ) ) {
				$list_meta = get_post_meta( $post['ID'] );
				foreach ( $list_meta as &$meta ) {
					$meta = array_shift( $meta );
					$meta = json_util::g()->decode( $meta );
				}

				$post = array_merge( $post, $list_meta );

				if ( !empty( $post[$this->meta_key] ) ) {
					$data_json = json_util::g()->decode( $post[$this->meta_key] );
					if ( is_array( $data_json ) ) {
						$post = array_merge( $post, $data_json );
					}
					else {
						$post[$this->meta_key] = $data_json;
					}
					unset( $post[$this->meta_key] );
				}

			}

			$array_posts[$key] = new $this->model_name( $post, $children_wanted );

			if ( !empty( $this->after_get_function ) ) {
				foreach ( $this->after_get_function as $get_function ) {
					$array_posts[$key] = call_user_func( $get_function, $array_posts[$key] );
				}
			}
		}

		return $array_posts;
	}

	public function create( $data ) {
		return $this->update( $data );
	}

	public function update( $data ) {
		$data = (array) $data;
		if ( empty( $data['id'] ) ) {
			$data = new $this->model_name( $data, array( false ) );

			// Ajout du post type si il est vide
			if ( empty( $data->type ) ) {
				$data->type = $this->post_type;
			}

			if ( !empty( $this->before_post_function ) ) {
				foreach ( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			$data->id = wp_insert_post( $data->do_wp_object() );
		}
		else {
			$current_data = $this->get( array( 'id' => $data['id'] ), array( false ) );
			$current_data = $current_data[0];
			$obj_merged = (object) array_merge((array) $current_data, (array) $data);
			$data = new $this->model_name( (array) $obj_merged, array( false ) );

			if ( !empty( $this->before_put_function ) ) {
				foreach ( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
			}

			wp_update_post( $data->do_wp_object() );
		}

		save_meta_class::g()->save_meta_data( $data, 'update_post_meta', $this->meta_key );
		// Save taxonomy
		$this->save_taxonomies( $data );

		return $data;
	}

	public function search( $search, $array ) {
		global $wpdb;
		if( empty( $array ) || !is_array( $array ) )
			return array();

		$where = ' AND ( ';
		if ( !empty( $array ) ) {
		  foreach ( $array as $key => $element ) {
				if( is_array( $element ) ) {
					foreach( $element as $sub_element ) {
						$where .= $where == ' AND ( ' ? '' : ' OR ';
						$where .= ' (PM.meta_key="' . $sub_element . '" AND PM.meta_value LIKE "%'. $search . '%") ';
					}
				}
				else {
					$where .= $where == ' AND ( ' ? '' : ' OR ';
					$where .= ' P.' . $element . ' LIKE "%' . $search . '%" ';
				}
		  }
		}
		$where .= ' ) ';
		$list_group = $wpdb->get_results( "SELECT DISTINCT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} AS PM ON PM.post_id=P.ID WHERE P.post_type='".$this->get_post_type()."'" . $where );
		$list_model = array();
		if ( !empty( $list_group ) ) {
		  foreach ( $list_group as $element ) {
				$list_model[] = $this->get( array( 'id' => $element->ID ) );
		  }
		}

		return $list_model;
	}

	public function get_post_type() {
		return $this->post_type;
	}

	private function get_taxonomies_id( $data ) {
		$model = $data->get_model();
		if ( !empty( $model['taxonomy']['child'] ) ) {
		  foreach ( $model['taxonomy']['child'] as $key => $value ) {
				$data->taxonomy[$key] = wp_get_object_terms( $data->id, $key, array( 'fields' => 'ids' ) );
			}
		}

		return $data;
	}

	private function save_taxonomies( $data ) {
		if ( !empty( $data->taxonomy ) ) {
		  foreach ( $data->taxonomy as $taxonomy_name => $taxonomy_data ) {
				if ( !empty( $taxonomy_name ) ) {
					wp_set_object_terms( $data->id, $taxonomy_data, $taxonomy_name, true );
				}
			}
		}
	}
}
