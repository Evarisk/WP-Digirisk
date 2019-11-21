<?php
/**
 * Gestion des filtres globaux concernant les posts dans EO_Framework.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Model\Filter
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres globaux concernant les champs de type "float" dans EO_Framework.
 */
class Post_Filter {

	/**
	 * Initialisation et appel des différents filtres définis dans EO_Framework.
	 */
	public function __construct() {
		add_filter( 'eo_model_post_after_get', array( $this, 'after_get_post' ), 5, 2 );

		add_filter( 'eo_model_post_after_put', array( $this, 'after_save_post' ), 5, 2 );
		add_filter( 'eo_model_post_after_post', array( $this, 'after_save_post' ), 5, 2 );
	}

	/**
	 * Execute des actions complémentaire après avoir récupéré un objet de type "Post"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param Post_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return Post_Model L'objet de type Post "modifié" par le helper.
	 */
	function after_get_post( $object, $args ) {
		if ( ! empty( $object->data['id'] ) ) {
			$model = $object->get_model();
			if ( ! empty( $model['taxonomy']['child'] ) ) {
				foreach ( $model['taxonomy']['child'] as $key => $value ) {
					$object->data['taxonomy'][ $key ] = wp_get_object_terms( $object->data['id'], $key, array(
						'fields' => 'ids',
					) );
				}
			}
		}

		return $object;
	}

	/**
	 * Execute des actions complémentaire après avoir mis à jour un objet de type "Post"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param Post_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return Post_Model L'objet de type Post "modifié" par le helper.
	 */
	function after_save_post( $object, $args ) {
		// Enregistrement des taxonomies pour l'objet venant d'être enregistré.
		if ( ! empty( $object->data['taxonomy'] ) ) {
			foreach ( $object->data['taxonomy'] as $taxonomy_name => $taxonomy_data ) {
				if ( ! empty( $taxonomy_name ) ) {
					if ( is_int( $taxonomy_data ) || is_array( $taxonomy_data ) ) {
						wp_set_object_terms( $object->data['id'], $taxonomy_data, $taxonomy_name, $args['append_taxonomies'] );
					}
				}
			}
		}

		// Si on envoi date_modified a notre objet, on modifie en "dur" car bloqué par WordPress de base.
		if ( ! empty( $args['data'] ) && ! empty( $args['data']['date_modified'] ) ) {
			$final_date = $args['data']['date_modified'];

			if ( isset( $final_date['raw'] ) ) {
				$final_date = $final_date['raw'];
			}

			$date_time = explode( ' ', $final_date );

			if ( 1 === count( $date_time ) ) {
				$final_date = $final_date . ' ' . current_time( 'H:i:s' );
			}

			$GLOBALS['wpdb']->update( $GLOBALS['wpdb']->posts, array( 'post_modified' => $final_date ), array( 'ID' => $object->data['id'] ) );
			$object->data['date_modified'] = $final_date;
		}

		// Mise à jour des metas.
		Save_Meta_Class::g()->save_meta_data( $object, 'update_post_meta', $args['meta_key'] );

		return $object;
	}

}

new Post_Filter();
