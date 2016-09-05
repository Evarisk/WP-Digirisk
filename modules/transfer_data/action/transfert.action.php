<?php

namespace digi\transfert;

if ( !defined( 'ABSPATH' ) ) exit;

class transfert_action {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	public function __construct() {
		/**	Launch transfer for elements	*/
		add_action( 'wp_ajax_wpdigi-datas-transfert', array( $this, 'launch_transfer' ), 150 );
	}

	function launch_transfer() {
		global $wpdb;

		$response = array (
			'status'				=> false,
			'reload_transfert'		=> false,
			'message'				=> __( 'A required parameter is missing, please check your request and try again', 'wp-digi-dtrans-i18n' ),
		);
		$element_type = !empty( $_POST[ 'element_type_to_transfert' ] ) && in_array( $_POST[ 'element_type_to_transfert' ] , TransferData_class::g()->element_type ) ? sanitize_text_field( $_POST[ 'element_type_to_transfert' ] ): '';
		$sub_action = !empty( $_POST[ 'sub_action' ] ) && in_array( $_POST[ 'sub_action' ] , array( 'element', 'doc', 'config_components') ) ? sanitize_text_field( $_POST[ 'sub_action' ] ) : 'element';

		/**	Launch transfer for current element direct children of subtype	*/
		switch( $element_type ) {
			case TABLE_TACHE:
				$sub_element_type = TABLE_ACTIVITE;
				break;
			case TABLE_GROUPEMENT:
				$sub_element_type = TABLE_UNITE_TRAVAIL;
				break;
		}
		$response[ 'element_type' ] = $element_type;
		$response[ 'sub_element_type' ] = $sub_element_type;

		if ( !empty( $element_type ) ) {
			/**	Define default message and transfer reload state	*/
			$response[ 'reload_transfert' ] = true;
			$response[ 'message' ] = __( 'Import will automatically continue while all elements won\'t be transfered into database', 'wp-digi-dtrans-i18n' );

			if ( 'config_components' != $sub_action ) {
				/**	Get transfert statistics */
				$transfer_progression = TransferData_class::g()->get_transfer_progression( $element_type, $sub_element_type );

				$nb_element_to_transfert = $transfer_progression[ 'to_transfer' ];
				$nb_main_element_transfered = !empty( $transfer_progression[ 'transfered' ][ $element_type ] ) ? count( $transfer_progression[ 'transfered' ][ $element_type ] ) : 0;
				$nb_sub_element_transfered = !empty( $transfer_progression[ 'transfered' ][ $sub_element_type ] ) ? count( $transfer_progression[ 'transfered' ][ $sub_element_type ] ) : 0;
				$nb_doc_element_transfered = 0;
				$nb_doc_element_transfered += !empty( $transfer_progression[ 'transfered' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'picture' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'picture' ][ 'ok' ] ) ? count( $transfer_progression[ 'transfered' ][ 'picture' ][ 'ok' ] ) : 0;
				$nb_doc_element_transfered += !empty( $transfer_progression[ 'transfered' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'document' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'document' ][ 'ok' ] ) ? count( $transfer_progression[ 'transfered' ][ 'document' ][ 'ok' ] ) : 0;
				$nb_doc_element_not_transfered = 0;
				$nb_doc_element_not_transfered += !empty( $transfer_progression[ 'transfered' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'picture' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'picture' ][ 'nok' ] ) ? count( $transfer_progression[ 'transfered' ][ 'picture' ][ 'nok' ] ) : 0;
				$nb_doc_element_not_transfered += !empty( $transfer_progression[ 'transfered' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'document' ] ) && !empty( $transfer_progression[ 'transfered' ][ 'document' ][ 'nok' ] ) ? count( $transfer_progression[ 'transfered' ][ 'document' ][ 'nok' ] ) : 0;

				$element_done = $document_done = false;
				if ( ( $nb_main_element_transfered + $nb_sub_element_transfered ) == ( $nb_element_to_transfert->main_element_nb + $nb_element_to_transfert->sub_element_nb ) ) {
					$element_done = true;
				}
				if ( ( $nb_doc_element_transfered + $nb_doc_element_not_transfered ) == ( $nb_element_to_transfert->nb_document + $nb_element_to_transfert->nb_picture ) ) {
					$document_done = true;
				}

				if ( $element_done && $document_done ) {
					$response[ 'status' ] = true;
					$response[ 'reload_transfert' ] = false;
					$response[ 'redirect_to_url' ] = admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' );
					$response[ 'message' ] = __( 'All elements have been transfered to new storage way into wordpress database. Please wait a minute we are redirecting you to digirisk main interface', 'wp-digi-dtrans-i18n' );

					/**	Mise à jour de l'identifiant unique de l'association des préconisations /	Update unique identifier of recommendation association */
					$query =
						"SELECT MAX( id )
						FROM " . TABLE_LIAISON_PRECONISATION_ELEMENT;
					update_option( \recommendation_class::g()->last_affectation_index_key, $wpdb->get_var( $query ) );

					/** Définition des modèles de documents / Define document model to use */
					\document_class::g()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/document_unique.odt', 'document_unique' );
					\document_class::g()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/fiche_de_poste.odt', 'fiche_de_poste' );

					/**	Enregistrement de la fin du transfert dans la base de données / Save transfer end into database */
					$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
					$digirisk_transfert_options[ 'state' ] = 'complete';
					update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );

					// Met à jour l'option pour dire que l'installation est terminée
					update_option( WPDIGI_CORE_OPTION_NAME, array( 'installed' => true, 'db_version' => 1 ) );
				}
				else if ( $element_done ) {
					$sub_action = 'doc';

					/** First step ( element transfer ) is complete */
					$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
					$digirisk_transfert_options[ 'state' ] = 'first_step_complete';
					update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );
				}
			}

