<?php
/**
 * Méthodes utiles pour les posts de WordPress.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\Core\Util
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Post_Util' ) ) {
	/**
	 * Gestion des posts
	 */
	class Post_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		protected function construct() {}

		/**
		 * Est ce que le post est un parent des enfants ?
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param int $parent_id (test: 10) L'id du post parent.
		 * @param int $children_id (test: 11) L'id du post enfant.
		 *
		 * @return bool true|false
		 */
		public static function is_parent( $parent_id, $children_id ) {
			$list_parent_id = get_post_ancestors( $children_id );
			if ( ! empty( $list_parent_id ) && in_array( $parent_id, $list_parent_id, true ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Vérifie si le post contient un enfant.
		 *
		 * @since 0.5.0
		 * @version 1.0.0
		 *
		 * @param  integer $parent_id  L'ID du post.
		 * @param  array   $post_types Les post types à rechercher.
		 *
		 * @return boolean
		 */
		public static function have_child( $parent_id, $post_types ) {
			$child = get_children(array(
				'numberposts' => 1,
				'post_parent' => $parent_id,
				'post_type'   => $post_types,
				'output' => 'ARRAY_A',
			) );

			if ( ! empty( $child ) ) {
				return true;
			}

			return false;
		}
	}
}
