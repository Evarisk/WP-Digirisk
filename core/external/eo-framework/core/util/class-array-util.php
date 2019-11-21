<?php
/**
 * Méthodes utilitaires pour les tableaux.
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

if ( ! class_exists( '\eoxia\Array_Util' ) ) {

	/**
	 * Gestion des tableaux
	 */
	class Array_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 */
		protected function construct() {}

		/**
		 * Compte le nombre de valeur dans un tableau avec récursivité en vérifiant que $match_element soit dans la valeur
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  array   $array         Les données pour la moulinette.
		 * @param  boolean $start         Initialise count avec le tableau du premier niveau.
		 * @param  array   $match_element Doit être un tableau contenant des integers.
		 * @return int                    Le nombre d'entrée
		 */
		public function count_recursive( $array, $start = true, $match_element = array() ) {
			$count = 0;

			if ( $start ) {
				$count = count( $array );
			}

			if ( ! empty( $array ) ) {
				foreach ( $array as $id => $_array ) {
					if ( is_array( $_array ) ) {
						if ( is_string( $id ) && ! empty( $match_element ) && in_array( $id, $match_element, true ) ) {
							$count += count( $_array );
						}

						$count += $this->count_recursive( $_array, false, $match_element );
					}
				}
			}

			return $count;
		}

		/**
		 * Forces à convertir les valeurs d'un tableau en integer.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  array $array Le tableau à convertir en int.
		 * @return array        Le tableau converti en int.
		 */
		public function to_int( $array ) {
			if ( ! empty( $array ) ) {
				foreach ( $array as &$element ) {
					$element = (int) $element;
				}
			}
			return $array;
		}

		/**
		 * Déplaces l'index du tableau vers l'index $to_key.
		 *
		 * @since 0.5.0
		 * @version 1.0.0
		 *
		 * @param  Array   $array Les valeurs contenu dans le tableau. Le tableau ne doit pas être 2D.
		 * @param  mixed   $value Tous types de valeurs.
		 * @param  integer $to_key La clé qui vas être déplacer. Defaut 0
		 * @return Array   Le tableau.
		 */
		public function switch_key( $array, $value, $to_key = 0 ) {
			if ( empty( $array[ $to_key ] ) ) {
				return $array;
			}

			$index_founded = array_search( $value, $array, true );

			if ( false === $index_founded ) {
				return $array;
			}

			$tmp_val = $array[ $to_key ];
			$array[ $to_key ] = $array[ $index_founded ];
			$array[ $index_founded ] = $tmp_val;

			return $array;
		}

		/**
		 * Récursive wp_parse_args de WordPress.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  mixed $a       Les données a mergées.
		 * @param  mixed $default Les données par défaut.
		 * @return array          Les données mergées.
		 */
		public function recursive_wp_parse_args( &$a, $default ) {
			$a       = (array) $a;
			$default = (array) $default;

			$result = $default;
			foreach ( $a as $k => $v ) {
				if ( is_array( $v ) && isset( $result[ $k ] ) ) {
					$result[ $k ] = $this->recursive_wp_parse_args( $v, $result[ $k ] );
				} else {
					$result[ $k ] = $v;
				}
			}

			return $result;
		}
	}
} // End if().
