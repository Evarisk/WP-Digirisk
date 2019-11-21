<?php
/**
 * Gestion des objets ( posts / terms / comments / users )
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Object_Class' ) ) {

	/**
	 * Gestion des posts (POST, PUT, GET, DELETE)
	 */
	class Object_Class extends Rest_Class {

		/**
		 * Le nom du modèle pour l'objet actuel.
		 *
		 * @var string
		 */
		protected $model_name = '';

		/**
		 * Le type de l'objet actuel.
		 *
		 * @var string
		 */
		protected $type = '';

		/**
		 * Le slug de base de l'objet actuel.
		 *
		 * @var string
		 */
		protected $base = '';

		/**
		 * La clé principale pour la méta de l'objet.
		 *
		 * @var string
		 */
		protected $meta_key = '';

		/**
		 * Utiles pour récupérer la clé unique
		 *
		 * @var string
		 */
		protected $identifier_helper = '';

		/**
		 * Utile uniquement pour DigiRisk.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string L'identifiant des commentaires pour DigiRisk.
		 */
		public function get_identifier_helper() {
			return $this->identifier_helper;
		}

		/**
		 * Permet de récupérer le schéma avec les données du modèle par défault.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return Object
		 */
		public function get_schema() {
			$model_name = $this->model_name;
			$model      = new $model_name( array(), null );
			return $model->get_model();
		}

		/**
		 * Permet de changer le modèle en dur.
		 *
		 * @param string $model_name Le nom du modèle.
		 *
		 * @since 1.0.0
		 * @version 1.3.6.0
		 */
		public function set_model( $model_name ) {
			$this->model_name = $model_name;
		}

		/**
		 * Retourne le post type.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string Le type de l'objet actuel
		 */
		public function get_type() {
			return $this->type;
		}

		/**
		 * Retourne le nom de la méta générale de l'objet actuel.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string Le nom de la méta de l'objet actuel
		 */
		public function get_meta_key() {
			return $this->meta_key;
		}

		/**
		 * Appelle la méthode update puis renvoies l'objet mis à jour ou créé.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param Array $data Les données.
		 *
		 * @return Object     L'objet avec toutes ses données.
		 */
		public function create( $data ) {
			$data['id'] = ! empty( $data['id'] ) ? (int) $data['id'] : 0;
			$object = $this->update( $data );

			$parent_class = get_parent_class( $object );

			// Utiles seulement pour les posts et les comments, car les users et categories on déjà toutes leurs données à ce moment là.
			if ( in_array( $parent_class, array( 'eoxia\Comment_Model', 'eoxia\Post_Model' ) ) ) {
				$args = array(
					'id' => $object->data['id'],
				);

				$args['status'] = $object->data['status'];

				$object = $this->get( $args, true );
			}

			return $object;
		}

		/**
		 * Factorisation de la fonction de construction des objets après un GET.
		 *
		 * @param array  $object_list     La liste des objets récupérés.
		 * @param string $wp_type         Le type de l'élément actuel en cours de traitement.
		 * @param string $meta_key        La clé de la métadonnée principale que l'on a défini pour l'objet.
		 * @param string $object_id_field la clé primaire permettant d'identifier l'objet.
		 *
		 * @return array                  La liste des objets construits selon le modèle défini.
		 */
		public function prepare_items_for_response( $object_list, $wp_type, $meta_key, $object_id_field ) {
			$model_name = $this->model_name;

			if ( ! empty( $object_list ) ) {
				foreach ( $object_list as $key => $object ) {
					$object  = (array) $object;
					$args_cb = array(
						'wp_type'      => $wp_type,
						'element_type' => $this->get_type(),
						'model_name'   => $model_name,
					);

					// Si $object[ $object_id_field ] existe, on récupère les meta.
					if ( ! empty( $object[ $object_id_field ] ) ) {
						$list_meta = call_user_func( 'get_' . $wp_type . '_meta', $object[ $object_id_field ] );
						foreach ( $list_meta as &$meta ) {
							$meta = array_shift( $meta );
							$meta = JSON_Util::g()->decode( $meta );
						}

						$object = apply_filters( 'eo_model_' . $wp_type . '_after_get_meta', $object, array_merge( $args_cb, array( 'list_meta' => $list_meta ) ) );
						$object = apply_filters( 'eo_model_' . $this->get_type() . '_after_get_meta', $object, array_merge( $args_cb, array( 'list_meta' => $list_meta ) ) );

						$object = array_merge( $object, $list_meta );

						if ( ! empty( $object[ $meta_key ] ) ) {
							$data_json = JSON_Util::g()->decode( $object[ $meta_key ] );
							if ( is_array( $data_json ) ) {
								$object = array_merge( $object, $data_json );
							} else {
								$object[ $meta_key ] = $data_json;
							}
							unset( $object[ $meta_key ] );
						}
					}

					// Construction de l'objet selon les données reçues.
					// Soit un objet vide si l'argument schema est défini. Soit l'objet avec ses données.
					$object_list[ $key ] = new $model_name( $object, 'get' );

					// On donne la possibilité de lancer des actions sur l'élément actuel une fois qu'il est complément construit.
					$object_list[ $key ] = apply_filters( 'eo_model_' . $wp_type . '_after_get', $object_list[ $key ], $args_cb );
					$object_list[ $key ] = apply_filters( 'eo_model_' . $this->get_type() . '_after_get', $object_list[ $key ], $args_cb );
				} // End foreach().
			}

			return $object_list;
		}

	}

}
