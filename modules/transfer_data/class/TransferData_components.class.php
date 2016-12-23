<?php
namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant les utilitaires pour les tranferts spécifiques pour les composants de configurations (danger/méthode d'évaluation/préconnisation) / File with all utilities for config component (danger/evaluation method/recommendation) specific transfer"
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe contenant les utilitaires pour les tranferts spécifiques pour les composants de configurations (danger/méthode d'évaluation/préconnisation) / Class with all utilities for config component (danger/evaluation method/recommendation) specific transfer
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class TransferData_components_class extends singleton_util {

	/**
	 * Instanciation des outils pour les transferts spécifiques aux groupements et unités de travail / Instanciate groupements' and work unit specific transfer utilities
	 */
	protected function construct() { }

	/**
	 * Traitement du transfert pour les catégories de danger et les dangers / Treat the transfer for danger categories and dangers
	 *
	 * @param array $current_transfer_state L'état courant du transfert / The current state of transfer
	 *
	 * @return array L'état du transfert suite au transfert des catégories de dangers et des dangers / The state of transfert with the danger category and danger transfered
	 */
	function transfer_danger( $current_transfer_state ) {
		global $wpdb;

		$eva_danger_category_to_transfer = $eva_danger_category_transfered = 0;
		$eva_danger_to_transfer = $eva_danger_transfered = 0;

		$where = "id != 1";
		if ( isset( $current_transfer_state[ 'danger_category' ] ) ) {
			$current_state_transformed = $current_transfer_state[ 'danger_category' ];
			if ( array_key_exists( 'state', $current_state_transformed ) ) {
				unset( $current_state_transformed[ 'state' ] );
			}
			if ( !empty( $current_state_transformed ) ) {
				$where .= " AND id NOT IN (" . implode( ",", $current_state_transformed ) . ") ";
			}
		}
		$eva_danger_categories = $wpdb->get_results( "SELECT * FROM " . TABLE_CATEGORIE_DANGER . " WHERE " . $where . " ORDER BY id ASC" );
		if ( !empty( $eva_danger_categories ) ) {
			$eva_danger_category_to_transfer += count( $eva_danger_categories );
			foreach ( $eva_danger_categories as $eva_danger_category ) {
				/**	Définition de la structure d'une catégorie de danger / Define the danger category structure		*/
				$wp_danger_category_definition = array(
					'id' => null,
					'type' => category_danger_class::g()->get_taxonomy(),
					'term_taxonomy_id' => null,
					'name' => html_entity_decode( $eva_danger_category->nom, ENT_QUOTES, 'UTF-8' ),
					'description' => $eva_danger_category->description,
					'slug' => null,
					'parent_id' => null,
					'status' => ( 'Valid' == $eva_danger_category->Status ) ? 'valid' : 'deleted',
					'unique_key' => $eva_danger_category->id,
					'unique_identifier' => ELEMENT_IDENTIFIER_CD . $eva_danger_category->id,
					'position' => $eva_danger_category->position,
					'thumbnail_id' => null,
					'associated_document_id' => null,
				);

				$wp_danger_category = category_danger_class::g()->create( $wp_danger_category_definition );

				/**	Enregistrement des données complémentaires pour les catégories de danger et création des danger pour la catégorie / Save complementary datas for danger categories and create danger of category	*/
				if ( !empty( $wp_danger_category->id ) ) {
					$term_associated_files = TransferData_common_class::g()->transfert_picture_linked_to_element( TABLE_CATEGORIE_DANGER, $eva_danger_category->id );
					$wp_danger_category->associated_document_id = $term_associated_files[ 'associated_list' ];
					$wp_danger_category->thumbnail_id = $term_associated_files[ '_thumbnail' ];
					$wp_danger_category = category_danger_class::g()->update( $wp_danger_category );

					$current_transfer_state[ 'danger_category' ][] = $eva_danger_category->id;
					$eva_danger_category_transfered++;
					/**	Log	*/
					log_class::g()->exec( 'digirisk-datas-tranfert-danger-category', '', sprintf( __( 'Danger category %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_danger_category->nom, $wp_danger_category->id), array( 'object_id' => $eva_danger_category->id, ), 0 );

					/**	Save old information about transfered element	*/
					add_term_meta( $wp_danger_category->id, '_wpdigi_element_computed_identifier', TABLE_CATEGORIE_DANGER . '#value_sep#' . $eva_danger_category->id, true );
					add_term_meta( $wp_danger_category->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_CATEGORIE_DANGER, serialize( $eva_danger_category ) ) ), true );

					/**	Treat danger of current category	*/
					$query = $wpdb->prepare( "SELECT * FROM " . TABLE_DANGER . " WHERE id_categorie = %d ORDER BY nom ASC", $eva_danger_category->id );
					$eva_dangers = $wpdb->get_results( $query );
					if ( !empty( $eva_dangers ) ) {
						$eva_danger_to_transfer += count( $eva_dangers );
						foreach ( $eva_dangers as $eva_danger ) {
							/**	Définition de la structure d'un danger / Define the danger structure		*/
							$wp_danger_definition = array(
								'id' 								=> null,
								'type' 							=> category_danger_class::g()->get_taxonomy(),
								'term_taxonomy_id' 	=> null,
								'name' 							=> html_entity_decode( $eva_danger->nom, ENT_QUOTES, 'UTF-8' ),
								'description' 			=> $eva_danger->description,
								'slug' 							=> null,
								'parent_id'	 				=> $wp_danger_category->id,
								'post_id'	 					=> null,
								'status' 							=> ( 'Valid' == $eva_danger->Status ) ? 'valid' : 'deleted',
								'unique_key' 					=> $eva_danger->id,
								'unique_identifier' 	=> ELEMENT_IDENTIFIER_D . $eva_danger->id,
								'default_method' 			=> $eva_danger->methode_eva_defaut,
								'default_of_category' => ( !empty( $options ) && is_array( $options ) && in_array( 'default', $options ) ? true : false ),
								'is_annoying' 				=> ( !empty( $options ) && is_array( $options ) && in_array( 'penibilite', $options ) ? true : false ),
								'thumbnail_id' 				=> $term_associated_files[ '_thumbnail' ],
							);
							$wp_danger = danger_class::g()->create( $wp_danger_definition );

							/**	Enregistrement des données complémentaires pour les catégories de danger et création des danger pour la catégorie / Save complementary datas for danger categories and create danger of category	*/
							if ( !empty( $wp_danger->id ) ) {
								$current_transfer_state[ 'danger' ][] = $eva_danger->id;
								$eva_danger_transfered++;
								/**	Log	*/
								log_class::g()->exec( 'digirisk-datas-tranfert-danger', '', sprintf( __( 'Danger %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_danger->nom, $eva_danger->id), array( 'object_id' => $eva_danger->id, ), 0 );

								/**	Save old information about transfered element	*/
								add_term_meta( $wp_danger->id, '_wpdigi_element_computed_identifier', TABLE_DANGER . '#value_sep#' . $eva_danger->id, true );
								add_term_meta( $wp_danger->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_DANGER, serialize( $eva_danger ) ) ), true );
							}
							else {
								log_class::g()->exec( 'digirisk-datas-tranfert-danger', '', sprintf( __( 'Error transferring danger %s from evarisk to taxonomy. Error: %s', 'wp-digi-dtrans-i18n' ), $eva_danger->nom, json_encode( $wp_danger ) ), array( 'object_id' => $eva_danger_category->id, ), 2 );
							}
						}
					}

				}
				else {
					log_class::g()->exec( 'digirisk-datas-tranfert-danger-category', '', sprintf( __( 'Error transferring danger category %s from evarisk to taxonomy. Error: %s', 'wp-digi-dtrans-i18n' ), $eva_danger_category->nom, json_encode( $wp_danger_category ) ), array( 'object_id' => $eva_danger_category->id, ), 2 );
				}
			}
		}

		$current_transfer_state[ 'danger' ][ 'state' ] = 'complete';
		if ( $eva_danger_to_transfer > $eva_danger_transfered ) {
			$current_transfer_state[ 'danger' ][ 'state' ] = 'in_progress';
		}

		$current_transfer_state[ 'danger_category' ][ 'state' ] = 'complete';
		if ( $eva_danger_category_to_transfer > $eva_danger_category_transfered ) {
			$current_transfer_state[ 'danger_category' ][ 'state' ] = 'in_progress';
		}

		return $current_transfer_state;
	}

	/**
	 * Traitement du transfert pour les méthodes d'évaluation et des composants des méthodes / Treat the transfer for evaluation method and method components
	 *
	 * @param array $current_transfer_state L'état courant du transfert/ The current state of transfer
	 *
	 * @return array L'état du transfert suite au transfert des méthodes et variables / The state of transfert with the methods and vars
	 */
	function transfer_evaluation_method( $current_transfer_state ) {
		global $wpdb;
		$eva_method_to_transfer = $eva_method_transfered = 0;
		$eva_vars_to_transfer = $eva_vars_transfered = 0;

		/**	Treat evaluation method vars before method in order to recreate method formula	*/
		$eva_vars = $wpdb->get_results( "SELECT * FROM " . TABLE_VARIABLE . " WHERE 1 ORDER BY id ASC" );
		if ( !empty( $eva_vars ) ) {
			$eva_vars_to_transfer += count( $eva_vars );
			foreach ( $eva_vars as $eva_var ) {
				/**	Définition de la structure d'une catégorie de danger / Define the danger category structure		*/
				$wp_evaluation_method_var_definition = array(
					'id' => null,
					'type' => evaluation_method_variable_class::g()->get_taxonomy(),
					'term_taxonomy_id' => null,
					'name' => html_entity_decode( $eva_var->nom ),
					'description' => html_entity_decode( $eva_var->annotation ),
					'unique_key' => $eva_var->id,
					'unique_identifier' => ELEMENT_IDENTIFIER_ME . $eva_var->id,
					'display_type' => $eva_var->affichageVar,
					'range' => array( $eva_var->min, $eva_var->max ),
					'survey' => array( 'title' => $eva_var->questionTitre, 'request' => unserialize( $eva_var->questionVar ) ),
				);

				if ( 'slide' == $eva_var->affichageVar && !empty( $eva_var->annotation ) ) {
					$details = explode( "\n", $eva_var->annotation );
					if ( !empty( $details ) ) {

						if ( 4 == count( $details ) ) {
							$wp_evaluation_method_var_definition['survey']['request'][] = array(
								'question' => null,
								'seuil' => null,
							);
						}

						foreach ( $details as $detail ) {
							if ( ! empty( $detail ) ) {
								$sub_detail = explode( ' : ', $detail );
								if ( 2 == count( $sub_detail ) ) {
									$wp_evaluation_method_var_definition['survey']['request'][] = array(
										'question' => html_entity_decode( $sub_detail[1] ),
										'seuil' => $sub_detail[0],
									);
								} else {
									$wp_evaluation_method_var_definition['survey']['request'][] = array(
										'question' => $detail,
										'seuil' => 1,
									);
								}
							}
						}
					}
				}
				$wp_var = evaluation_method_variable_class::g()->create( $wp_evaluation_method_var_definition );

				if ( !empty( $wp_var->id ) ) {
					$current_transfer_state[ 'evaluation_method_var' ][] = $eva_var->id;
					$eva_vars_transfered++;
					/**	Log creation	*/
					log_class::g()->exec( 'digirisk-datas-transfert-evaluation-vars', '', sprintf( __( 'Evaluation method variable %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_var->nom, $wp_var->id ), array( 'object_id' => $eva_var->id, ), 0 );

					/**	Save old information about transfered element	*/
					add_term_meta( $wp_var->id, '_wpdigi_element_computed_identifier', TABLE_VARIABLE . '#value_sep#' . $eva_var->id, true );
					add_term_meta( $wp_var->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_VARIABLE, serialize( $eva_var ) ) ), true );
				} else {
					log_class::g()->exec( 'digirisk-datas-transfert-evaluation-vars', '', sprintf( __( 'Error transferring evaluation method variable %s from evarisk to taxonomy. error: %s', 'wp-digi-dtrans-i18n' ), $eva_var->nom, json_encode( $wp_var ) ), array( 'object_id' => $eva_var->id, ), 2 );
				}
			}
		}

		/**	Transfer evaluation method	*/
		$t = TABLE_METHODE;
		$eva_methods = $wpdb->get_results( "SELECT * FROM {$t} WHERE 1 ORDER BY id ASC");
		if ( !empty( $eva_methods ) ) {
			$eva_method_to_transfer += count( $eva_methods );
			foreach ( $eva_methods as $eva_method ) {

				/**	Transfer method formula	*/
				$ordered_vars = array();
				$query = $wpdb->prepare( "SELECT *
			FROM " . TABLE_VARIABLE . ", " . TABLE_AVOIR_VARIABLE . " t1
			WHERE t1.id_methode = %d
			AND t1.date < %s
			AND NOT EXISTS(
				SELECT *
				FROM " . TABLE_AVOIR_VARIABLE . " t2
				WHERE t2.id_methode = %d
				AND t2.date < %s
				AND t1.date < t2.date
			)
			AND id_variable=id
			ORDER BY ordre ASC", (int)$eva_method->id, current_time('mysql', 0), (int)$eva_method->id, current_time('mysql', 0) );
				$vars_of_method = $wpdb->get_results( $query );
				foreach ( $vars_of_method as $var_of_method ) {
					$ordered_vars[ $var_of_method->ordre - 1 ] = $var_of_method->id;
				}
				$ordered_operators = array();

				$date = current_time('mysql', 0);
				$id_methode = (int)$eva_method->id;
				$query = $wpdb->prepare("SELECT *
				FROM " . TABLE_AVOIR_OPERATEUR . " t1
				WHERE t1.id_methode = %d
					AND t1.date < %s
	        AND t1.Status = 'Valid'
					AND NOT EXISTS
					(
						SELECT *
						FROM " . TABLE_AVOIR_OPERATEUR . " t2
						WHERE t2.id_methode = %d
						AND t2.date < %s
						AND t1.date < t2.date
					)
				ORDER BY ordre ASC", $id_methode, $date, $id_methode, $date );
				$operators_of_method = $wpdb->get_results($query);
				foreach ( $operators_of_method as $operator_of_method ) {
					$ordered_operators[ $operator_of_method->ordre - 1 ] = $operator_of_method->operateur;
				}
				$final_new_formula = array();
				foreach ( $ordered_vars as $index => $ordered_var ) {
					$query = $wpdb->prepare(
							"SELECT T.term_id
							FROM {$wpdb->terms} AS T
							INNER JOIN {$wpdb->termmeta} AS TM ON ( TM.term_id = T.term_id )
							WHERE TM.meta_key = %s AND TM.meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_VARIABLE . '#value_sep#' . $ordered_var
					);
					$final_new_formula[] = $wpdb->get_var( $query );
					if ( end( $ordered_vars ) != $ordered_var ) {
						$final_new_formula[] = $ordered_operators[ $index ];
					}
				}

				/**	Do treatment for method scale equivalence	*/
				$method_result = array();
				$query = $wpdb->prepare(
					"SELECT *
					FROM " . TABLE_EQUIVALENCE_ETALON . " AS EM
					WHERE id_methode = %d", $eva_method->id
				);
				$method_matrix = $wpdb->get_results( $query );
				foreach ( $method_matrix as $matrix ) {
					$method_result[ $matrix->valeurMaxMethode ] = $matrix->id_valeur_etalon;
				}

				/**	Définition de la structure d'une catégorie de danger / Define the danger category structure		*/
				$wp_evaluation_method_definition = array(
						'id' => null,
						'type' => evaluation_method_class::g()->get_taxonomy(),
						'term_taxonomy_id' => null,
						'name' => html_entity_decode( $eva_method->nom, ENT_QUOTES, 'UTF-8' ),
						'description' => null,
						'unique_key' => $eva_method->id,
						'unique_identifier' => ELEMENT_IDENTIFIER_ME . $eva_method->id,
						'is_default' => ( 'yes' == $eva_method->default_methode ? true : false ),
						'formula' => $final_new_formula,
						'matrix' => $method_result,
						'thumbnail_id' => null,
						'associated_document_id' => null,
				);
				$wp_evaluation_method = evaluation_method_class::g()->create( $wp_evaluation_method_definition );

				if ( !is_wp_error( $wp_evaluation_method ) ) {
					$term_associated_files = TransferData_common_class::g()->transfert_picture_linked_to_element( TABLE_METHODE, $eva_method->id );
					$wp_evaluation_method->associated_document_id = $term_associated_files[ 'associated_list' ];
					$wp_evaluation_method->thumbnail_id = $term_associated_files[ '_thumbnail' ];
					evaluation_method_class::g()->update( $wp_evaluation_method );

					$current_transfer_state[ 'evaluation_method' ][] = $eva_method->id;
					$eva_method_transfered++;
					/**	Log creation	*/
					log_class::g()->exec( 'digirisk-datas-transfert-evaluation-method', '', sprintf( __( 'Evaluation method %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_method->nom, $wp_evaluation_method->id ), array( 'object_id' => $eva_method->id, ), 0 );

					/**	Save old information about transfered element	*/
					add_term_meta( $wp_evaluation_method->id, '_wpdigi_element_computed_identifier', TABLE_METHODE . '#value_sep#' . $eva_method->id, true );
					add_term_meta( $wp_evaluation_method->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_METHODE, serialize( $eva_method ) ) ), true );
				}
				else {
					log_class::g()->exec( 'digirisk-datas-transfert-evaluation-method', '', sprintf( __( 'Error transferring evaluation method %s from evarisk to taxonomy. ERROR: %s', 'wp-digi-dtrans-i18n' ), $eva_method->nom, json_encode( $wp_evaluation_method ) ), array( 'object_id' => $eva_method->id, ), 2 );
				}
			}
		}

		if ( $eva_vars_to_transfer > $eva_vars_transfered ) {
			$current_transfer_state[ 'evaluation_method_var' ][ 'state' ] = 'in_progress';
		}
		else {
			$current_transfer_state[ 'evaluation_method_var' ][ 'state' ] = 'complete';
		}

		if ( $eva_method_to_transfer > $eva_method_transfered ) {
			$current_transfer_state[ 'evaluation_method' ][ 'state' ] = 'in_progress';
		}
		else {
			$current_transfer_state[ 'evaluation_method' ][ 'state' ] = 'complete';
		}

		return $current_transfer_state;
	}

	/**
	 * Traitement du transfert pour les préconnisations / Treat the transfer for recommendation
	 *
	 * @param array $current_transfer_state L'état courant du transfert / The current state of transfer
	 *
	 * @return array L'état du transfert suite au transfert des catégories de préconisations et les préconisations / The state of transfert with recommendations' categories and recommendations
	 */
	function transfer_recommendation( $current_transfer_state ) {
		global $wpdb;

		$eva_recommendation_category_to_transfer = $eva_recommendation_category_transfered = 0;
		$eva_recommendation_to_transfer = $eva_recommendation_transfered = 0;

		$query = $wpdb->prepare(
				"SELECT RECOMMANDATION_CAT.*, PIC.photo
			FROM " . TABLE_CATEGORIE_PRECONISATION . " AS RECOMMANDATION_CAT
				LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION_CAT.id) AND (tableElement = '" . TABLE_CATEGORIE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes'))
				LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto))
			WHERE RECOMMANDATION_CAT.status = %s
				GROUP BY RECOMMANDATION_CAT.id", 'valid');
		$eva_recommendation_categories = $wpdb->get_results( $query );
		if ( !empty( $eva_recommendation_categories ) ) {
			$eva_recommendation_category_to_transfer += count( $eva_recommendation_categories );
			foreach ( $eva_recommendation_categories as $eva_recommendation_category ) {
				/**	Définition de la structure d'une catégorie de préconisation / Define the recommendation category structure		*/
				$wp_recommendation_category_definition = array(
					'id' => null,
					'type' => recommendation_category_term_class::g()->get_taxonomy(),
					'term_taxonomy_id' => null,
					'name' => html_entity_decode( $eva_recommendation_category->nom, ENT_QUOTES, 'UTF-8' ),
					'description' => null,
					'unique_key' => $eva_recommendation_category->id,
					'unique_identifier' => ELEMENT_IDENTIFIER_CP . $eva_recommendation_category->id,
					'thumbnail_id' => null,
					'associated_document_id' => null,
					'recommendation_category_print_option' => array(
						'type'	=> $eva_recommendation_category->impressionRecommandationCategorie,
						'size'	=> $eva_recommendation_category->tailleimpressionRecommandationCategorie,
					),
					'recommendation_print_option' => array(
						'type'	=> $eva_recommendation_category->impressionRecommandation,
						'size'	=> $eva_recommendation_category->tailleimpressionRecommandation,
					),
				);
				$wp_category_recommendation = recommendation_category_term_class::g()->create( $wp_recommendation_category_definition );

				if ( !empty( $wp_category_recommendation->id ) ) {
					$term_associated_files = TransferData_common_class::g()->transfert_picture_linked_to_element( TABLE_CATEGORIE_PRECONISATION, $eva_recommendation_category->id, $wp_category_recommendation->id );
					$wp_category_recommendation->associated_document_id = $term_associated_files[ 'associated_list' ];
					$wp_category_recommendation->thumbnail_id = $term_associated_files[ '_thumbnail' ];
					recommendation_category_term_class::g()->update( $wp_category_recommendation );

					$current_transfer_state[ 'recommendation_category' ][] = $eva_recommendation_category->id;
					$eva_recommendation_category_transfered++;
					/**	Log creation	*/
					log_class::g()->exec( 'digirisk-datas-transfert-recommendation-category', '', sprintf( __( 'Recommendation category %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_recommendation_category->nom, $wp_category_recommendation->id ), array( 'object_id' => $eva_recommendation_category->id, ), 0 );

					/**	Save old information about transfered element	*/
					add_term_meta( $wp_category_recommendation->id, '_wpdigi_element_computed_identifier', TABLE_CATEGORIE_PRECONISATION . '#value_sep#' . $eva_recommendation_category->id, true );
					add_term_meta( $wp_category_recommendation->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_CATEGORIE_PRECONISATION, serialize( $eva_recommendation_category ) ) ), true );

					/**	Treat recommendation of current category	*/
					$query = $wpdb->prepare(
							"SELECT RECOMMANDATION.*, PIC.photo
			FROM " . TABLE_PRECONISATION . " AS RECOMMANDATION
				LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION.id) AND (tableElement = '" . TABLE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes') AND (LINK_ELT_PIC.status = 'valid'))
				LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto) AND (PIC.status = 'valid'))
			WHERE RECOMMANDATION.status = 'valid'
				AND RECOMMANDATION.id_categorie_preconisation = %d", $eva_recommendation_category->id );
					$eva_recommendations = $wpdb->get_results( $query );
					if ( !empty( $eva_recommendations ) ) {
						$eva_recommendation_category_to_transfer += count( $eva_recommendations );
						foreach ( $eva_recommendations as $eva_recommendation ) {
							/**	Définition de la structure d'une préconisation / Define the recommendation's structure		*/
							$wp_recommendation_definition = array(
								'id' => null,
								'type' => recommendation_term_class::g()->get_taxonomy(),
								'term_taxonomy_id' => null,
								'name' => html_entity_decode( $eva_recommendation->nom, ENT_QUOTES, 'UTF-8' ),
								'description' => $eva_recommendation->description,
								'parent_id' => $wp_category_recommendation->id,
								'unique_key' => $eva_recommendation->id,
								'unique_identifier' => ELEMENT_IDENTIFIER_P . $eva_recommendation->id,
								'type' => $eva_recommendation->preconisation_type,
							);
							$wp_recommendation = recommendation_term_class::g()->create( $wp_recommendation_definition );

							if ( !empty( $wp_recommendation->id ) ) {
								$term_associated_files = TransferData_common_class::g()->transfert_picture_linked_to_element( TABLE_PRECONISATION, $eva_recommendation->id, $wp_recommendation->id );
								$wp_recommendation->associated_document_id = $term_associated_files[ 'associated_list' ];
								$wp_recommendation->thumbnail_id = $term_associated_files[ '_thumbnail' ];
								recommendation_term_class::g()->update( $wp_recommendation );

								$current_transfer_state[ 'recommendation' ][] = $eva_recommendation->id;
								$eva_recommendation_category_transfered++;

								/**	Log creation	*/
								log_class::g()->exec( 'digirisk-datas-transfert-recommendation', '', sprintf( __( 'Recommendation %s transfered from evarisk on taxonomy having id. %d', 'wp-digi-dtrans-i18n' ), $eva_recommendation->nom, $wp_recommendation->id ), array( 'object_id' => $eva_recommendation->id, ), 0 );

								/**	Save old information about transfered element	*/
								add_term_meta( $wp_recommendation->id, '_wpdigi_element_computed_identifier', TABLE_PRECONISATION . '#value_sep#' . $eva_recommendation->id, true );
								add_term_meta( $wp_recommendation->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_PRECONISATION, serialize( $eva_recommendation ) ) ), true );
							}
							else {
								/**	Log creation	*/
								log_class::g()->exec( 'digirisk-datas-transfert-recommendation', '', sprintf( __( 'Error while transferring recommendation %s from Evarisk to taxonomy. Error: %s', 'wp-digi-dtrans-i18n' ), $eva_recommendation->nom, $wp_recommendation ), array( 'object_id' => $eva_recommendation->id, ), 2 );
							}
						}
					}
				}
				else {
					log_class::g()->exec( 'digirisk-datas-transfert-recommendation-category', '', sprintf( __( 'Error transferring recommendation category from evarisk to taxonomy. Error: %s', 'wp-digi-dtrans-i18n' ), $eva_recommendation_category->nom, $wp_category_recommendation ), array( 'object_id' => $eva_recommendation_category->id, ), 2 );
				}
			}
		}

		$current_transfer_state[ 'recommendation_category' ][ 'state' ] = 'complete';
		if ( $eva_recommendation_category_to_transfer > $eva_recommendation_category_transfered ) {
			$current_transfer_state[ 'recommendation_category' ][ 'state' ] = 'in_progress';
		}

		$current_transfer_state[ 'recommendation' ][ 'state' ] = 'complete';
		if ( $eva_recommendation_to_transfer > $eva_recommendation_transfered ) {
			$current_transfer_state[ 'recommendation' ][ 'state' ] = 'in_progress';
		}

		return $current_transfer_state;
	}

	/**
	 * Traitement du transfert pour les modèles de documents utilisés pour les générations / Treat the transfer for documents' model used for final document generation
	 *
	 * @param array $current_transfer_state L'état courant du transfert / The current state of transfer
	 *
	 * @return array L'état du transfert suite au transfert des modèles de documents / The state of transfert with documents' transfer
	 */
	function transfer_document_model( $current_transfer_state ) {
		global $wpdb;

		$query = $wpdb->prepare(
			"SELECT *, null as meta
			FROM " . TABLE_GED_DOCUMENTS . "
			WHERE table_element = %s", 'all'
		);
		$model_list = $wpdb->get_results( $query );

		$model_list_transfered = 0;
		foreach ( $model_list as $model ) {
			$model->meta[ 0 ] = new \stdClass();
			$model->meta[ 0 ]->meta_key = 'is_default';
			$model->meta[ 0 ]->meta_value = $model->parDefaut;

			$model_id = TransferData_common_class::g()->transfer_document( $model, 0, 'document' );
			if ( is_int( $model_id ) ) {
				$model_list_transfered++;
				wp_set_object_terms( $model_id, array( 'model', $model->categorie ), 'attachment_category' );
			}
			else {
				log_class::g()->exec( 'digirisk-datas-transfert-model', '', sprintf( __( 'Error transferring model named %s from evarisk to wordpress media under id. %d', 'wp-digi-dtrans-i18n' ), $model->nom, $model_id ), array( 'object_id' => $model->id, ), 2 );
			}
		}

		$current_transfer_state[ 'document_model' ][ 'state' ] = 'complete';
		if ( count( $model_list ) > $model_list_transfered ) {
			$current_transfer_state[ 'document_model' ][ 'state' ] = 'in_progress';
		}

		return $current_transfer_state;
	}

	/**
	 * [display_component_transfer_bloc description]
	 *
	 * @return boolean If the core components have been transfered into the new storage way
	 */
	function display_component_transfer_bloc() {
		global $wpdb;

		/**	Set the config components transfert state	*/
		$main_config_components_are_transfered = true;

		$digirisk_current_transfer_state = get_option( '_wpdigirisk-dtransfert', array() );

		/**	Get Danger	*/
		$eva_danger_to_transfer = $eva_danger_transfered = 0;
		$where = "id != 1";
		$eva_danger_categories = $wpdb->get_results( "SELECT * FROM " . TABLE_CATEGORIE_DANGER . " WHERE " . $where . " ORDER BY id ASC" );
		if ( !empty( $eva_danger_categories ) ) :
			$eva_danger_to_transfer += count( $eva_danger_categories );
			foreach ( $eva_danger_categories as $eva_danger_category ) :
				$query = $wpdb->prepare( "SELECT * FROM " . TABLE_DANGER . " WHERE id_categorie = %d ORDER BY nom ASC", $eva_danger_category->id );
				$eva_dangers = $wpdb->get_results( $query );
				$eva_danger_to_transfer += count( $eva_dangers );
			endforeach;
		endif;
		if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'danger' ] ) ) {
			$eva_danger_transfered += count( $digirisk_current_transfer_state[ 'danger' ] ) - 1;
		}
		if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'danger_category' ] ) ) {
			$eva_danger_transfered += count( $digirisk_current_transfer_state[ 'danger_category' ] ) - 1;
		}
		if ( $eva_danger_to_transfer > $eva_danger_transfered ) {
			$main_config_components_are_transfered = false;
		}

		/**	Get Evalation method	*/
		$method_to_transfer = $method_transfered = 0;
		$t = TABLE_METHODE;
		$methods = $wpdb->get_results( "SELECT * FROM {$t} WHERE 1 ORDER BY id ASC");
		if ( !empty( $methods ) ) :
			$method_to_transfer += count( $methods );
		endif;
		if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'evaluation_method' ] ) ) {
			$method_transfered += count( $digirisk_current_transfer_state[ 'evaluation_method' ] ) - 1;
		}
		if ( $method_to_transfer > $method_transfered ) {
			$main_config_components_are_transfered = false;
		}

		/**	Get Recommendation	*/
		$recommendation_to_transfer = $recommendation_transfered = 0;
		$query = $wpdb->prepare(
				"SELECT RECOMMANDATION_CAT.*, PIC.photo
				FROM " . TABLE_CATEGORIE_PRECONISATION . " AS RECOMMANDATION_CAT
					LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION_CAT.id) AND (tableElement = '" . TABLE_CATEGORIE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes'))
					LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto))
				WHERE RECOMMANDATION_CAT.status = %s
					GROUP BY RECOMMANDATION_CAT.id", 'valid');
		$recommendation_categories = $wpdb->get_results( $query );
		if ( !empty( $recommendation_categories ) ) :
			$recommendation_to_transfer += count( $recommendation_categories );
			foreach ( $recommendation_categories as $recommendation_category ) :
				$query = $wpdb->prepare(
						"SELECT RECOMMANDATION.*, PIC.photo
					FROM " . TABLE_PRECONISATION . " AS RECOMMANDATION
						LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION.id) AND (tableElement = '" . TABLE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes') AND (LINK_ELT_PIC.status = 'valid'))
						LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto) AND (PIC.status = 'valid'))
					WHERE RECOMMANDATION.status = 'valid'
						AND RECOMMANDATION.id_categorie_preconisation = %d", $recommendation_category->id );
				$recommendations = $wpdb->get_results( $query );
				$recommendation_to_transfer += count( $recommendations );
			endforeach;
		endif;
		if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'recommendation' ] ) ) {
			$recommendation_transfered += count( $digirisk_current_transfer_state[ 'recommendation' ] ) - 1;
		}
		if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'recommendation_category' ] ) ) {
			$recommendation_transfered += count( $digirisk_current_transfer_state[ 'recommendation_category' ] ) - 1;
		}
		if ( $recommendation_to_transfer > $recommendation_transfered ) {
			$main_config_components_are_transfered = false;
		}

		view_util::exec( 'transfer_data', 'transfert-components', array(
			'main_config_components_are_transfered'		=> $main_config_components_are_transfered,
			'eva_danger_to_transfer'									=> $eva_danger_to_transfer,
			'eva_danger_transfered'										=> $eva_danger_transfered,
			'method_to_transfer'											=> $method_to_transfer,
			'method_transfered'												=> $method_transfered,
			'recommendation_to_transfer'							=> $recommendation_to_transfer,
			'recommendation_transfered'								=> $recommendation_transfered,
		) );

		return $main_config_components_are_transfered;
	}

	/**
	 * Launch transfer for config components
	 *
	 * @return array The response of componentns transfer
	 */
	public function launch_transfer() {
		check_ajax_referer( 'wpdigi-datas-transfert' );
		global $wpdb;

		$response = array(
			'status'						=> false,
			'reload_transfert'	=> true,
			'message'						=> __( 'A required parameter is missing, please check your request and try again', 'wp-digi-dtrans-i18n' ),
		);
		$element_type = ! empty( $_POST['element_type_to_transfert'] ) && in_array( $_POST['element_type_to_transfert'] , TransferData_class::g()->element_type ) ? sanitize_text_field( $_POST['element_type_to_transfert'] ): '';
		$sub_action = ! empty( $_POST['sub_action'] ) && in_array( $_POST['sub_action'] , array( 'element', 'doc', 'config_components' ) ) ? sanitize_text_field( wp_unslash( $_POST['sub_action'] ) ) : 'element'; // input var okay.

		/**	Get option with already transfered element	*/
		$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
		$response['element_nb_treated'] = 0;
		$response['element_type'] = $element_type;
		$response['sub_element_type'] = '';
		$response['sub_action'] = $sub_action;

		/**	Set the config components transfert state	*/
		$main_config_components_are_transfered = true;

		/**	Start danger transfer	*/
		if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options['danger'] ) || ( ! empty( $digirisk_transfert_options['danger'] ) && ! empty( $digirisk_transfert_options['danger']['state'] ) && ( 'complete' != $digirisk_transfert_options['danger']['state'] ) ) ) {
			$eva_danger_tranfer_result = TransferData_components_class::g()->transfer_danger( $digirisk_transfert_options );
			$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_danger_tranfer_result );

			if ( ! empty( $digirisk_transfert_options['danger_category'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['danger_category'] ) - 1 );
				if ( ! empty( $digirisk_transfert_options['danger_category']['state'] ) && ( 'complete' != $digirisk_transfert_options['danger_category']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
			if ( ! empty( $digirisk_transfert_options['danger'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['danger'] ) - 1 );

				if ( ! empty( $digirisk_transfert_options['danger']['state'] ) && ( 'complete' != $digirisk_transfert_options['danger']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
		}

		/**	Get Evalation method	*/
		if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options['evaluation_method'] ) || ( ! empty( $digirisk_transfert_options['evaluation_method'] ) && ! empty( $digirisk_transfert_options['evaluation_method']['state'] ) && ( 'complete' != $digirisk_transfert_options['evaluation_method']['state'] ) ) ) {
			$eva_evaluation_method_tranfer_result = TransferData_components_class::g()->transfer_evaluation_method( $digirisk_transfert_options );
			$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_evaluation_method_tranfer_result );

			if ( ! empty( $digirisk_transfert_options['evaluation_method_var'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['evaluation_method_var'] ) - 1 );
				if ( ! empty( $digirisk_transfert_options['evaluation_method_var']['state'] ) && ( 'complete' != $digirisk_transfert_options['evaluation_method_var']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
			if ( ! empty( $digirisk_transfert_options['evaluation_method'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['evaluation_method'] ) - 1 );
				if ( ! empty( $digirisk_transfert_options['evaluation_method']['state'] ) && ( 'complete' != $digirisk_transfert_options['evaluation_method']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
		}

		/**	Get Recommendation	*/
		if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options['recommendation'] ) || ( ! empty( $digirisk_transfert_options['recommendation'] ) && ! empty( $digirisk_transfert_options['recommendation']['state'] ) && ( 'complete' != $digirisk_transfert_options['recommendation']['state'] ) ) ) {
			$eva_recommendation_tranfer_result = TransferData_components_class::g()->transfer_recommendation( $digirisk_transfert_options );
			$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_recommendation_tranfer_result );

			if ( ! empty( $digirisk_transfert_options['recommendation_category'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['recommendation_category'] ) - 1 );
				if ( ! empty( $digirisk_transfert_options['recommendation_category']['state'] ) && ( 'complete' != $digirisk_transfert_options['recommendation_category']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
			if ( ! empty( $digirisk_transfert_options['recommendation'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['recommendation'] ) - 1 );

				if ( ! empty( $digirisk_transfert_options['recommendation']['state'] ) && ( 'complete' != $digirisk_transfert_options['recommendation']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
		}

		/**	Get Document model	*/
		if ( false && empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options['document_model'] ) || ( ! empty( $digirisk_transfert_options['document_model'] ) && ! empty( $digirisk_transfert_options['document_model']['state'] ) && ( 'complete' != $digirisk_transfert_options['document_model']['state'] ) ) ) {
			$eva_models_tranfer_result = TransferData_components_class::g()->transfer_document_model( $digirisk_transfert_options );
			$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_models_tranfer_result );

			if ( ! empty( $digirisk_transfert_options['document_model'] ) ) {
				$response['element_nb_treated'] += ( count( $digirisk_transfert_options['document_model'] ) - 1 );
				if ( ! empty( $digirisk_transfert_options['document_model']['state'] ) && ( 'complete' != $digirisk_transfert_options['document_model']['state'] ) ) {
					$main_config_components_are_transfered = false;
				}
			}
		}

		/**	Save the transfert state	*/
		update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );

		/**	Return a specific response if components transfer are all done	*/
		if ( $main_config_components_are_transfered ) {
			$transfer_response = array(
				'sub_action'	=> 'element',
				'message'			=> __( 'Tous les composants de configuration ont été transférés', 'digirisk' ),
			);
		}

		$transfer_response['old_sub_action'] = $sub_action;

		evaluation_method_default_data_class::g()->create( array( 'evarisk' ) );

		/**	Build an output for component box	*/
		ob_start();
		TransferData_components_class::g()->display_component_transfer_bloc();
		$transfer_response['display_components_transfer'] = ob_get_contents();
		ob_end_clean();

		$response = wp_parse_args( $transfer_response, $response );
		wp_die( json_encode( $response ) );
	}

}

TransferData_components_class::g();
