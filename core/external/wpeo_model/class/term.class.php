<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class term_class extends singleton_util {
	protected $model_name = '\digi\term_model';
	protected $meta_key = '_wpeo_term';
	protected $taxonomy = 'category';
	protected $base = 'term';
	protected $version = '0.1';
	protected $identifier_helper = 'term';

	protected function construct() {}

	public function get_schema() {
		$model = new $this->model_name( array(), array() );
		return $model->get_model();
	}

	public function update( $data ) {
		$object = new $this->model_name( (array)$data, array( false ) );

		/**	Sauvegarde des données dans la base de données / Save data into database	*/
		if ( empty( $object->id ) ) {
			$wp_category_danger = wp_insert_term( $object->name, $this->get_taxonomy(), array(
				'description'	=> !empty( $object->description ) ? $object->description : '',
				'slug'	=> !empty( $object->slug ) ? $object->slug : sanitize_title( $object->name ),
				'parent'	=> !empty( $object->parent_id ) ? (int) $object->parent_id : 0,
			) );
		}
		else {
			$wp_category_danger = wp_update_term( $object->id, $this->get_taxonomy(), $object->do_wp_object() );
		}

		if ( !is_wp_error( $wp_category_danger ) ) {
			$object->id = $wp_category_danger['term_id'];
			$object->term_taxonomy_id = $wp_category_danger['term_taxonomy_id'];

			save_meta_class::g()->save_meta_data( $object, 'update_term_meta', $this->meta_key );
		}
		else {
			$list_term_model = $this->get( array( 'id' => $wp_category_danger->error_data['term_exists'] ) );
			return $list_term_model[0];
		}

		return $object;
	}

	public function create( $data ) {
		return $this->update( $data );
	}

	public function delete( $id ) {
		wp_delete_term( $id );
	}

	public function get( $args = array(), $children_wanted = array() ) {
		$list_term = array();
		$array_term = array();

		$term_final_args = array_merge( $args, array( 'hide_empty' => false, ) );

		if ( !empty( $args['id'] ) ) {
			$array_term[] = get_term_by( 'id', $args['id'], $this->taxonomy, ARRAY_A );
		}
		else if ( !empty( $args['post_id'] ) ) {
			$array_term = wp_get_post_terms( $args['post_id'], $this->taxonomy, $term_final_args );

			if ( empty( $array_term ) ) $array_term[] = array();
		}
		else {
			$array_term = get_terms( $this->taxonomy, $term_final_args );
		}

		if( !empty( $array_term ) ) {
			foreach( $array_term as $key => $term ) {
				$term = (array) $term;

				if ( !empty( $args['post_id'] ) ) {
					$term['post_id'] = $args['post_id'];
				}

				if ( !empty( $term['term_id'] ) ) {
					$list_meta = get_term_meta( $term['term_id'] );
					foreach ( $list_meta as &$meta ) {
						$meta = array_shift( $meta );
					}

					$term = array_merge( $term, $list_meta );

					if ( !empty( $term[$this->meta_key] ) ) {
						$term = array_merge( $term, json_decode( $term[$this->meta_key], true ) );
						unset( $term[$this->meta_key] );
					}
				}

				$list_term[$key] = new $this->model_name( $term, $children_wanted );

				if ( !empty( $this->after_get_function ) ) {
				  foreach ( $this->after_get_function as $get_function ) {
						$list_term[$key] = call_user_func( $get_function, $list_term[$key] );
				  }
				}
			}
		}

		return $list_term;
	}

	/**
	 * GETTER - Récupération du type de l'élément courant / Get the current element type
	 *
	 * @return string Le type d'élément courant / The current element type
	 */
	public function get_taxonomy() {
		return $this->taxonomy;
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
