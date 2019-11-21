<?php
/**
 * Gestion de la construction des données selon les modèles.
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

if ( ! class_exists( '\eoxia\Data_Class' ) ) {
	/**
	 * Gestion de la construction des données selon les modèles.
	 */
	class Data_Class extends Helper_Class {

		/**
		 * La liste des types de base dans PHP acceptés par EO_Framework pour les champs.
		 *
		 * @var array
		 */
		public static $built_in_types = array( 'string', 'integer', 'float', 'boolean', 'array' );

		/**
		 * La liste des types de personnalisés acceptés par EO_Framework pour les champs.
		 *
		 * @var array
		 */
		public static $custom_types = array( 'wpeo_date' );

		/**
		 * La liste complétes des types de champs acceptés pour les champs dans EO_Framework.
		 *
		 * @var array
		 */
		public static $accepted_types = array();

		/**
		 * Variable contenant l'ensemble des erreurs rencontrées lors de la création d'un objet.
		 *
		 * @var WP_Error
		 */
		private $wp_errors;

		/**
		 * Variable contenant la méthode actuellement utilisée. Permet de construire l'objet demandé selon la méthode HTTP utilisée.
		 *
		 * @var string
		 */
		private $req_method;

		/**
		 * Appelle la méthode pour dispatcher les données.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param Array  $data       Les données non traité. Peut être null, permet de récupérer le schéma.
		 * @param string $req_method La méthode HTTP actuellement utilisée.
		 */
		public function __construct( $data = null, $req_method ) {
			$this->wp_errors  = new \WP_Error();
			$this->req_method = ( null !== $req_method ) ? strtoupper( $req_method ) : null;

			// On construit les types autorisés à partir des listes séparées. Permet de ne pas mettre de type en dur dans le code.
			self::$accepted_types = wp_parse_args( self::$custom_types, self::$built_in_types );

			// Filtre du schéma.
			$this->schema = apply_filters( 'eo_model_handle_schema', $this->schema, $this->req_method );

			if ( null !== $data && null !== $this->req_method ) {
				$this->data = $this->handle_data( $data );
			}

			if ( ! empty( $this->wp_errors->errors ) ) {
				echo wp_json_encode( $this->wp_errors );
				exit;
			}
		}

		/**
		 * Dispatches les données selon le modèle.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param array $data   Les données envoyées par l'utilisateur pour construire un objet selon un schéma.
		 * @param array $schema Optionnal. La définition des données. Ce paramètre est utilisé uniquement dans le cas d'un schéma récursif.
		 *
		 * @return object       Les données traitées, typées et converties en l'objet demandé.
		 */
		private function handle_data( $data, $schema = null ) {
			$object = null;
			$schema = ( null === $schema ) ? $this->schema : $schema;

			foreach ( $schema as $field_name => $field_def ) {
				// Définie les données  par défaut pour l'élément courant par rapport à "default".
				$value = null;
				if ( isset( $field_def['default'] ) && in_array( $this->req_method, array( 'GET', 'POST' ), true ) ) {
					$value = $field_def['default'];
				}

				// On vérifie si la valeur du champs actuelle est fournie dans les données envoyées pour construction.
				if ( isset( $field_def['field'] ) && isset( $data[ $field_def['field'] ] ) ) { // On vérifie si la clé correspondant au champs de la BDD existe. $data['post_date'].
					$value = $data[ $field_def['field'] ];
				} elseif ( isset( $data[ $field_name ] ) && isset( $field_def ) && ! isset( $field_def['child'] ) ) { // On vérifie si la clé correspondant au schéma défini existe. $data['date'].
					$value = $data[ $field_name ];
				}

				$value = apply_filters( 'eo_model_handle_value', $value, $this, $field_def, $this->req_method );

				// Dans le cas ou la méthode actuelle implique un enregistrement dans la base de données.
				// On vérifie que le schéma n'indique pas une valeur obligatoire. Si le champs est vide on retourne une erreur.
				if ( 'GET' !== $this->req_method && isset( $field_def['required'] ) && $field_def['required'] && null === $value ) {
					$this->wp_errors->add( 'eo_model_is_required', get_class( $this ) . ' => ' . $field_name . ' is required' );
				}

				// Force le typage de $value en requête mode "GET".
				if ( 'GET' === $this->req_method ) {
					$value = $this->handle_value_type( $value, $field_def );
				}

				// Vérifie le typage de $value.
				$this->check_value_type( $value, $field_name, $field_def );

				// On assigne la valeur "construite" au champs dans l'objet en cours de construction.
				if ( null !== $value ) {
					$object[ $field_name ] = $value;
				}

				// Dans le cas ou la méthode actuelle implique un enregistrement dans la base de données.
				// Si la valeur "construite" est "null" (aucun cas précédent n'a rempli ce champs) et que le champs est requis alors on le supprime pour ne pas supprimer de la BDD.
				if ( 'GET' !== $this->req_method ) {
					if ( isset( $object[ $field_name ] ) && null === $value && isset( $field_def['required'] ) && $field_def['required'] ) {
						unset( $object[ $field_name ] );
					}
				}

				// Si le champs traité contient l'entrée "child" il s'agit d'un tableau mutli-dimensionnel alors on lance une récursivité.
				if ( isset( $field_def['child'] ) ) {
					// On vérifie si des données correspondantes au champs en traitement ont été envoyées.
					$values = ! empty( $data[ $field_name ] ) ? $data[ $field_name ] : array();

					// Récursivité sur les enfants de la définition courante.
					$object[ $field_name ] = $this->handle_data( $values, $field_def['child'] );
				}
			}

			return $object;
		}

		/**
		 * Vérification du type de la valeur d'un champs. Si le type n'est pas correct on rempli la variable $this->wp_errors qui sera retournée en fin de traitement.
		 *
		 * @param mixed  $value      La valeur du champs à vérifier.
		 * @param string $field_name Le nom du champs à vérifier. Utilisé pour le message d'erreur.
		 * @param array  $field_def  La définition complète du champs à vérifier.
		 *
		 * @return void
		 */
		public function check_value_type( $value, $field_name, $field_def ) {
			// Vérifie le type de $value.
			if ( null !== $value ) {
				if ( empty( $field_def['type'] ) ) {
					$this->wp_errors->add( 'eo_model_invalid_type', get_class( $this ) . ' => ' . $field_name . ': ' . $value . '(' . gettype( $value ) . ') no setted in schema. Type accepted: ' . join( ',', self::$accepted_types ) );
				} else {
					$field_type = true;
					switch ( $field_def['type'] ) {
						case 'string':
							if ( ! is_string( $value ) ) {
								$field_type = false;
							}
							break;
						case 'integer':
							if ( ! is_int( $value ) ) {
								$field_type = false;
							}
							break;
						case 'boolean':
							if ( ! is_bool( $value ) ) {
								$field_type = false;
							}
							break;
						case 'array':
							if ( ! is_array( $value ) ) {
								$rendered_value = is_object( $value ) ? 'Object item' : $value;

								$this->wp_errors->add( 'eo_model_invalid_type', get_class( $this ) . ' => ' . $field_name . ': ' . $rendered_value . '(' . gettype( $value ) . ') is not a ' . $field_def['type'] );
							} elseif ( isset( $field_def['array_type'] ) ) {
								if ( ! empty( $value ) ) {
									foreach ( $value as $key => $sub_value ) {
										$field_def['type'] = $field_def['array_type'];
										$this->check_value_type( $sub_value, $field_name, $field_def );

										if ( isset( $field_def['key_type'] ) ) {
											$field_def['type'] = $field_def['key_type'];
											$this->check_value_type( $key, $field_name, $field_def );
										}
									}
								}
							}
							break;
						default:
							if ( ! in_array( $field_def['type'], self::$accepted_types, true ) ) {
								$this->wp_errors->add( 'eo_model_invalid_type', get_class( $this ) . ' => ' . $field_name . ': ' . $value . '(' . gettype( $value ) . ') incorrect type: "' . $field_def['type'] . '". Type accepted: ' . join( ',', self::$accepted_types ) );
							}
							break;
					}

					if ( ! $field_type ) {
						// Translators: 1.Current className 2.Field name 3.Given value 4.Field Real type 5.Field expected type.
						$this->wp_errors->add( 'eo_model_invalid_type', sprintf( __( '%1$s => %2$s: %3$s ( %4$s ) is not a %5$s', 'eo-framework' ), get_class( $this ), $field_name, $value, gettype( $value ), $field_def['type'] ) );
					}
				}
			}
		}

		/**
		 * Forces le typage des données.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param mixed $value     La valeur courante.
		 * @param array $field_def La définition du champ.
		 *
		 * @return mixed           L'objet avec le typage forcé.
		 */
		public function handle_value_type( $value, $field_def ) {
			// Si le type du champs à vérifier est parmis les types personnalisés (non défini par PHP) alors on retourne simplement la valeur, la fonction risque de corrompre les données.
			if ( in_array( $field_def['type'], self::$custom_types, true ) ) {
				return $value;
			}

			/**
			 * On type la valeur.
			 *
			 * @see self::$accepted_types
			 */
			settype( $value, $field_def['type'] );

			// On force le typage des enfants uniquement si array_type est défini.
			if ( ! empty( $field_def['array_type'] ) && is_array( $value ) && ! empty( $value ) ) {
				foreach ( $value as $key => $val ) {
					/**
					 * On type la valeur.
					 *
					 * @see self::$accepted_types
					 */
					settype( $value[ $key ], $field_def['array_type'] );
				}
			}

			return $value;
		}

		/**
		 * Convertis le modèle en un tableau compatible WordPress.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return array Tableau compatible avec les fonctions WordPress.
		 */
		public function convert_to_wordpress() {
			$data = array();

			foreach ( $this->schema as $field_name => $field_def ) {

				if ( ! empty( $field_def['field'] ) ) {
					if ( isset( $this->data[ $field_name ] ) ) {
						$value = ( ( isset( $this->data[ $field_name ] ) && null !== $this->data[ $field_name ] ) ) ? $this->data[ $field_name ] : null;

						if ( null !== $value ) {
							if ( ! in_array( $field_def['type'], self::$custom_types, true ) || ! isset( $value['raw'] ) ) {
								$data[ $field_def['field'] ] = $value;
							} elseif ( isset( $value['raw'] ) ) {
								$data[ $field_def['field'] ] = $value['raw'];
							}
						}
					}
				}
			}

			return $data;
		}
	}

} // End if().
