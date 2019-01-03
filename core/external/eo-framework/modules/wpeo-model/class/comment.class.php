<?php
/**
 * Gestion des commentaires (POST, PUT, GET, DELETE)
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

if ( ! class_exists( '\eoxia\Comment_Class' ) ) {
	/**
	 * Gestion des commentaires (POST, PUT, GET, DELETE)
	 */
	class Comment_Class extends Object_Class {
		/**
		 * Le nom du modèle à utiliser.
		 *
		 * @var string
		 */
		protected $model_name = '\eoxia\Comment_Model';

		/**
		 * La clé principale pour enregistrer les meta données.
		 *
		 * @var string
		 */
		protected $meta_key = '_comment';

		/**
		 * Le type du commentaire
		 *
		 * @var string
		 */
		protected $type = 'ping';

		/**
		 * Slug de base pour la route dans l'api rest
		 *
		 * @var string
		 */
		protected $base = 'comment';

		/**
		 * Uniquement utile pour DigiRisk...
		 *
		 * @var string
		 */
		protected $identifier_helper = 'comment';

		/**
		 * La liste des droits a avoir pour accèder aux différentes méthodes
		 *
		 * @var array
		 */
		protected $capabilities = array(
			'get'    => 'read',
			'put'    => 'moderate_comments',
			'post'   => 'moderate_comments',
			'delete' => 'moderate_comments',
		);

		/**
		 * Initialise pre_get_comments
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		protected function construct() {
			parent::construct();

			if ( ! in_array( $this->get_type(), \eoxia\Config_Util::$init['eo-framework']->not__in_display_comment ) ) {
				add_action( 'pre_get_comments', array( $this, 'callback_pre_get_comments' ) );
			}
		}

		/**
		 * N'affiches pas les commentaires dans la liste des commentaires.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  WP_Comment_Query $query Query args.
		 *
		 * @return void
		 */
		public function callback_pre_get_comments( $query ) {
			global $pagenow;

			if ( $query->query_vars['type'] !== $this->get_type() && 'edit-comments.php' === $pagenow ) {
				$query->query_vars['type__not_in'] = array_merge( (array) $query->query_vars['type__not_in'], array( $this->get_type() ) );
			}
		}

		/**
		 * Récupères les données selon le modèle définis.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array   $args Les paramètres de get_comments @https://codex.wordpress.org/Function_Reference/get_comments.
		 * @param boolean $single Si on veut récupérer un tableau, ou qu'une seule entrée.
		 *
		 * @return Comment_Model
		 */
		public function get( $args = array(), $single = false ) {
			$array_comments = array();

			$default_args = array(
				'type' => $this->get_type(),
			);

			// Si le paramètre "id" est passé on le transforme en "ID" qui est le paramètre attendu par get_comments.
			// Dans un souci d'homogénéité du code, le paramètre "id" remplace "ID".
			$args['id'] = ! empty( $args['comment_ID'] ) ? $args['comment_ID'] : ( isset( $args['id'] ) ? $args['id'] : null );
			if ( ! empty( $args['id'] ) ) {
				if ( isset( $args['comment_ID'] ) ) {
					unset( $args['comment_ID'] );
				}
				if ( ! isset( $args['comment__in'] ) ) {
					$args['comment__in'] = array();
				}
				$args['comment__in'] = array_merge( (array) $args['id'], $args['comment__in'] );
			} elseif ( isset( $args['id'] ) ) {
				$args['schema'] = true;
			}
			unset( $args['id'] );

			$args_cb    = array(
				'args'         => $args,
				'default_args' => $default_args,
			);
			$final_args = apply_filters( 'eo_model_comment_before_get', wp_parse_args( $args, $default_args ), $args_cb );
			// Il ne faut pas lancer plusieurs fois pour ping.
			if ( 'ping' !== $this->get_type() ) {
				$final_args = apply_filters( 'eo_model_' . $this->get_type() . '_before_get', $final_args, $args_cb );
			}

			// Si l'argument "schema" est présent c'est lui qui prend le dessus et ne va pas récupérer d'élément dans la base de données.
			if ( isset( $args['schema'] ) ) {
				$array_comments[] = $final_args;
			} else { // On lance la requête pour récupèrer les "comments" demandés.
				$array_comments = get_comments( $final_args );
			}

			// Traitement de la liste des résultats pour le retour.
			$array_comments = $this->prepare_items_for_response( $array_comments, 'comment', $this->meta_key, 'comment_ID' );

			// Si on a demandé qu'une seule entrée et qu'il n'y a bien qu'une seule entrée correspondant à la demande alors on ne retourne que cette entrée.
			if ( true === $single && 1 === count( $array_comments ) ) {
				$array_comments = $array_comments[0];
			}

			return $array_comments;
		}

		/**
		 * Insère ou met à jour les données dans la base de données.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  Array $data Les données a insérer ou à mettre à jour.
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

			// Vérifie l'existence du type.
			if ( empty( $data['type'] ) ) {
				$data['type'] = $this->get_type();
			}

			if ( empty( $data['id'] ) ) {

				if ( ! empty( $data['author_id'] ) ) {
					$user = get_userdata( $data['author_id'] );
				} else {
					$user = wp_get_current_user();
				}

				if ( $user->exists() ) {
					if ( empty( $data['author_id'] ) ) {
						$data['author_id'] = $user->ID;
					}

					if ( empty( $data['author_nicename'] ) ) {
						$data['author_nicename'] = $user->display_name;
					}

					if ( empty( $data['author_email'] ) ) {
						$data['author_email'] = $user->user_email;
					}

					if ( empty( $data['author_url'] ) ) {
						$data['author_url'] = $user->user_url;
					}
				}
			}

			$data = apply_filters( 'eo_model_comment_before_' . $req_method, $data, $args_cb );
			// Il ne faut pas lancer plusieurs fois pour ping.
			if ( 'ping' !== $this->get_type() ) {
				$data = apply_filters( 'eo_model_' . $this->get_type() . '_before_' . $req_method, $data, $args_cb );
			}
			$args_cb['data'] = $data;

			$object = new $model_name( $data, $req_method );

			if ( empty( $object->data['id'] ) ) {
				add_filter( 'duplicate_comment_id', '__return_false' );
				add_filter( 'pre_comment_approved', function( $approved, $comment_data ) {
					return $comment_data['comment_approved'];
				}, 10, 2 );
				$inserted_comment = wp_insert_comment( $object->convert_to_wordpress() );
				if ( is_wp_error( $inserted_comment ) ) {
					return $inserted_comment;
				}

				$object->data['id'] = $inserted_comment;
			} else {
				wp_update_comment( $object->convert_to_wordpress() );
			}

			$object = apply_filters( 'eo_model_comment_after_' . $req_method, $object, $args_cb );

			$object = $this->get( array(
				'id'     => $object->data['id'],
				'status' => array( '1', 'trash' ),
			), true );

			// Il ne faut pas lancer plusieurs fois pour ping.
			if ( 'ping' !== $this->get_type() ) {
				$object = apply_filters( 'eo_model_' . $this->get_type() . '_after_' . $req_method, $object, $args_cb );
			}

			return $object;
		}

	}
} // End if().
