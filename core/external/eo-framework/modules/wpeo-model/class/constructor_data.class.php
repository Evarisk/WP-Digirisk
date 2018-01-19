<?php
/**
 * Gestion de la construction des données selon les modèles.
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.6.0
 * @copyright 2015-2017
 * @package WPEO_Model
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Constructor_Data_Class' ) ) {
	/**
	 * Gestion de la construction des données selon les modèles.
	 */
	class Constructor_Data_Class extends Helper_Class {

		/**
		 * Appelle la méthode pour dispatcher les données.
		 *
		 * @since 1.0.0
		 * @version 1.4.0
		 *
		 * @param Array $data Les données en brut.
		 */
		public function __construct( $data ) {
			$this->dispatch_wordpress_data( $data, $data );
		}

		/**
		 * Dispatches les données selon le modèle.
		 *
		 * @since 1.0.0
		 * @version 1.6.0
		 *
		 * @param array  $all_data       Toutes les données.
		 * @param array  $data           Les données actuelles.
		 * @param object $current_object L'objet en cours de construction.
		 * @param array  $model          La définition des données.
		 * @return object
		 */
		private function dispatch_wordpress_data( $all_data, $data, $current_object = null, $model = array() ) {
			if ( empty( $model ) ) {
				$model = $this->model;
			}

			if ( null === $current_object ) {
				$current_object = $this;
			}

			foreach ( $model as $field_name => $field_def ) {
				$current_object->$field_name = $this->set_default_data( $field_name, $field_def );

				// Est-ce qu'il existe des enfants ?
				if ( isset( $field_def['field'] ) && isset( $data[ $field_def['field'] ] ) && ! isset( $field_def['child'] ) ) {
					$current_object->$field_name = $data[ $field_def['field'] ];
				} elseif ( isset( $field_def['child'] ) ) {
					$current_data = ! empty( $all_data[ $field_name ] ) ? $all_data[ $field_name ] : array();

					if ( empty( $current_object->$field_name ) ) {
						$current_object->$field_name = new \stdClass();
					}

					$current_object->$field_name = $this->dispatch_wordpress_data( $all_data, $current_data, $current_object->$field_name, $field_def['child'] );
				}

				// $field_name existe est n'a pas d'enfant.
				if ( isset( $data[ $field_name ] ) && isset( $field_def ) && ! isset( $field_def['child'] ) ) {
					$current_object->$field_name = $data[ $field_name ];
				}

				$current_object = $this->handle_type( $current_object, $field_def, $field_name );
			}

			return $current_object;
		}

		/**
		 * Si la définition bydefault existe, récupères la valeur.
		 *
		 * @since 1.0.0
		 * @version 1.5.0
		 *
		 * @param string $field_name Le nom du champ.
		 * @param array  $field_def  La définition du champ.
		 *
		 * @return mixed						 La donnée par défaut.
		 */
		private function set_default_data( $field_name, $field_def ) {
			if ( 'wpeo_date' === $field_def['type'] ) {
				return current_time( 'mysql' );
			} else {
				if ( isset( $field_def['bydefault'] ) ) {
					return $field_def['bydefault'];
				}
			}
		}

		/**
		 * Convertis le modèle en un tableau compatible WordPress.
		 *
		 * @since 1.0.0
		 * @version 1.5.0
		 *
		 * @return array Tableau compatible avec les fonctions WordPress.
		 */
		public function do_wp_object() {
			$data = array();

			foreach ( $this->model as $field_name => $field_def ) {
				if ( 'wpeo_date' === $field_def['type'] && ! empty( $field_def['field'] ) ) {
					$data[ $field_def['field'] ] = $this->{$field_name}['date_input']['date'];
					$this->{$field_name} = $this->{$field_name}['date_input']['date'];
				}
			}

			foreach ( $this->model as $field_name => $field_def ) {

				if ( ! empty( $field_def['field'] ) ) {
					if ( 'wpeo_date' !== $field_def['type'] ) {
						if ( isset( $this->$field_name ) ) {
							$data[ $field_def['field'] ] = $this->$field_name;
						}
					}
				}
			}
			return $data;
		}

		public function handle_type( $current_object, $field_def, $field_name ) {
			if ( ! empty( $field_def['type'] ) ) {
				if ( 'wpeo_date' !== $field_def['type'] ) {
					if ( ! is_array( $current_object->$field_name ) && ! is_object( $current_object->$field_name ) && 'float' === $field_def['type'] ) {
						$current_object->$field_name = str_replace( ',', '.', $current_object->$field_name );
					}
					settype( $current_object->$field_name, $field_def['type'] );

					if ( ! empty( $field_def['array_type'] ) ) {
						if ( ! empty( $current_object->$field_name ) ) {
							foreach ( $current_object->$field_name as &$element ) {
								settype( $element, $field_def['array_type'] );
							}
						}
					}
				} else {
					$current_time = ! empty( $current_object->{$field_name}['date_input'] ) && ! empty( $current_object->{$field_name}['date_input']['date'] ) ? $current_object->{$field_name}['date_input']['date'] : $current_object->$field_name;
					$current_object->$field_name = $this->fill_date( $current_time );
				}
			}

			return $current_object;
		}

		/**
		 * Remplis les champs de type 'wpeo_date'.
		 *
		 * @since 1.5.0
		 * @version 1.5.0
		 *
		 * @param  string $current_time Le date envoyé par l'objet.
		 * @return array {
		 *         Les propriétés
		 *
		 *         @type array data_input {
		 *               Les propriétés de date_input
		 *
		 *               @type string date La date au format MySQL
		 *               @type array  fr_FR {
		 *                     Les propriétés de fr_FR
		 *
		 *                     @type string date      La date au format d/m/Y
		 *                     @type string date_time La date au format d/m/Y H:i:s
		 *               }
		 *               @type array  en_US {
		 *                     Les propriétés de en_US
		 *
		 *                     @type string date      La date au format m-d-y
		 *                     @type string date_time La date au format m-d-y H:i:s
		 *               }
		 *               @type string date_human_readable La date au format lisible.
		 *         }
		 * }
		 */
		public function fill_date( $current_time ) {
			$data = array();

			$data['date_input']['date'] = $current_time;
			$data['date_input']['iso8601'] = mysql2date( 'Y-m-d\TH:i:s\Z', $current_time );
			$data['date_input']['fr_FR']['date'] = mysql2date( 'd/m/Y', $current_time );
			$data['date_input']['fr_FR']['date_time'] = mysql2date( 'd/m/Y H:i:s', $current_time );
			$data['date_input']['fr_FR']['time'] = mysql2date( 'H:i:s', $current_time );

			$data['date_input']['en_US']['date'] = mysql2date( 'm-d-y', $current_time );
			$data['date_input']['en_US']['date_time'] = mysql2date( 'm-d-y H:i:s', $current_time );
			$data['date_input']['en_US']['time'] = mysql2date( 'H:i:s', $current_time );

			$format = '\L\e d F Y à H\hi';
			$data['date_human_readable'] = mysql2date( $format, $current_time );

			return $data;
		}
	}
} // End if().