			$response[ 'sub_action' ] = $sub_action;
			switch ( $sub_action ) {
				case 'config_components':
					/**	Get option with already transfered element	*/
					$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
					$response[ 'element_nb_treated'] = 0;

					/**	Set the config components transfert state	*/
					$main_config_components_are_transfered = true;

					/**	Start danger transfer	*/
					if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options[ 'danger' ] ) || ( !empty( $digirisk_transfert_options[ 'danger' ] ) && !empty( $digirisk_transfert_options[ 'danger' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'danger' ][ 'state' ] ) ) ) {
						$eva_danger_tranfer_result = TransferData_components_class::g()->transfer_danger( $digirisk_transfert_options );
						$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_danger_tranfer_result );

						if ( !empty( $digirisk_transfert_options[ 'danger_category' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'danger_category' ] ) - 1 );
							if ( !empty( $digirisk_transfert_options[ 'danger_category' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'danger_category' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
						if ( !empty( $digirisk_transfert_options[ 'danger' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'danger' ] ) - 1 );

							if ( !empty( $digirisk_transfert_options[ 'danger' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'danger' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
					}

					/**	Get Evalation method	*/
					if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options[ 'evaluation_method' ] ) || ( !empty( $digirisk_transfert_options[ 'evaluation_method' ] ) && !empty( $digirisk_transfert_options[ 'evaluation_method' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'evaluation_method' ][ 'state' ] ) ) ) {
						$eva_evaluation_method_tranfer_result = TransferData_components_class::g()->transfer_evaluation_method( $digirisk_transfert_options );
						$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_evaluation_method_tranfer_result );

						if ( !empty( $digirisk_transfert_options[ 'evaluation_method_var' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'evaluation_method_var' ] ) - 1 );
							if ( !empty( $digirisk_transfert_options[ 'evaluation_method_var' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'evaluation_method_var' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
						if ( !empty( $digirisk_transfert_options[ 'evaluation_method' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'evaluation_method' ] ) - 1 );
							if ( !empty( $digirisk_transfert_options[ 'evaluation_method' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'evaluation_method' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
					}

					/**	Get Recommendation	*/
					if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options[ 'recommendation' ] ) || ( !empty( $digirisk_transfert_options[ 'recommendation' ] ) && !empty( $digirisk_transfert_options[ 'recommendation' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'recommendation' ][ 'state' ] ) ) ) {
						$eva_recommendation_tranfer_result = TransferData_components_class::g()->transfer_recommendation( $digirisk_transfert_options );
						$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_recommendation_tranfer_result );

						if ( !empty( $digirisk_transfert_options[ 'recommendation_category' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'recommendation_category' ] ) - 1 );
							if ( !empty( $digirisk_transfert_options[ 'recommendation_category' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'recommendation_category' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
						if ( !empty( $digirisk_transfert_options[ 'recommendation' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'recommendation' ] ) - 1 );

							if ( !empty( $digirisk_transfert_options[ 'recommendation' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'recommendation' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
					}

					/**	Get Document model	*/
					if ( empty( $digirisk_transfert_options ) || empty( $digirisk_transfert_options[ 'document_model' ] ) || ( !empty( $digirisk_transfert_options[ 'document_model' ] ) && !empty( $digirisk_transfert_options[ 'document_model' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'document_model' ][ 'state' ] ) ) ) {
						$eva_models_tranfer_result = TransferData_components_class::g()->transfer_document_model( $digirisk_transfert_options );
						$digirisk_transfert_options = array_merge( $digirisk_transfert_options, $eva_models_tranfer_result );

						if ( !empty( $digirisk_transfert_options[ 'document_model' ] ) ) {
							$response[ 'element_nb_treated' ] += ( count( $digirisk_transfert_options[ 'document_model' ] ) - 1 );
							if ( !empty( $digirisk_transfert_options[ 'document_model' ][ 'state' ] ) && ( 'complete' != $digirisk_transfert_options[ 'document_model' ][ 'state' ] ) ) {
								$main_config_components_are_transfered = false;
							}
						}
					}

					/**	Save the transfert state	*/
					update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );

					/**	Return a specific response if components transfer are all done	*/
					if ( $main_config_components_are_transfered ) {
						$transfer_response = array(
							'sub_action' => 'element',
						);
					}

					$transfer_response[ 'old_sub_action' ] = $sub_action;

					\evaluation_method_default_data_class::g()->create();

					/**	Build an output for component box	*/
					ob_start();
					require( \wpdigi_utils::get_template_part( DIGI_DTRANS_DIR, DIGI_DTRANS_TEMPLATES_MAIN_DIR, "backend", "transfert", "components" ) );
					$transfer_response[ 'display_components_transfer' ] = ob_get_contents();
					ob_end_clean();

					break;
				case 'element':
					$transfer_response = $this->element_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, wp_parse_args( $transfer_progression[ 'transfered' ], array( $element_type => array(), $sub_element_type => array(), ) ) );
					break;
				case 'doc':
					$transfer_response = $this->document_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, wp_parse_args( $transfer_progression[ 'transfered' ], array( 'document' => array( 'ok' => array(), 'nok' => array(), ), 'picture' => array( 'ok' => array(), 'nok' => array(), ), ) ) );
					break;
			}
		}

		$response = wp_parse_args( $transfer_response, $response );
		wp_die( json_encode( $response ) );
	}

		function element_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, $transfered_element ) {
			global $wpdb;
			$main_element_transfered = $sub_element_transfered = 0;
			$response[ 'element_nb_treated'] = 0;

			/**	Build a response for displaying transfer state and progression	*/
			$response[ 'main_element_nb' ] = count( $transfered_element[ $element_type ] );
			$response[ 'sub_element_nb' ] = count( $transfered_element[ $sub_element_type ] );

			/**	Instanciate common datas transfer utilities	*/

			if ( count( $transfered_element[ $element_type ] ) < $nb_element_to_transfert->main_element_nb ) {
				/**	Check if current element type has a root element in order to exclude it from datas transfert	*/
				$root_element = $wpdb->get_row( "SELECT * FROM {$element_type} table1 WHERE NOT EXISTS( SELECT * FROM {$element_type} table2 WHERE table2.limiteGauche < table1.limiteGauche )");
				/**	Retrieve elements to store into database	*/
				$query = "SELECT *
					FROM {$element_type} AS table1
					WHERE 1
						AND table1.limiteGauche > " . $root_element->limiteGauche . "
						AND table1.limiteDroite < " . $root_element->limiteDroite . "
						AND NOT EXISTS (
							SELECT *
							FROM {$element_type} AS table2
							WHERE 1
								AND table2.limiteGauche > " . $root_element->limiteGauche . "
								AND table2.limiteDroite < " . $root_element->limiteDroite . "
								AND table1.limiteGauche > table2.limiteGauche
								AND table1.limiteDroite < table2.limiteDroite
						)
					ORDER BY limiteGauche ASC";
				$first_level_elements = $wpdb->get_results($query);

				foreach ( $first_level_elements as $element ) {
					if ( !empty( $element ) ) {
						$new_element_id = TransferData_common_class::g()->transfer( $element_type, $element );
						if ( !is_wp_error( $new_element_id ) ) {
							$response[ 'element_nb_treated' ] += 1;
						}
					}
				}

				/**	Create the element that are orphelan due to errors during moving in old tree - Main element	*/
				$response[ 'main_element_nb' ] += $response[ 'element_nb_treated' ];
			}
			else if ( count( $transfered_element[ $sub_element_type ] ) < $nb_element_to_transfert->sub_element_nb ) {
				/**	Start the query buiding	*/
				$query = "SELECT * FROM " . $sub_element_type . " WHERE 1";

				/**	Check if there are already element of current types that have been transferd in order to exclude them of query	*/
				$transfered_element = get_option( '_wpdigirisk-dtransfert', array() );
				if ( !empty( $transfered_element ) && !empty( $transfered_element[ $sub_element_type ] ) && is_array( $transfered_element[ $sub_element_type ] ) ) {
					$query .= " AND id NOT IN ('" . implode( "', '", $transfered_element[ $sub_element_type ] ) . "')";
				}

				$query .= " LIMIT 0, " . $_POST[ 'number_per_page' ];

				/**	Get current element sub type	*/
				$children = $wpdb->get_results( $query );
				if ( !empty( $children ) ) {
					foreach ( $children as $child ) {
						switch ( $element_type ) {
							case TABLE_TACHE:
								$field_for_parent = 'id_tache';
								break;

							case TABLE_GROUPEMENT:
								$field_for_parent = 'id_groupement';
								break;
						}
						/**	Get the current element parent identifier into the new system	*/
						$query = $wpdb->prepare( "
							SELECT post_id
							FROM {$wpdb->postmeta}
							WHERE ( meta_value = %s AND meta_key = %s )", $element_type . '#value_sep#' . $child->$field_for_parent, '_wpdigi_element_computed_identifier' );
						$element_parent_id = $wpdb->get_var( $query );

						/**	Launch transfert for element subtype	*/
						$new_children_id = TransferData_common_class::g()->transfer( $sub_element_type, $child, $element_parent_id );
						if ( !is_wp_error( $new_children_id ) ) {
							$response[ 'element_nb_treated' ]++;
						}
					}
				}

				$response[ 'sub_element_nb' ] += $response[ 'element_nb_treated' ];
			}

			return $response;
		}

		function document_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, $transfered_element ) {
			global $wpdb;
			$all_heavy_element_done = false;
			$response[ 'element_nb_treated' ] = 0;
			$response[ 'transfered' ] = 0;
			$response[ 'not_transfered' ] = 0;

			/** Picture treatment */
			$where = "";
			$pictures_to_check = array();
			if ( !empty( $transfered_element[ 'picture' ][ 'ok' ] ) && is_array( $transfered_element[ 'picture' ][ 'ok' ] ) ) {
				$pictures_to_check = array_merge( $pictures_to_check, $transfered_element[ 'picture' ][ 'ok' ] );
				$response[ 'transfered'] += count( $transfered_element[ 'picture' ][ 'ok' ] );
			}
			if ( !empty( $transfered_element[ 'picture' ][ 'nok' ] ) && is_array( $transfered_element[ 'picture' ][ 'nok' ] ) ) {
				/**	For not ok picture, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element[ 'picture' ][ 'nok' ] as $picture_id => $picture_path ) {
					$pictures_to_check[] = $picture_id;
				}
				$response[ 'not_transfered'] += count( $transfered_element[ 'picture' ][ 'nok' ] );
			}
			if ( !empty( $pictures_to_check ) ) {
				$where .= "AND PICTURE.id NOT IN ( '" . implode( "', '", $pictures_to_check ) . "' )";
			}
			$pics_are_done = true;
			$query =
				"SELECT PICTURE.*, PICTURE_LINK.isMainPicture, PICTURE_LINK.idElement, PICTURE_LINK.tableElement
				FROM " . TABLE_PHOTO . " AS PICTURE
					INNER JOIN " . TABLE_PHOTO_LIAISON . " AS PICTURE_LINK ON (PICTURE_LINK.idPhoto = PICTURE.id)
				WHERE PICTURE_LINK.tableElement IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY PICTURE.id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE / 2 );
			$pictures = $wpdb->get_results($query);
			if ( !empty( $pictures ) ) {
				foreach ( $pictures as $picture ) {
					$query = $wpdb->prepare(
						"SELECT P.ID
						FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
						WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
						array( '_wpdigi_element_computed_identifier', $picture->tableElement . "#value_sep#" . $picture->idElement )
					);
					$new_element_id = $wpdb->get_var( $query );

					$document_id = TransferData_common_class::g()->transfer_document( $picture, $new_element_id, 'picture' );
					if ( ( null !== $document_id ) && !is_wp_error( $document_id ) ) {

						$response[ 'transfered']++;

						/**	Association des images aux différents éléments / Associate picture to elements	*/
						switch ( $picture->tableElement ) {
							case TABLE_UNITE_TRAVAIL:
									$elt = \workunit_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'image' ][] = $document_id;
									\workunit_class::g()->update( $elt );
								break;
							case TABLE_GROUPEMENT:
									$elt = \group_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'image' ][] = $document_id;
									\group_class::g()->update( $elt );
								break;
							case TABLE_TACHE:

								break;
							case TABLE_ACTIVITE:

								break;
						}

						/**	Certaines images nécessite un traitement spécifique / Do specific treatment for pictures	*/
						/**	Affectation de l'image a un risque / Associate picture to a risk	*/
						$query = $wpdb->prepare(
							"SELECT idElement
							FROM " . TABLE_PHOTO_LIAISON . "
							WHERE idPhoto = %d
								AND tableElement = %s", $picture->id, TABLE_RISQUE
						);
						$picture_to_risk_association = $wpdb->get_var( $query );
						if ( !empty( $picture_to_risk_association ) ) {
							$query = $wpdb->prepare(
								"SELECT P.ID
								FROM {$wpdb->posts} AS P
									INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
								WHERE PMID.meta_key = %s
									AND PMID.meta_value = %s",
								array( '_wpdigi_element_computed_identifier', TABLE_RISQUE . "#value_sep#" . $picture_to_risk_association )
							);
							$new_risk_id = $wpdb->get_var( $query );
							set_post_thumbnail( $new_risk_id, $document_id );
						}

						/**	Get the element created for new data transfer	*/
						$doc_model = \document_class::g()->show( $document_id );

						/**	Build the model for new data storage */
						$meta = array(
							'unique_key' 						=> $picture->id,
							'unique_identifier'			=> ELEMENT_IDENTIFIER_PIC . $picture->id,
							'model_id' 							=> null,
							// 'revision'							=> null,
						);
						$doc_model->option = array_replace_recursive( $doc_model->option, $meta);
						\document_class::g()->update( $doc_model );
					}
					else {
						$response[ 'not_transfered']++;
					}
					$response[ 'element_nb_treated' ]++;
				}
				$pics_are_done = false;
			}

			/**
			 *	Documents treatment
			 */
			$where = "";
			$documents_to_check = array();
			if ( !empty( $transfered_element[ 'document' ][ 'ok' ] ) && is_array( $transfered_element[ 'document' ][ 'ok' ] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element[ 'document' ][ 'ok' ] );
				$response[ 'transfered'] += count( $transfered_element[ 'document' ][ 'ok' ] );
			}
			if ( !empty( $transfered_element[ 'document' ][ 'nok' ] ) && is_array( $transfered_element[ 'document' ][ 'nok' ] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element[ 'document' ][ 'nok' ] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response[ 'not_transfered'] += count( $transfered_element[ 'document' ][ 'nok' ] );
			}
			if ( !empty( $documents_to_check ) ) {
				$where .= "AND DOCUMENT.id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$docs_are_done = true;
			$query =
				"SELECT *
				FROM " . TABLE_GED_DOCUMENTS . " AS DOCUMENT
				WHERE table_element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE / 2 );
			$documents = $wpdb->get_results($query);
			if ( !empty( $documents ) ) {
				foreach ( $documents as $document ) {
					$query = $wpdb->prepare(
						"SELECT P.ID
						FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
						WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
						array( '_wpdigi_element_computed_identifier', $document->table_element . "#value_sep#" . $document->id_element )
					);
					$new_element_id = $wpdb->get_var( $query );

					$query = $wpdb->prepare(
						"SELECT meta_key, meta_value
						FROM " . TABLE_GED_DOCUMENTS_META . "
						WHERE document_id = %d", $document->id
					);
					$document->meta = $wpdb->get_results( $query );
					$current_meta_index = count( $document->meta );
					$default_meta_index = $current_meta_index + 1;
					$document->meta[ $default_meta_index ] = new \stdClass();
					$document->meta[ $default_meta_index ]->meta_key = 'is_default';
					$document->meta[ $default_meta_index ]->meta_value = $document->parDefaut;

					$document_id = TransferData_common_class::g()->transfer_document( $document, $new_element_id, 'document' );
					if ( ( null !== $document_id ) && !is_wp_error( $document_id ) ) {
						$response[ 'transfered' ]++;

						$term_to_associate = array();
						$term_to_associate[] = $document->categorie;
						if ( 'uploads/modeles/' == substr( $document->chemin, 0, 16 ) ) {
							$term_to_associate[] = 'model';
						}
						else {
							$term_to_associate[] = 'printed';
						}
						wp_set_object_terms( $document_id, $term_to_associate, 'attachment_category' );

						/**	Association des images aux différents éléments / Associate picture to elements	*/
						switch ( $document->table_element ) {
							case TABLE_UNITE_TRAVAIL:
								$elt = \workunit_class::g()->show( $new_element_id );
								$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
								\workunit_class::g()->update( $elt );
							break;

							case TABLE_GROUPEMENT:
								$elt = \group_class::g()->show( $new_element_id );
								$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
								\group_class::g()->update( $elt );
							break;

							case TABLE_TACHE:
							break;

							case TABLE_ACTIVITE:
							break;
						}

						/**	Get the element created for new data transfer	*/
						$doc_model = \document_class::g()->show( $document_id );

						/**	Build the model for new data storage */
						$meta = array(
							'unique_key' 						=> $document->id,
							'unique_identifier'			=> ELEMENT_IDENTIFIER_DOC . $document->id,
							'model_id' 							=> null,
							// 'revision'							=> null,
						);
						$doc_model->option = array_replace_recursive( $doc_model->option, $meta);
						\document_class::g()->update( $doc_model );

					}
					else {
						$response[ 'not_transfered' ]++;
					}
					$response[ 'element_nb_treated' ]++;
				}
				$docs_are_done = false;
			}

			/**	Printed document treatment */
			$where = "";
			$documents_to_check = array();
			if ( !empty( $transfered_element[ 'printed_duer' ][ 'ok' ] ) && is_array( $transfered_element[ 'printed_duer' ][ 'ok' ] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element[ 'printed_duer' ][ 'ok' ] );
				$response[ 'transfered'] += count( $transfered_element[ 'printed_duer' ][ 'ok' ] );
			}
			if ( !empty( $transfered_element[ 'printed_duer' ][ 'nok' ] ) && is_array( $transfered_element[ 'printed_duer' ][ 'nok' ] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element[ 'printed_duer' ][ 'nok' ] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response[ 'not_transfered'] += count( $transfered_element[ 'printed_duer' ][ 'nok' ] );
			}
			if ( !empty( $documents_to_check ) ) {
				$where .= "AND id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$query =
				"SELECT *, element AS table_element, elementID as id_element, 'printed_fiche_action' as categorie, CONCAT( 'documentUnique/', element, '/', elementId, '/', nomDUER, '_V', revisionDUER, '.odt' ) as chemin, null as nom, null as idCreateur, dateGenerationDUER as dateCreation
				FROM " . TABLE_DUER . "
				WHERE element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE / 2 );
			$duers = $wpdb->get_results($query);
			if ( !empty( $duers ) ) {
				foreach ( $duers as $duer ) {
					$query = $wpdb->prepare(
							"SELECT P.ID
							FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
							WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
							array( '_wpdigi_element_computed_identifier', $duer->element . "#value_sep#" . $duer->elementId )
					);
					$new_element_id = $wpdb->get_var( $query );

					$document_id = TransferData_common_class::g()->transfer_document( $duer, $new_element_id, 'printed_duer' );
					if ( ( null !== $document_id ) && !is_wp_error( $document_id ) ) {
							$response[ 'transfered' ]++;
							wp_set_object_terms( $document_id, array( 'document_unique', 'printed' ), 'attachment_category' );

							/**	Association des images aux différents éléments / Associate picture to elements	*/
							switch ( $duer->table_element ) {
								case TABLE_UNITE_TRAVAIL:
									$elt = \workunit_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
									\workunit_class::g()->update( $elt );
									break;
								case TABLE_GROUPEMENT:
									$elt = \group_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
									\group_class::g()->update( $elt );
									break;
								case TABLE_TACHE:

									break;
								case TABLE_ACTIVITE:

									break;
							}

							/**	Get the element created for new data transfer	*/
							$doc_model = \document_class::g()->show( $document_id );

							/**	Build the model for new data storage */
							$meta = array(
								'unique_key' 						=> $duer->id,
								'unique_identifier'			=> ELEMENT_IDENTIFIER_DOC . $duer->id,
								'model_id' 							=> $duer->id_model,
								// 'revision'							=> $duer->revisionDUER,
							);
							$doc_model->option = array_replace_recursive( $doc_model->option, $meta);
							\document_class::g()->update( $doc_model );
					}
					else {
							$response[ 'not_transfered' ]++;
					}
					$response[ 'element_nb_treated' ]++;
				}
			}

			/**	Printed document treatment */
			$where = "";
			$documents_to_check = array();
			if ( !empty( $transfered_element[ 'printed_sheet' ][ 'ok' ] ) && is_array( $transfered_element[ 'printed_sheet' ][ 'ok' ] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element[ 'printed_sheet' ][ 'ok' ] );
				$response[ 'transfered'] += count( $transfered_element[ 'printed_sheet' ][ 'ok' ] );
			}
			if ( !empty( $transfered_element[ 'printed_sheet' ][ 'nok' ] ) && is_array( $transfered_element[ 'printed_sheet' ][ 'nok' ] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element[ 'printed_sheet' ][ 'nok' ] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response[ 'not_transfered'] += count( $transfered_element[ 'printed_sheet' ][ 'nok' ] );
			}
			if ( !empty( $documents_to_check ) ) {
				$where .= "AND id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$query =
				"SELECT *, 'printed_fiche_action' as categorie, CONCAT( 'directory_to_change_later/', table_element, '/', id_element, '/', name, '_V', revision, '.odt' ) as chemin, '' as nom, null as status, null as idCreateur, creation_date as dateCreation
				FROM " . TABLE_FP . "
				WHERE table_element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE / 2 );
			$sheets = $wpdb->get_results($query);
			if ( !empty( $sheets ) ) {
				foreach ( $sheets as $sheet ) {
					$query = $wpdb->prepare(
							"SELECT P.ID
							FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
							WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
							array( '_wpdigi_element_computed_identifier', $sheet->table_element . "#value_sep#" . $sheet->id_element )
					);
					$new_element_id = $wpdb->get_var( $query );

					switch ( $sheet->document_type ) {
						case 'fiche_de_groupement':
							$directory_to_use = 'ficheDeGroupement';
							break;
						case 'fiche_de_poste':
							$directory_to_use = 'ficheDePoste';
							break;
						case 'listing_des_risques':
							$directory_to_use = 'listingRisque';
							break;
						case 'fiche_exposition_penibilite':
							$directory_to_use = 'ficheDeRisques';
							break;
						case 'user_global_export':
							$directory_to_use = ELEMENT_IDENTIFIER_GUE;
							break;
					}
					$sheet->chemin = str_replace( 'directory_to_change_later', $directory_to_use, $sheet->chemin );

					$document_id = TransferData_common_class::g()->transfer_document( $sheet, $new_element_id, 'printed_sheet' );
					if ( ( null !== $document_id ) && !is_wp_error( $document_id ) ) {
							$response[ 'transfered' ]++;

							wp_set_object_terms( $document_id, array( $sheet->document_type, 'printed' ), 'attachment_category' );

							/**	Association des images aux différents éléments / Associate picture to elements	*/
							switch ( $sheet->table_element ) {
								case TABLE_UNITE_TRAVAIL:
									$elt = \workunit_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
									\workunit_class::g()->update( $elt );
									break;
								case TABLE_GROUPEMENT:
									$elt = \group_class::g()->show( $new_element_id );
									$elt->option[ 'associated_document_id' ][ 'document' ][] = $document_id;
									\group_class::g()->update( $elt );
									break;
								case TABLE_TACHE:

									break;
								case TABLE_ACTIVITE:

									break;
							}

							/**	Get the element created for new data transfer	*/
							$doc_model = \document_class::g()->show( $document_id );

							/**	Build the model for new data storage */
							$meta = array(
									'unique_key' 						=> $sheet->id,
									'unique_identifier'			=> ELEMENT_IDENTIFIER_DOC . $sheet->id,
									'model_id' 							=> $sheet->id_model,
									// 'revision'							=> $sheet->revision,
							);
							$doc_model->option = array_replace_recursive( $doc_model->option, $meta);
							\document_class::g()->update( $doc_model );
					}
					else {
							$response[ 'not_transfered' ]++;
					}
					$response[ 'element_nb_treated' ]++;
				}
			}


			/**	In case all pictures and documents have been treated	*/
			if ( $pics_are_done && $docs_are_done ) {
				$response[ 'reload_transfert' ] = false;
			}

			return $response;
		}

	}

new transfert_action();
