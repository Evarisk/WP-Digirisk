<?php
/**
 * Handle schema.
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

if ( ! class_exists( '\eoxia\Schema_Class' ) ) {

	/**
	 * Classe helper pour les modèles.
	 */
	class Schema_Class extends Singleton_Util {



		/**
		 * Requried for Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 */
		protected function construct() {}

		/**
		 * Vérifie si les données sont bien typées. Cette méthode ne force pas le typage des données.
		 * Renvoies des erreurs si une des données ne correspond pas au type attendu.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  array $data         Toutes les données y compris les meta.
		 * @param  array $model        Le schéma.
		 * @param  array $current_data Les données actuelles.
		 * @param  array $errors       Les erreurs de typages.
		 *
		 * @return array               Les erreurs de typages.
		 */
		public static function check_data_from_schema( $data, $model, $current_data = null, $errors = array() ) {
			$current_data = ( null === $current_data ) ? $data : $current_data;

			foreach ( $model as $field_name => $field_def ) {
				$value = null;
				$error = null;
				// Si la définition de la donnée ne contient pas "child".
				if ( ! isset( $field_def['child'] ) ) {

					// Si on est au premier niveau de $current_object, sinon si on est plus haut que le premier niveau.
					if ( isset( $field_def['field'] ) && isset( $current_data[ $field_def['field'] ] ) ) {
						$value = $current_data[ $field_def['field'] ];
					} elseif ( isset( $current_data[ $field_name ] ) && isset( $field_def ) && ! isset( $field_def['child'] ) ) {
						$value = $current_data[ $field_name ];
					}

					// Verifie si le champ est required.
					if ( isset( $field_def['required'] ) && $field_def['required'] && null === $value ) {
						$errors[] = $field_name . ' is required';
					}

					// Vérifie le type de $value.
					if ( null !== $value ) {
						if ( ! self::check_type( $value, $field_name, $field_def['type'], $error ) ) {
							$errors[] = $error;
						}
					}
				} else {
					// Values car c'est un tableau, nous sommes dans "child". Nous avons donc un tableau dans $data[ $field_name ].
					$values = ! empty( $data[ $field_name ] ) ? $data[ $field_name ] : array();

					// Récursivité sur les enfants de la définition courante.
					$errors = self::check_data_from_schema( $data, $field_def['child'], $values, $errors );
				}
			}

			return $errors;
		}

		/**
		 * Vérifie le type de la valeur courante.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param mixed  $value      N'importe quel type de valeur.
		 * @param string $field_name Le nom du champ à vérifier.
		 * @param string $type       Le type de la donnée à vérifier.
		 * @param array  $error      Une référence pour ajouter les messages d'erreurs.
		 *
		 * @return bool               False si une erreur, sinon true.
		 */
		public static function check_type( $value, $field_name, $type, &$error ) {
			$checked_type = true;

			switch ( $type ) {
				case 'string':
					if ( ! is_string( $value ) ) {
						$error        = $field_name . ': ' . $value . '(' . gettype( $value ) . ') is not a ' . $type;
						$checked_type = false;
					}
					break;
				case 'integer':
					if ( ! is_int( $value ) ) {
						$error        = $field_name . ': ' . $value . '(' . gettype( $value ) . ') is not a ' . $type;
						$checked_type = false;
					}
					break;
				default:
					if ( empty( $type ) ) {
						$error = $field_name . ': ' . $value . '(' . gettype( $value ) . ') no setted in schema. Type accepted: ' . join( ',', self::$accepted_types );
					}

					if ( ! in_array( $type, self::$accepted_types, true ) ) {
						$error = $field_name . ': ' . $value . '(' . gettype( $value ) . ') incorrect type: "' . $type . '". Type accepted: ' . join( ',', self::$accepted_types );
					}

					$checked_type = false;

					break;
			}

			return $checked_type;
		}
	}
} // End if().
