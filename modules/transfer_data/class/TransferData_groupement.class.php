<?php
namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant les utilitaires pour les tranferts spécifiques pour les groupements et unités de travail / File with all utilities for work groups and work unit specific transfer
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe contenant les utilitaires pour les tranferts spécifiques pour les groupement / Class with all utilities for work groups' and work units' specific transfer
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_transferdata_society_class extends singleton_util {

	/**
	 * Instanciation des outils pour les transferts spécifiques aux groupements et unités de travail / Instanciate groupements' and work unit specific transfer utilities
	 */
	protected function construct() { }

	/**
	 * Transfert the group form evarisk database to wordpress database
	 *
	 * @param  WP_Object $groupement The complete definition of group from evarisk old database
	 *
	 * @return Object                The new group into Digirisk wordpress database
	 */
	public function transfert_groupement( $groupement ) {
		$group_mdl = array(
			'date'							=> ( '0000-00-00 00:00:00' !== $groupement->creation_date_of_society ? $groupement->creation_date_of_society : current_time( 'mysql' ) ),
			'date_modified'			=> ( '0000-00-00 00:00:00' !== $groupement->lastupdate_date ? $groupement->lastupdate_date : current_time( 'mysql' ) ),
			'title'							=> $groupement->nom,
			'content'						=> $groupement->description,
			'status'						=> ( 'Valid' === $groupement->Status ? 'publish' : ( 'Deleted' === $groupement->Status ? 'trash' : 'draft' ) ),
			'user_info'					=> array(
				'owner_id'								=> $groupement->id_responsable,
				'affected_id' 						=> $this->transfer_users( $groupement->id, TABLE_GROUPEMENT, null, group_class::g()->get_post_type() ),
			),
			'identity'					=> array(
				'workforce'								=> $groupement->effectif,
				'siren'										=> $groupement->siren,
				'siret'										=> $groupement->siret,
				'social_activity_number'	=> $groupement->social_activity_number,
				'establishment_date'			=> $groupement->creation_date_of_society,
			),

			'unique_key'				=> $groupement->id,
			'unique_identifier'	=> ELEMENT_IDENTIFIER_GP . $groupement->id,

			'associated_product'	=> $this->transfer_product( $groupement->id, TABLE_GROUPEMENT ),
		);

		$new_group = group_class::g()->update( $group_mdl );
		if ( ! empty( $new_group ) && ! empty( $new_group->id ) ) {
			/**	Log creation	*/
			log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_GROUPEMENT, '', sprintf( __( 'Transfered from evarisk on post having id. %d', 'wp-digi-dtrans-i18n' ), $new_group->id ), array( 'object_id' => $groupement->id, 'error' => $new_group, 'object' => $group_mdl ), 0 );

			/**
			 * Transfert element associated risk
			 */
			$this->transfer_risk( $groupement->id, TABLE_GROUPEMENT, $new_group->id );
			/**
			 * Transfert element associated recommendation
			 */
			$this->transfer_recommendation( $groupement->id, TABLE_GROUPEMENT, $new_group->id );

			/**	Store the other data into meta	*/
			update_post_meta( $new_group->id, '_wpdigi_element_computed_identifier', TABLE_GROUPEMENT . '#value_sep#' . $groupement->id );
			update_post_meta( $new_group->id, '_wpdigi_element_old_definition', wp_json_encode( array( TABLE_GROUPEMENT, serialize( $groupement ) ) ) );
		} else {
			/**	Log creation	*/
			log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_GROUPEMENT, '', __( 'An error occured while transfering the element to wordpress', 'wp-digi-dtrans-i18n' ), array( 'object_id' => $groupement->id, 'error' => $new_group, 'object' => $group_mdl ), 2 );
		}

		return $new_group;
	}

	/**
	 * Traitement du transfert des unités de travail / Treat the transfer for  work units
	 *
	 * @param integer $element Identifiant de l'élément pour lequel il faut effectuer le transfert / Element identifier for which we have to transfer datas into new storage way
	 * @param string $element_type Le type de l'élément pour lequel il faut récupèrer les commentaires et notes / Element type we had to get comment and notes for
	 * @param integer $wp_element_id Identifiant de l'élément transféré auquel sont associés les éléments / Transfered element identifier to which we have to associate transfered element
	 *
	 * @author Evarisk development team <dev@evarisk.com>
	 * @version 6.0
	 */
	function transfer_unite( $element, $element_type, $wp_element_id ) {

		/**	Get the element created for new data transfer	*/
		$workunit_mdl = workunit_class::g()->get( array( 'include' => array( $wp_element_id ), 'post_status' => 'all', ) );
		$workunit_mdl = $workunit_mdl[0];

		/**	Build the	group model for new data storage */
		$workunit_mdl->unique_key = $element->id;
		$workunit_mdl->unique_identifier = ELEMENT_IDENTIFIER_UT . $element->id;
		$workunit_mdl->associated_document_id = null;
		$workunit_mdl->user_info = array(
			'owner_id' => $element->id_responsable,
			'affected_id' => $this->transfer_users( $element->id, $element_type, null, workunit_class::g()->get_post_type() )
		);
		$workunit_mdl->contact = array(
			'phone' => array( $element->telephoneUnite, ),
			'address' => $this->transfer_addresse( $element->id_adresse, $wp_element_id )
		);

		$workunit_mdl->identity = array(
			'workforce' => $element->effectif,
		);

		$this->transfer_risk( $element->id, $element_type, $wp_element_id );
		$workunit_mdl->associated_product = $this->transfer_product( $element->id, $element_type, $wp_element_id );
		$this->transfer_recommendation( $element->id, $element_type, $wp_element_id );

		workunit_class::g()->update( $workunit_mdl );
	}

	/**
	 * Traitement du transfert des risques associés à un élément / Treat the transfer risk associated to an element
	 *
	 * @param integer $old_element_id Identifiant de l'élément pour lequel il faut effectuer le transfert / Element identifier for which we have to transfer datas into new storage way.
	 * @param string  $old_element_type Le type de l'élément pour lequel il faut récupèrer les commentaires et notes / Element type we had to get comment and notes for.
	 * @param integer $new_element_id Identifiant de l'élément transféré auquel sont associés les éléments / Transfered element identifier to which we have to associate transfered element.
	 *
	 * @author Evarisk development team <dev@evarisk.com>
	 * @version 6.0
	 */
	function transfer_risk( $old_element_id, $old_element_type, $new_element_id ) {
		global $wpdb;
		/**	Instanciate common datas transfer utilities	*/
		$risk_to_associate = array();

		$associated_risks = getRisques( $old_element_type, $old_element_id, 'all', '1', 'tableRisque.id ASC', "'Valid','Moderated','Deleted'" );
		if ( ! empty( $associated_risks ) ) {
			foreach ( $associated_risks as $associated_risk ) {
				$element_risks[ $associated_risk->id ][  $associated_risk->id_evaluation ][] = $associated_risk;
			}
		}

		if ( ! empty( $element_risks ) ) {
			foreach ( $element_risks as $old_risk_id => $old_risk_evaluation_list ) {

				$main_risk_infos = null;
				foreach ( $old_risk_evaluation_list as $old_risk_evaluation_id => $old_risk_evaluation ) {
					$main_risk_infos = $old_risk_evaluation[0];
				}

				/**	Définition de la valeur du statut dans le nouveau stockage / Define the risk new status value	*/
				switch ( $main_risk_infos->Status ) {
					case 'Moderated':
						$status = 'draft';
						break;
					case 'Deleted':
						$status = 'trash';
						break;
					default:
						$status = 'publish';
						break;
				}

				$danger = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . TABLE_DANGER . " WHERE Status = 'Valid' AND id = %d", (int) $main_risk_infos->id_danger ) );
				switch ( $old_element_type ) {
					case TABLE_GROUPEMENT :
						$old_element = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . TABLE_GROUPEMENT . " WHERE id = %d", (int) $old_element_id ) );
						$element_prefix = ELEMENT_IDENTIFIER_GP . $old_element_id;
					break;

					case TABLE_UNITE_TRAVAIL :
						$old_element = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . TABLE_UNITE_TRAVAIL . " WHERE id = %d", (int) $old_element_id ) );
						$element_prefix = ELEMENT_IDENTIFIER_UT . $old_element_id;
					break;
				}
				/**	Définition principale du risque / Define the main risk model	*/
				$risk_definition = array(
					'parent_id' 						=> $new_element_id,
					'author_id' 						=> $main_risk_infos->idEvaluateur,
					'date'									=> ( '0000-00-00 00:00:00' !== $main_risk_infos->unformatted_evaluation_date ? $main_risk_infos->unformatted_evaluation_date : current_time( 'mysql' ) ),
					'date_modified'					=> current_time( 'mysql', 0 ),
					'title'									=> sprintf( __( '%1$s for %3$s - %2$s', 'wp-digi-dtrans-i18n' ), $danger->nom, $old_element->nom, $element_prefix ),
					'slug'									=> null,
					'content'								=> null,
					'status'								=> $status,
					'link'									=> null,
					'type'									=> risk_class::g()->get_post_type(),
					'comment_status'				=> 'closed',
					'comment_count'					=> null,
					'current_evaluation_id'	=> 0,
					'unique_key' 						=> $old_risk_id,
					'unique_identifier' 		=> ELEMENT_IDENTIFIER_R . $old_risk_id,
					'risk_date' 						=> array(
						'start' => $main_risk_infos->dateDebutRisque,
						'end' 	=> $main_risk_infos->dateFinRisque,
					),
				);

				/**	Création du risque / Create the risk	*/
				$wp_risk = risk_class::g()->create( $risk_definition );
				if ( ! empty( $wp_risk->id ) ) {
					/**	Ajoute le risque à la liste pour affectation à l'éléments / Add the risk for element affectation	*/
					$risk_to_associate[] = $wp_risk->id;

					/** Transfert des recommendations */
					$this->transfer_recommendation( $old_risk_id, TABLE_RISQUE, $wp_risk->id );

					/**	Log creation	*/
					log_class::g()->exec( 'digirisk-datas-transfert-risk', '', sprintf( __( 'Risk have been successfully transfered to wordpress system id. %d', 'wp-digi-dtrans-i18n' ), $wp_risk->id ), array( 'object_id' => $old_risk_id, ), 0 );

					/**	Store the other data into meta	*/
					update_post_meta( $wp_risk->id, '_wpdigi_element_computed_identifier', TABLE_RISQUE . '#value_sep#' . $old_risk_id );
					update_post_meta( $wp_risk->id, '_wpdigi_element_old_definition', json_encode( array( TABLE_RISQUE, serialize( $old_risk_evaluation_list ) ) ) );

					/**	Définition de la catégorie de danger pour le risque selon les nouveaux rangements / Define the danger category for risk into new storage	*/
					$query = $wpdb->prepare( "
						SELECT term_id
						FROM {$wpdb->termmeta}
						WHERE meta_key = %s
							AND meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_CATEGORIE_DANGER . '#value_sep#' . $old_risk_evaluation[ 0 ]->idCategorie
					);
					$new_danger_category = $wpdb->get_row( $query );
					if ( ! empty( $new_danger_category ) && ! empty( $new_danger_category->term_id )  ) {
						$wp_risk->taxonomy['digi-danger-category'][] = (int) $new_danger_category->term_id;
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Danger category %1$s - %2$d have been associated to risk', 'wp-digi-dtrans-i18n' ), category_danger_class::g()->get_taxonomy(), (int) $new_danger_category->term_id ), array( 'object_id' => $wp_risk->id ), 0 );

						$danger_category_thumbnail = get_term_meta( $new_danger_category->term_id, '_thumbnail_id', true );
						if ( ! empty( $danger_category_thumbnail ) ) {
							set_post_thumbnail( $wp_risk->id, $danger_category_thumbnail );
						}
					} else {
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Danger category to associate have not been found. %d', 'wp-digi-dtrans-i18n' ), wp_json_encode( $new_danger_category ) ), array( 'object_id' => $wp_risk->id, 'error' => $wp_risk ), 2 );
					}

					$risk_associated_file = TransferData_common_class::g()->transfert_picture_linked_to_element( TABLE_RISQUE, $old_risk_id, $wp_risk->id );
					$wp_risk->associated_document_id['image'] = $risk_associated_file['associated_list'];
					if ( ! empty( $risk_associated_file ) && ! empty( $risk_associated_file['_thumbnail'] ) ) {
						$wp_risk->thumbnail_id = $risk_associated_file['_thumbnail'];
					}

					/**	Définition du danger pour le risque selon les nouveaux rangements / Define the danger for risk into new storage	*/
					$query = $wpdb->prepare( "
						SELECT term_id
						FROM {$wpdb->termmeta}
						WHERE meta_key = %s
							AND meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_DANGER . '#value_sep#' . $old_risk_evaluation[0]->id_danger
					);
					$new_danger_id = $wpdb->get_var( $query );
					if ( ! empty( $new_danger_id ) ) {
						$wp_risk->taxonomy['digi-danger'][] = (int) $new_danger_id;
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Danger %1$s - %2$d have been associated to risk', 'wp-digi-dtrans-i18n' ), danger_class::g()->get_taxonomy(), (int) $new_danger_id ), array( 'object_id' => $wp_risk->id ), 0 );
					} else {
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', __( 'Danger to associate have not been found.', 'wp-digi-dtrans-i18n' ), array( 'object_id' => $wp_risk->id ), 2 );
					}

					/**	Définition de la catégorie de danger pour le risque selon les nouveaux rangements / Define the danger category for risk into new storage	*/
					$query = $wpdb->prepare( "
						SELECT term_id
						FROM {$wpdb->termmeta}
						WHERE meta_key = %s
							AND meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_METHODE . '#value_sep#' . $old_risk_evaluation[ 0 ]->id_methode
					);
					$new_method_id = $wpdb->get_var( $query );
					if ( ! empty( $new_method_id ) ) {
						$wp_risk->taxonomy[ 'digi-method' ][] = (int)$new_method_id;
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Method %d have been associated to risk', 'wp-digi-dtrans-i18n' ), (int)$new_method_id ), array( 'object_id' => $wp_risk->id, ), 0 );
					} else {
						/**	Log creation	*/
						log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', __( 'Method to associate have not been found.', 'wp-digi-dtrans-i18n'), array( 'object_id' => $wp_risk->id, ), 2 );
					}

					/**	Création de chaque évaluation du risque / Create each risk evaluation	*/
					$wp_risk->current_evaluation_id = null;
					foreach ( $old_risk_evaluation_list as $old_risk_evaluation_id => $old_risk_evaluation ) {
						if ( ! empty( $old_risk_evaluation_id ) && ! empty( $old_risk_evaluation ) && ! empty( $old_risk_evaluation[ 0 ] ) ) {
							/**	Enregistrement de la cotation du risque / Save the risk quotation	*/
							unset( $status );
							switch ( $old_risk_evaluation[0]->evaluation_status ) {
								case 'Moderated':
									$status = -34071;
									break;
								case 'Deleted':
									$status = -34072;
									break;
								default:
									$status = -34070;
									break;
							}
							$evaluator = get_userdata( $old_risk_evaluation[0]->idEvaluateur );

							$risk_evaluation_definition = array(
								'post_id'								=> $wp_risk->id,
								'date'									=> $old_risk_evaluation[0]->date,
								'author_nicename'				=> ! empty( $evaluator ) && ! empty( $evaluator->display_name ) ? $evaluator->display_name : '',
								'author_email'					=> ! empty( $evaluator ) && ! empty( $evaluator->user_email ) ? $evaluator->user_email : '',
								'content'								=> null,
								'type'									=> risk_evaluation_class::g()->get_type(),
								'parent_id'							=> null,
								'user_id'								=> $old_risk_evaluation[0]->idEvaluateur,
								'author_id'							=> $old_risk_evaluation[0]->unformatted_evaluation_date,
								'status'								=> $status,
								'unique_key'						=> $old_risk_evaluation_id,
								'unique_identifier'			=> ELEMENT_IDENTIFIER_E . $old_risk_evaluation_id,
							);

							/**	Enregistrement des valeurs résultantes de la cotation / Save the different value resulting of risk quotation	*/
							$risk_score = getScoreRisque( $old_risk_evaluation_list[ $old_risk_evaluation_id ] );
							$risk_quotation = getEquivalenceEtalon( $old_risk_evaluation[0]->id_methode, $risk_score, $main_risk_infos->date );
							$risk_evaluation_definition['risk_level'] = array(
								'method_result' => $risk_score,
								'equivalence' 	=> $risk_quotation,
							);
							$risk_evaluation_definition['scale'] = getSeuil( $risk_quotation );

							/**	Enregistrement de la quotation du risque, du commentaire et du score / Save the risk level, the risk comment and the risk final score	*/
							foreach ( $old_risk_evaluation as $old_risk_definition ) {
								$query = $wpdb->prepare( "
										SELECT term_id
										FROM {$wpdb->termmeta}
										WHERE meta_key = %s
										AND meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_VARIABLE . '#value_sep#' . $old_risk_definition->id_variable
								);
								$risk_evaluation_definition['quotation_detail'][] = array(
									'variable_id' => $wpdb->get_var( $query ),
									'value'				=> $old_risk_definition->valeur,
								);
							}

							$wp_risk_evaluation = risk_evaluation_class::g()->create( $risk_evaluation_definition );
							if ( ! empty( $wp_risk_evaluation->id ) ) {
								$wp_risk->associated_evaluation[] = $wp_risk_evaluation->id;

								/**	Log creation	*/
								log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Evaluation %1$d have been associated to risk under %2$s', 'wp-digi-dtrans-i18n' ), (int) $risk_evaluation_definition['unique_key'], $wp_risk_evaluation->id ), array( 'object_id' => $wp_risk->id ), 0 );

								$query = $wpdb->prepare(
									"SELECT *
									FROM " . TABLE_ACTIVITE_SUIVI . "
									WHERE table_element = %s
										AND id_element = %d", TABLE_AVOIR_VALEUR, $old_risk_evaluation_id
								);
								$comment_list = $wpdb->get_results( $query );
								if ( ! empty( $comment_list ) ) {
									foreach ( $comment_list as $comment ) {
										$comment_author = get_userdata( $comment->id_user );
										switch ( $comment->status ) {
											case 'moderated':
												$status = -34071;
												break;
											case 'deleted':
												$status = -34072;
												break;
											default:
												$status = -34070;
												break;
										}
										$risk_comment_definition = array(
											'post_id'								=> $wp_risk->id,
											'date'									=> $comment->date_ajout,
											'author_nicename'				=> $comment_author->display_name,
											'author_email'					=> $comment_author->user_email,
											'content'								=> $comment->commentaire,
											'type'									=> risk_evaluation_comment_class::g()->get_type(),
											'parent_id'							=> $wp_risk_evaluation->id,
											'user_id'								=> $comment->id_user,
											'author_id'							=> $comment->id_user,
											'status'								=> $status,
											'unique_key'						=> $comment->id,
											'unique_identifier'			=> $comment->id,
											'export'								=> ( ! empty( $comment->export ) && ( 'yes' === $comment->export ) ? true : false ),
										);

										$wp_risk_evaluation_comment_class = risk_evaluation_comment_class::g()->create( $risk_comment_definition );
										if ( ! empty( $wp_risk_evaluation_comment_class->id ) ) {
											/**	Log creation	*/
											log_class::g()->exec( 'digirisk-datas-transfert-risk-association', '', sprintf( __( 'Evaluation comment %1$d have been associated to risk under %2$s', 'wp-digi-dtrans-i18n' ), (int) $comment->id, $wp_risk_evaluation_comment_class->id ), array( 'object_id' => $wp_risk->id ), 0 );
										}
									}
								}

								if ( 'Valid' === $old_risk_evaluation[0]->evaluation_status ) {
									$wp_risk->current_evaluation_id = $wp_risk_evaluation->id;
								}
							} else {
								/**	Log creation	*/
								log_class::g()->exec( 'digirisk-datas-tranfert-risk', '', sprintf( __( 'Unable to transfer risk evaluation to wordpress system. Error: %s', 'wp-digi-dtrans-i18n' ), wp_json_encode( $wp_risk_evaluation ) ), array( 'object_id' => $old_risk_id ), 2 );
							}
						}
					}

					/** Mise à jour du risk avec les données ajoutées / Update the risk with new datas */
					risk_class::g()->update( $wp_risk );
				} else {
					/**	Log creation	*/
					log_class::g()->exec( 'digirisk-datas-tranfert-risk', '', __( 'Unable to transfer risk to wordpress system.', 'wp-digi-dtrans-i18n' ), array( 'object_id' => $old_risk_id, 'error' => $wp_risk ), 2 );
				}
			}
		}

		return $risk_to_associate;
	}

	/**
	 * Traitement du transfert des produits associés à un élément / Treat the transfer for product associated to an element
	 *
	 * @param integer $old_element_id Identifiant de l'élément pour lequel il faut effectuer le transfert / Element identifier for which we have to transfer datas into new storage way.
	 * @param string  $old_element_type Le type de l'élément pour lequel il faut récupèrer les commentaires et notes / Element type we had to get comment and notes for.
	 *
	 * @author Evarisk development team <dev@evarisk.com>
	 * @version 6.0
	 */
	function transfer_product( $old_element_id, $old_element_type ) {
		global $wpdb;
		$associated_product = array();

		$query = $wpdb->prepare(
				"SELECT *
				FROM " . DIGI_DBT_LIAISON_PRODUIT_ELEMENT . "
				WHERE id_element = %d
					AND table_element = %s", $old_element_id, $old_element_type
		);
		$associated_products = $wpdb->get_results( $query );
		$i = 0;
		foreach ( $associated_products as $product_association ) {
			switch ( $product_association->status ) {
				case 'valid':
					$associated_product[ 'current' ][ $i ][ $product_association->id_product ] = array(
						'date' => $product_association->date_affectation,
						'author_id' => $product_association->id_attributeur,
					);
				break;

				default:
					$associated_product[ 'histo' ][ $i ][ $product_association->id_product ] = array(
						'date' => $product_association->date_desAffectation,
						'author_id' => $product_association->id_desAttributeur,
					);
				break;
			}

			$i++;
		}

		return $associated_product;
	}

	/**
	 * Traitement du transfert des préconnisations associées à un élément / Treat the transfer for recommendations associated to an element
	 *
	 * @param integer $old_element_id Identifiant de l'élément pour lequel il faut effectuer le transfert / Element identifier for which we have to transfer datas into new storage way.
	 * @param string  $old_element_type Le type de l'élément pour lequel il faut récupèrer les commentaires et notes / Element type we had to get comment and notes for.
	 * @param integer $new_element_id Identifiant de l'élément transféré auquel sont associés les éléments / Transfered element identifier to which we have to associate transfered element.
	 *
	 * @author Evarisk development team <dev@evarisk.com>
	 * @version 6.0
	 */
	function transfer_recommendation( $old_element_id, $old_element_type, $new_element_id ) {
		global $wpdb;
		$associated_recommendation = array();

		$query = $wpdb->prepare(
			"SELECT LINK_RECO.*
			FROM " . TABLE_LIAISON_PRECONISATION_ELEMENT . " AS LINK_RECO
			WHERE id_element = %d
				AND table_element = %s
			ORDER BY id" , $old_element_id, $old_element_type
		);
		$associated_recommendations = $wpdb->get_results( $query );

		foreach ( $associated_recommendations as $recommendation_old ) {
			/**	Définition de la catégorie de danger pour le risque selon les nouveaux rangements / Define the danger category for risk into new storage	*/
			$query = $wpdb->prepare( "
				SELECT term_id
				FROM {$wpdb->termmeta}
				WHERE meta_key = %s
					AND meta_value = %s", '_wpdigi_element_computed_identifier', TABLE_PRECONISATION . '#value_sep#' . $recommendation_old->id_preconisation
			);
			$recommendation_term_id = $wpdb->get_var( $query );
			$recommendation_term = recommendation_term_class::g()->get( array( 'include' => array( $recommendation_term_id ) ) );
			$recommendation_term = $recommendation_term[0];

			$recommendation_args = array(
				'parent_id'						=> $new_element_id,
				'author_id'						=> 0,
				'date'								=> ( '0000-00-00 00:00:00' != $recommendation_old->date_affectation					? $recommendation_old->date_affectation : current_time( 'mysql', 0 ) ),
				'date_modified'				=> ( '0000-00-00 00:00:00' != $recommendation_old->date_update_affectation	? $recommendation_old->date_update_affectation : current_time( 'mysql', 0 ) ),
				'status'							=> ( ( 'valid' == $recommendation_old->status ) ? 'publish' : 'trash' ),
				'unique_key'					=> $recommendation_old->id,
				'unique_identifier'		=> recommendation_class::g()->element_prefix . $recommendation_old->id,
				'efficiency'					=> (int)$recommendation_old->efficacite,
				'recommendation_type'	=> $recommendation_old->preconisation_type,
				'taxonomy'						=> array(
					recommendation_category_term_class::g()->get_taxonomy()	=> $recommendation_term->parent_id,
					recommendation_term_class::g()->get_taxonomy()					=> (int)$recommendation_term_id,
				),
			);
			$recommendation = recommendation_class::g()->update( $recommendation_args );
			$associated_recommendation[] = $recommendation->id;

			$recommendation_comment_args = array(
				'post_id'		=> $recommendation->id,
				'date'			=> ( '0000-00-00 00:00:00' != $recommendation_old->date_affectation					? $recommendation_old->date_affectation : current_time( 'mysql', 0 ) ),
				'author_id'	=> 0,
				'content'		=> $recommendation_old->commentaire,
				'status'		=> ( ( 'valid' == $recommendation_old->status ) ? '-34070' : '-34071' ),
				'type'			=> recommendation_comment_class::g()->get_type(),
			);
			$recommendation_comment = recommendation_comment_class::g()->update( $recommendation_comment_args );
		}
	}

	/**
	 * Traitement du transfert des adresses associées à un élément / Treat the transfer for addresses associated to an element
	 *
	 * @param integer $address_id Identifiant de l'élément pour lequel il faut effectuer le transfert / Element identifier for which we have to transfer datas into new storage way.
	 * @param integer $new_element_id Identifiant de l'élément transféré auquel sont associés les éléments / Transfered element identifier to which we have to associate transfered element.
	 *
	 * @author Evarisk development team <dev@evarisk.com>
	 * @version 6.0
	 */
	function transfer_addresse( $address_id, $new_element_id ) {
		global $wpdb;
		$addresses = array();

		$query = $wpdb->prepare(
			"SELECT *
			FROM " . TABLE_ADRESSE . "
			WHERE id = %d", $address_id
		);
		$address = $wpdb->get_row( $query );

		$address_definition = array(
			'id'										=> null,
			'post_id'								=> $new_element_id,
			'author_nicename'				=> null,
			'author_email'					=> null,
			'content'								=> null,
			'type'									=> address_class::g()->get_type(),
			'parent_id'							=> null,
			'user_id'								=> null,
			'author_id'							=> null,
			'status'								=> -34070,
			'address' => $address->ligne1,
			'additional_address' => $address->ligne2,
			'postcode' => $address->codePostal,
			'town' => $address->ville,
			'coordinate' => array(
				'longitude'	=> $address->longitude,
				'latitude'		=> $address->latitude,
			),
		);

		$wp_address = address_class::g()->update( $address_definition );
		if ( ! empty( $wp_address->id ) ) {
			$addresses[] = $wp_address->id;
		}

		return $addresses;
	}

	/**
	 * Gestion des transferts des affectations des utilisateurs aux différents éléments / Manage user's affectation transfer for the different element
	 *
	 * @param integer $old_element_id
	 * @param string $old_element_type
	 * @param string $user_role
	 * @param string $element_new_type
	 * @param integer $element_new_id
	 * @param string $status
	 *
	 * @return array Les utilisateurs affectés par type d'affectation / User affectation by affectation type
	 */
	function transfer_users( $old_element_id, $old_element_type, $user_role = '', $element_new_type = '', $status = "'valid', 'moderated', 'deleted'" ) {
		global $wpdb;

		$currently_affected_user_list = array(
			'user' => array(),
			'evaluator' => array(),
		);

		$final_affectation = array();
		$query = $wpdb->prepare(
				"SELECT *, DATEDIFF( date_desaffectation_reelle, date_affectation_reelle ) AS duration_in_days, TIMEDIFF( date_desaffectation_reelle, date_affectation_reelle ) AS duration_in_hour, TIMESTAMPDIFF( MINUTE, date_affectation_reelle, date_desaffectation_reelle ) AS duration_in_minute
			FROM " . TABLE_LIAISON_USER_ELEMENT . "
			WHERE id_element = '%s'
				AND table_element = '%s'"
				, $old_element_id, $old_element_type
		);
		$currently_affected_user = $wpdb->get_results( $query );
		foreach ( $currently_affected_user as $the_affectation ) {
			$final_affectation[ ( 0 == $the_affectation->id_attributeur ) ? 1 : $the_affectation->id_user ][] = $the_affectation;
		}
		$query = $wpdb->prepare(
				"SELECT *, DATEDIFF( date_desaffectation_reelle, date_affectation_reelle ) AS duration_in_days, TIMEDIFF( date_desaffectation_reelle, date_affectation_reelle ) AS duration_in_hour, TIMESTAMPDIFF( MINUTE, date_affectation_reelle, date_desaffectation_reelle ) AS duration_in_minute
			FROM " . TABLE_LIAISON_USER_ELEMENT . "
			WHERE id_element = '%s'
				AND table_element = '%s'"
				, $old_element_id, $old_element_type . '_evaluation'
		);
		$currently_affected_evaluator = $wpdb->get_results( $query );
		foreach ( $currently_affected_evaluator as $the_affectation ) {
			$final_affectation[ ( 0 == $the_affectation->id_attributeur ) ? 1 : $the_affectation->id_user ][] = $the_affectation;
		}

		foreach ( $final_affectation as $user_id => $user_affectation_list ) {

			foreach ( $user_affectation_list as $affectation ) {
				$user_affectation = array();

				if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && ! empty( $_POST[ 'wp_new_user' ] ) && ! empty( $_POST[ 'wp_new_user' ][ $user_id ] ) ) {
					$user_id = (int)$_POST[ 'wp_new_user' ][ $user_id ];
				}
				$idAttributeur = ( 0 == $affectation->id_attributeur ) ? 1 : $affectation->id_attributeur;
				if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && ! empty( $_POST[ 'wp_new_user' ] ) && ! empty( $_POST[ 'wp_new_user' ][ $idAttributeur ] ) ) {
					$idAttributeur = (int)$_POST[ 'wp_new_user' ][ $i ][ $idAttributeur ];
				}
				$idDesAttributeur = ( 0 == $affectation->id_desAttributeur ) ? 1 : $affectation->id_desAttributeur;
				if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && ! empty( $_POST[ 'wp_new_user' ] ) && ! empty( $_POST[ 'wp_new_user' ][ $idDesAttributeur ] ) ) {
					$idDesAttributeur = (int)$_POST[ 'wp_new_user' ][ $i ][ $idDesAttributeur ];
				}

				if ( ! empty( $user_role ) ) {
					$user_affectation[ 'role' ] = $user_role;
				}

				$user_affectation[ 'status' ] = ( 'valid' == $affectation->status ) ? 'valid' : 'deleted';

				$user_affectation[ 'start' ][ 'date' ] = $affectation->date_affectation_reelle;
				$user_affectation[ 'start' ][ 'by' ] = (int)$idAttributeur;
				$user_affectation[ 'start' ][ 'on' ] = $affectation->date_affectation;

				$user_affectation[ 'end' ][ 'date' ] = $affectation->date_desaffectation_reelle;
				$user_affectation[ 'end' ][ 'by' ] = (int)$idDesAttributeur;
				$user_affectation[ 'end' ][ 'on' ] = $affectation->date_desAffectation;

				switch ( $affectation->table_element ) {
					case $old_element_type :
						$currently_affected_user_list[ 'user' ][ $user_id ][] = $user_affectation;
					break;

					case $old_element_type . '_evaluation' :
						$currently_affected_user_list[ 'evaluator' ][ $user_id ][] = $user_affectation;
					break;
				}
			}
		}

		return $currently_affected_user_list;
	}

}

wpdigi_transferdata_society_class::g();
