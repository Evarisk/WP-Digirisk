<?php
/**
 * Gestion des termes (POST, PUT, GET, DELETE)
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

if ( ! class_exists( '\eoxia\Term_Class' ) ) {

	/**
	 * Gestion des termes (POST, PUT, GET, DELETE)
	 */
	class Term_Class extends Object_Class {

		/**
		 * Le nom du modèle
		 *
		 * @var string
		 */
		protected $model_name = 'term_model';

		/**
		 * La clé principale pour post_meta
		 *
		 * @var string
		 */
		protected $meta_key = '_wpeo_term';

		/**
		 * Le nom de la taxonomie
		 *
		 * @var string
		 */
		protected $type = 'category';

		/**
		 * Slug de base pour la route dans l'api rest
		 *
		 * @var string
		 */
		protected $base = 'category';

		/**
		 * Pour l'association de la taxonomy
		 *
		 * @var string|array
		 */
		protected $associate_post_types = array();

		/**
		 * Utiles pour récupérer la clé unique
		 *
		 * @todo Rien à faire ici
		 * @var string
		 */
		protected $identifier_helper = 'term';

		/**
		 * La liste des droits a avoir pour accèder aux différentes méthodes
		 *
		 * @var array
		 */
		protected $capabilities = array(
			'get'    => 'read',
			'put'    => 'manage_categories',
			'post'   => 'manage_categories',
			'delete' => 'manage_categories',
		);

		/**
		 * Le constructeur
		 *
		 * @return void
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 */
		protected function construct() {
			parent::construct();

			add_action( 'init', array( $this, 'callback_init' ) );
		}

		/**
		 * Initialise la taxonomie
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		public function callback_init() {
			$args = array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			);

			register_taxonomy( $this->get_type(), $this->associate_post_types, $args );
		}

		/**
		 * Récupères les données selon le modèle définis.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array   $args Les paramètres de get_terms @https://codex.wordpress.org/Function_Reference/get_terms.
		 * @param boolean $single Si on veut récupérer un tableau, ou qu'une seule entrée.
		 *
		 * @return Object
		 */
		public function get( $args = array(), $single = false ) {
			$array_terms = array();

			$default_args = array(
				'hide_empty' => false,
				'taxonomy'   => $this->get_type(),
			);

			// Si le paramètre "id" est passé on le transforme en "include" qui est la paramètre attendu par WP_Term_Query.
			// Dans un soucis d'homogénéité du code, le paramètre "id" remplace le paramètre "include" dans les appels de la fonction.
			$args['id'] = ! empty( $args['term_id'] ) ? $args['term_id'] : ( isset( $args['id'] ) ? $args['id'] : null );
			if ( ! empty( $args['id'] ) ) {
				if ( isset( $args['term_id'] ) ) {
					unset( $args['term_id'] );
				}
				if ( ! isset( $args['include'] ) ) {
					$args['include'] = array();
				}
				$args['include'] = array_merge( $args['include'], (array) $args['id'] );
			} elseif ( isset( $args['id'] ) ) {
				$args['schema'] = true;
			}
			unset( $args['id'] );

			// @Todo: a voir pourquoi wp_get_post_terms et pas wp_get_object_terms et si pas d'autre moyen que ici.
			// elseif ( isset( $args['post_id'] ) ) {
			// 	$array_term = wp_get_post_terms( $args['post_id'], $this->get_type(), $term_final_args );
			//
			// 	if ( empty( $array_term ) ) {
			// 		$array_term[] = array();
			// 	}
			// }

			$args_cb    = array(
				'args'         => $args,
				'default_args' => $default_args,
			);
			$final_args = apply_filters( 'eo_model_term_before_get', wp_parse_args( $args, $default_args ), $args_cb );
			// Il ne faut pas lancer plusieurs fois pour term.
			if ( 'term' !== $this->get_type() ) {
				$final_args = apply_filters( 'eo_model_' . $this->get_type() . '_before_get', $final_args, $args_cb );
			}

			// Si l'argument "schema" est présent c'est lui qui prend le dessus et ne va pas récupérer d'élément dans la base de données.
			if ( isset( $args['schema'] ) ) {
				$array_terms[] = $final_args;
			} else { // On lance la requête pour récupèrer les "terms" demandés.
				$query_terms = new \WP_Term_Query( $final_args );
				$array_terms = $query_terms->terms;
				unset( $query_terms->terms );
			}

			// Traitement de la liste des résultats pour le retour.
			$array_terms = $this->prepare_items_for_response( $array_terms, 'term', $this->meta_key, 'term_id' );

			// Si on a demandé qu'une seule entrée et qu'il n'y a bien qu'une seule entrée correspondant à la demande alors on ne retourne que cette entrée.
			if ( true === $single && 1 === count( $array_terms ) ) {
				$array_terms = $array_terms[0];
			}

			return $array_terms;
		}

		/**
		 * Insère ou met à jour les données dans la base de donnée.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  Array $data Les données a insérer ou à mêttre à jour.
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

			$data = apply_filters( 'eo_model_term_before_' . $req_method, $data, $args_cb );
			// Il ne faut pas lancer plusieurs fois pour category.
			if ( 'category' !== $this->get_type() ) {
				$data = apply_filters( 'eo_model_' . $this->get_type() . '_before_' . $req_method, $data, $args_cb );
			}
			$args_cb['data'] = $data;

			$object = new $model_name( $data, $req_method );

			if ( empty( $object->data['id'] ) ) {
				$term = wp_insert_term( $object->data['name'], $this->get_type(), $object->convert_to_wordpress() );
			} else {
				$term = wp_update_term( $object->data['id'], $this->get_type(), $object->convert_to_wordpress() );
			}

			if ( is_wp_error( $term ) ) {
				if ( ! empty( $term->error_data['term_exists'] ) && is_int( $term->error_data['term_exists'] ) ) {
					return $this->get( array(
						'id' => $term->error_data['term_exists'],
					), true );
				}

				return $term;
			}

			// Lors de la création, $object->data['id'] est vide là, du coup le get ne marchait pas.
			$object->data['id'] = $term['term_id'];

			$object = apply_filters( 'eo_model_term_after_' . $req_method, $object, $args_cb );
			$object = $this->get( array( 'id' => $object->data['id'] ), true );

			// Il ne faut pas lancer plusieurs fois pour category.
			if ( 'category' !== $this->get_type() ) {
				$object = apply_filters( 'eo_model_' . $this->get_type() . '_after_' . $req_method, $object, $args_cb );
			}

			return $object;
		}

	}
} // End if().
