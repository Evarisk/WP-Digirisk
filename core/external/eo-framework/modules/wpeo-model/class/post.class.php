<?php
/**
 * Gestion des posts (POST, PUT, GET, DELETE)
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Post_Class' ) ) {

	/**
	 * Gestion des posts (POST, PUT, GET, DELETE)
	 */
	class Post_Class extends Object_Class {

		/**
		 * Le nom du modèle
		 *
		 * @var string
		 */
		protected $model_name = '\eoxia\Post_Model';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $type = 'post';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $base = 'post';

		/**
		 * La clé principale pour post_meta
		 *
		 * @var string
		 */
		protected $meta_key = '_wpeo_post';

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
		 * La liste des droits a avoir pour accèder aux différentes méthodes
		 *
		 * @var array
		 */
		protected $capabilities = array(
			'get'    => 'read',
			'put'    => 'edit_posts',
			'post'   => 'edit_posts',
			'delete' => 'delete_posts',
		);

		/**
		 * Appelle l'action "init" de WordPress
		 *
		 * @return void
		 */
		protected function construct() {
			parent::construct();

			add_action( 'init', array( $this, 'init_post_type' ) );
		}

		/**
		 * Initialise le post type selon $name et $name_singular.
		 * Initialise la taxonomy si elle existe.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @see register_post_type
		 * @return boolean
		 */
		public function init_post_type() {
			$args = apply_filters( 'eo_model_' . $this->get_type() . '_register_post_type_args', array(
				'label' => $this->post_type_name,
			) );

			$return = register_post_type( $this->get_type(), $args );

			if ( ! empty( $this->attached_taxonomy_type ) ) {
				register_taxonomy( $this->attached_taxonomy_type, $this->get_type(), apply_filters( 'eo_model_' . $this->get_type() . '_' . $this->attached_taxonomy_type, array() ) );
			}

			return $return;
		}

		/**
		 * Récupères les données selon le modèle défini.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param array   $args   Les paramètres à appliquer pour la récupération @see https://codex.wordpress.org/Function_Reference/WP_Query.
		 * @param boolean $single Si on veut récupérer un tableau, ou qu'une seule entrée.
		 *
		 * @return Object
		 */
		public function get( $args = array(), $single = false ) {
			$array_posts = array();

			// Définition des arguments par défaut pour la récupération des "posts".
			$default_args = array(
				'post_status'    => 'any',
				'post_type'      => $this->get_type(),
				'posts_per_page' => -1,
			);

			// Si le paramètre "id" est passé on le transforme en "post__in" pour eviter les problèmes de statuts.
			// Dans un soucis d'homogénéité du code, le paramètre "id" remplace le paramètre "p" qui est de base dans WP_Query.
			$args['id'] = ! empty( $args['ID'] ) ? $args['ID'] : ( isset( $args['id'] ) ? $args['id'] : null );
			if ( ! empty( $args['id'] ) ) {
				if ( isset( $args['ID'] ) ) {
					unset( $args['ID'] );
				}
				if ( ! isset( $args['post__in'] ) ) {
					$args['post__in'] = array();
				}
				$args['post__in'] = array_merge( (array) $args['id'], $args['post__in'] );
			} elseif ( isset( $args['id'] ) ) {
				$args['schema'] = true;
			}
			unset( $args['id'] );

			$args_cb    = array(
				'args'         => $args,
				'default_args' => $default_args,
			);
			$final_args = apply_filters( 'eo_model_post_before_get', wp_parse_args( $args, $default_args ), $args_cb );
			// Il ne faut pas lancer plusieurs fois pour post.
			if ( 'post' !== $this->get_type() ) {
				$final_args = apply_filters( 'eo_model_' . $this->get_type() . '_before_get', $final_args, $args_cb );
			}

			// Si l'argument "schema" est présent c'est lui qui prend le dessus et ne va pas récupérer d'élément dans la base de données.
			if ( isset( $args['schema'] ) ) {
				$array_posts[] = $final_args;
			} else { // On lance la requête pour récupèrer les "posts" demandés.
				$query_posts = new \WP_Query( $final_args );
				$array_posts = $query_posts->posts;
				unset( $query_posts->posts );
			}

			// Traitement de la liste des résultats pour le retour.
			$array_posts = $this->prepare_items_for_response( $array_posts, 'post', $this->meta_key, 'ID' );

			// Si on a demandé qu'une seule entrée et qu'il n'y a bien qu'une seule entrée correspondant à la demande alors on ne retourne que cette entrée.
			if ( true === $single && 1 === count( $array_posts ) ) {
				$array_posts = $array_posts[0];
			}

			return $array_posts;
		}

		/**
		 * Insère ou met à jour les données dans la base de donnée.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param Array $data    Les données a insérer ou à mêttre à jour.
		 *
		 * @return Object      L'objet construit grâce au modèle.
		 */
		public function update( $data ) {
			$model_name = $this->model_name;
			$data       = (array) $data;
			$req_method = ( ! empty( $data['id'] ) ) ? 'put' : 'post';
			$args_cb    = array(
				'model_name' => $model_name,
				'req_method' => $req_method,
				'meta_key'   => $this->meta_key,
			);

			if ( empty( $data['type'] ) ) {
				$data['type'] = $this->get_type();
			}

			$append = false;
			if ( isset( $data['$push'] ) ) {
				if ( ! empty( $data['$push'] ) ) {
					foreach ( $data['$push'] as $field_name => $field_to_push ) {
						if ( ! empty( $field_to_push ) ) {
							foreach ( $field_to_push as $sub_field_name => $value ) {
								if ( ! isset( $data[ $field_name ][ $sub_field_name ] ) ) {
									$data[ $field_name ][ $sub_field_name ] = array();
								}

								$data[ $field_name ][ $sub_field_name ][] = $value;
							}
						}
					}
				}

				$append = true;
				unset( $data['$push'] );
			}
			$args_cb['append_taxonomies'] = $append;

			$data = apply_filters( 'eo_model_post_before_' . $req_method, $data, $args_cb );

			// Il ne faut pas lancer plusieurs fois pour post.
			if ( 'post' !== $this->get_type() ) {
				$data = apply_filters( 'eo_model_' . $this->get_type() . '_before_' . $req_method, $data, $args_cb );
			}
			$args_cb['data'] = $data;

			$data['id'] = (int) ! empty( $data['id'] ) ? $data['id'] : 0;

			$object = new $model_name( $data, $req_method );

			if ( empty( $object->data['id'] ) ) {
				$post_save_result = wp_insert_post( $object->convert_to_wordpress(), true );

				$object->data['id'] = $post_save_result;
			} else {
				$post_save_result = wp_update_post( $object->convert_to_wordpress(), true );
			}

			// Une erreur est survenue à la sauvegarden on retourne l'erreur.
			if ( is_wp_error( $post_save_result ) ) {
				return $post_save_result;
			}


			$object = apply_filters( 'eo_model_post_after_' . $req_method, $object, $args_cb );
			$object = $this->get( array(
				'id'          => $object->data['id'],
				'post_status' => array( 'any', 'trash' ),
			), true );

			// Il ne faut pas lancer plusieurs fois pour post.
			if ( 'post' !== $this->get_type() ) {
				$object = apply_filters( 'eo_model_' . $this->get_type() . '_after_' . $req_method, $object, $args_cb );
			}

			return $object;
		}

		/**
		 * Recherche dans les meta value.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param string $search Le terme de la recherche.
		 * @param array  $array  La définition de la recherche.
		 *
		 * @return array
		 */
		public function search( $search, $array ) {
			global $wpdb;

			if ( empty( $array ) || ! is_array( $array ) ) {
				return array();
			}

			$where = ' AND ( ';

			if ( ! empty( $array ) ) {
				foreach ( $array as $key => $element ) {
					if ( is_array( $element ) ) {
						foreach ( $element as $sub_element ) {
							$where .= ' AND ( ' === $where ? '' : ' OR ';
							$where .= ' (PM.meta_key="' . $sub_element . '" AND PM.meta_value LIKE "%' . $search . '%") ';
						}
					} else {
						$where .= ' AND ( ' === $where ? '' : ' OR ';
						$where .= ' P.' . $element . ' LIKE "%' . $search . '%" ';
					}
				}
			}

			$where .= ' ) ';

			$list_group = $wpdb->get_results( "SELECT DISTINCT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} AS PM ON PM.post_id=P.ID WHERE P.post_type='" . $this->get_type() . "'" . $where );
			$list_model = array();
			if ( ! empty( $list_group ) ) {
				foreach ( $list_group as $element ) {
					$list_model[] = $this->get( array(
						'id' => $element->ID,
					) );
				}
			}

			return $list_model;
		}

		/**
		 * Retournes le nom de la catégorie attachée au post.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string Le nom de la catégorie.
		 */
		public function get_attached_taxonomy() {
			return $this->attached_taxonomy_type;
		}

		/**
		 * Retournes le nom du post type.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string Le nom du post type.
		 */
		public function get_post_type_name() {
			return $this->post_type_name;
		}

	}
} // End if().
