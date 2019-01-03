<?php
/**
 * Gestion des meta
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

if ( ! class_exists( '\eoxia\Save_Meta_Class' ) ) {

	/**
	 * Gestion des meta
	 */
	class Save_Meta_Class extends Singleton_Util {

		/**
		 * Le constructeur
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		protected function construct() {}

		/**
		 * Apelle la méthode selon si la définition du champ est en meta "single" ou "multiple".
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  object $object   L'objet courant.
		 * @param  string $function La méthode a appeler.
		 * @param  string $meta_key Le nom de la meta key.
		 */
		public static function save_meta_data( $object, $function, $meta_key ) {
			$schema = $object->get_model();

			$list_meta_json = array();

			if ( ! empty( $object->data['id'] ) ) {
				foreach ( $schema as $field_name => $field_def ) {
					if ( ! empty( $field_def['meta_type'] ) && isset( $object->data[ $field_name ] ) ) {
						if ( 'single' === $field_def['meta_type'] ) {
							self::g()->save_single_meta_data( $object->data['id'], $object->data[ $field_name ], $function, $field_def['field'] );
						} else {
							$list_meta_json[ $field_name ] = $object->data[ $field_name ];
						}
					}
				}

				self::g()->save_multiple_meta_data( $object->data['id'], $list_meta_json, $function, $meta_key );
			}
		}

		/**
		 * Sauvegarde la valeur dans une meta seul.
		 *
		 * @param int    $id       L'ID de l'élément.
		 * @param mixed  $value    La valeur a enregistrer.
		 * @param string $function La function a appeler.
		 * @param string $meta_key Le nom de la meta.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		private function save_single_meta_data( $id, $value, $function, $meta_key ) {
			$data = $value;

			if ( is_array( $data ) ) {
				$data = \wp_json_encode( $data );
				$data = addslashes( $data );
				$data = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $data );
			}

			call_user_func( $function, $id, $meta_key, $data );
		}

		/**
		 * Sauvegarde les valeurs dans une meta.
		 *
		 * @param int    $id          L'ID de l'élément.
		 * @param mixed  $array_value Les valeurs a enregistrer.
		 * @param string $function    La function a appeler.
		 * @param string $meta_key    Le nom de la meta.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		private function save_multiple_meta_data( $id, $array_value, $function, $meta_key ) {
			$data = wp_json_encode( $array_value );

			// Pour échapper les caractères car les update_*_meta enlève un slashes après.
			$data = addslashes( $data );

			// Remplaces le paramètre $options de json_encode disponible à partir de php 5.4.0: JSON_UNESCAPED_UNICODE.
			$data = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
				$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
				return $sym;
			}, $data );

			call_user_func( $function, $id, $meta_key, $data );
		}
	}
} // End if().
