<?php
/**
 * Gestion des posts de WordPress par WPEO_Model
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des posts de WordPress par WPEO_Model
 */
class Post_Class extends singleton_util {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\post_model';

	/**
	 * Le type du post
	 *
	 * @var string
	 */
	protected $post_type = 'post';

	/**
	 * La clé principale pour post_meta
	 *
	 * @var string
	 */
	protected $meta_key = '_wpeo_post';

	/**
	 * La version du modèle
	 *
	 * @var string
	 */
	protected $version = '0.1.0.0';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'posts';

	/**
	 * Utiles pour récupérer la clé unique
	 *
	 * @todo Rien à faire ici
	 * @var string
	 */
	protected $identifier_helper = 'post';

	/**
	 * Appelle l'action "init" de WordPress
	 *
	 * @return void
	 */
	protected function construct() {
		add_action( 'init', array( $this, 'init_post_type' ) );
	}

	/**
	 * Initialise le post type selon $name et $name_singular.
	 *
	 * @see register_post_type
	 * @return void
	 */
	public function init_post_type() {
		$args = array(
			'public' => config_util::$init['digirisk']->debug ? true : false,
			'label'  => $this->post_type_name,
		);

		register_post_type( $this->post_type, $args );
	}

	public function get_schema() {
		$model = new $this->model_name( array(), array() );
		return $model->get_model();
	}

	public function get( $args = array( 'posts_per_page' => -1 ), $children_wanted = array() ) {
		$array_posts = array();
		$args['post_type'] = $this->post_type;

		// @todo: Temporaire
		if ( ! empty( $args['include'] ) ) {
			$args['post__in'] = $args['include'];
			if ( !is_array( $args['post__in'] ) ) {
				$args['post__in'] = (array) $args['post__in'];
			}
			unset( $args['include'] );
		}

		if ( !isset( $args['posts_per_page'] ) ) {
			$args['posts_per_page'] = -1;
		}

		if ( isset( $args['id'] ) ) {
			$array_posts[] = get_post( $args['id'], ARRAY_A );
			unset( $args['id'] );
		}
		else if( isset( $args['schema'] ) ) {
			$array_posts[] = array();
		}
		else {
			$query_posts = new \WP_Query( $args );
			$array_posts = $query_posts->posts;
			unset( $query_posts->posts );

			if ( ! empty( $args['post__in'] ) ) {
				unset( $args['post__in'] );
			}
		}

		foreach ( $array_posts as $key => $post ) {
			$post = (array) $post;

			// Si post['ID'] existe, on récupère les meta.
			if ( ! empty( $post['ID'] ) ) {
				$list_meta = get_post_meta( $post['ID'] );
				foreach ( $list_meta as &$meta ) {
					$meta = array_shift( $meta );
					$meta = json_util::g()->decode( $meta );
				}

				$post = array_merge( $post, $list_meta );

				if ( ! empty( $post[$this->meta_key] ) ) {
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

			$array_posts[$key] = new $this->model_name( $post, $children_wanted, $args );
			$array_posts[$key] = $this->get_taxonomies_id( $array_posts[$key] );

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

			// Ajout du post type si il est vide !
			if ( empty( $data->type ) ) {
				$data->type = $this->post_type;
			}

			if ( ! empty( $this->before_post_function ) ) {
				foreach ( $this->before_post_function as $post_function ) {
					$data = call_user_func( $post_function, $data );
				}
			}

			if ( ! empty( $data->error ) && $data->error ) {
				return false;
			}

			$post_save = wp_insert_post( $data->do_wp_object(), true );
			if ( ! is_wp_error( $post_save ) ) {
				$data->id = $post_save;
			} else {
				$data = $post_save;
			}
		} else {
			$current_data = $this->get( array( 'id' => $data['id'] ), array( false ) );
			$current_data = $current_data[0];
			$obj_merged = (object) array_merge( (array) $current_data, (array) $data );
			$data = new $this->model_name( (array) $obj_merged, array( false ) );
			$data->type = $this->post_type;

			if ( ! empty( $this->before_put_function ) ) {
				foreach ( $this->before_put_function as $put_function ) {
					$data = call_user_func( $put_function, $data );
				}
			}

			if ( ! empty( $data->error ) && $data->error ) {
				return false;
			}

			$post_save = wp_update_post( $data->do_wp_object(), true );
			if ( is_wp_error( $post_save ) ) {
				$data = $post_save;
			}
		}

		if ( ! is_wp_error( $data ) ) {
			save_meta_class::g()->save_meta_data( $data, 'update_post_meta', $this->meta_key );
			// Save taxonomy!
			$this->save_taxonomies( $data );
		}

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

	public function get_identifier_helper() {
		return $this->identifier_helper;
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

	public function set_model( $model_name ) {
		$this->model_name = $model_name;
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
