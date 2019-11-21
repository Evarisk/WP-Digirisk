<?php
/**
 * Gestion des utilisateurs (POST, PUT, GET, DELETE)
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

if ( ! class_exists( '\eoxia\User_Class' ) ) {
	/**
	 * Gestion des utilisateurs (POST, PUT, GET, DELETE)
	 */
	class User_Class extends Object_Class {
		/**
		 * Le nom du modèle
		 *
		 * @var string
		 */
		protected $model_name = '\eoxia\User_Model';

		/**
		 * La clé principale pour post_meta
		 *
		 * @var string
		 */
		protected $meta_key = '_wpeo_user';

		/**
		 * Utiles pour récupérer la clé unique
		 *
		 * @todo Rien à faire ici
		 * @todo Expliquer la documentation
		 *
		 * @var string
		 */
		protected $identifier_helper = 'user';

		/**
		 * User element type
		 *
		 * @var string
		 */
		protected $type = 'user';

		/**
		 * Utiles pour DigiRisk
		 *
		 * @todo Rien à faire ici
		 * @var string
		 */
		public $element_prefix = 'U';

		/**
		 * La liste des droits a avoir pour accèder aux différentes méthodes
		 *
		 * @var array
		 */
		protected $capabilities = array(
			'get'    => 'list_users',
			'put'    => 'edit_users',
			'post'   => 'edit_users',
			'delete' => 'delete_users',
		);

		/**
		 * Slug de base pour la route dans l'api rest
		 *
		 * @var string
		 */
		protected $base = 'user';

		/**
		 * Récupères les données selon le modèle définis.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array   $args Les paramètres de WP_User_Query @see https://codex.wordpress.org/Class_Reference/WP_User_Query.
		 * @param boolean $single Si on veut récupérer un tableau, ou qu'une seule entrée.
		 *
		 * @return Comment_Model
		 */
		public function get( $args = array(), $single = false ) {
			$array_users = array();

			if ( ! empty( $args['id'] ) ) {
				if ( ! isset( $args['include'] ) ) {
					$args['include'] = array();
				}
				$args['include'] = array_merge( (array) $args['id'], $args['include'] );
				unset( $args['id'] );
			} elseif ( isset( $args['id'] ) ) {
				$args['schema'] = true;
			}

			$args = apply_filters( 'eo_model_user_before_get', $args );

			if ( isset( $args['schema'] ) ) {
				$array_users[] = $args;
			} else {
				$array_users = get_users( $args );
			}

			// Traitement de la liste des résultats pour le retour.
			$array_users = $this->prepare_items_for_response( $array_users, 'user', $this->meta_key, 'ID' );

			if ( true === $single && 1 === count( $array_users ) ) {
				$array_users = $array_users[0];
			}

			return $array_users;
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

			if ( 'post' === $req_method ) {
				while ( username_exists( $data['login'] ) ) {
					$data['login'] .= wp_rand( 1000, 9999 );
				}
			}

			if ( ! empty( $data['id'] ) ) {
				$current_data = $this->get( array(
					'id' => $data['id'],
				), true );
				$data         = Array_Util::g()->recursive_wp_parse_args( $data, $current_data->data );
			}

			$data = apply_filters( 'eo_model_user_before_' . $req_method, $data, $args_cb );

			$args_cb['data'] = $data;

			$object = new $model_name( $data, $req_method );

			if ( empty( $object->data['id'] ) ) {
				$inserted_user = wp_insert_user( $object->convert_to_wordpress() );
				if ( is_wp_error( $inserted_user ) ) {
					return $inserted_user;
				}

				$object->data['id'] = $inserted_user;
			} else {

				$updated_user = wp_update_user( $object->convert_to_wordpress() );
				if ( is_wp_error( $updated_user ) ) {
					return $updated_user;
				}

				$object->data['id'] = $updated_user;
			}

			$object = apply_filters( 'eo_model_user_after_' . $req_method, $object, $args_cb );

			return $object;
		}

	}
} // End if().
