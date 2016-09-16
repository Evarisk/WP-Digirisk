<?php if ( !defined( 'ABSPATH' ) ) exit;

class workunit_sheet_class extends singleton_util {
	protected function construct() {}

	/**
	* Génère le ODT de l'unité de travail
	*
	* @param int $workunit_id L'ID de l'unité de travail
	*/
	function generate_workunit_sheet( $workunit_id ) {
		$response = array(
			'status' 	=> true,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'digirisk' ),
			'link'		=> null,
		);

		$workunit = workunit_class::g()->get( array( 'id' => $workunit_id ), array( 'danger_category', 'danger' ) );
		$workunit = $workunit[0];

		/**	Définition des détails de l'unité de travail a imprimer / Define workunit details for print	*/
		/**	Définition de la photo de l'unité de travail / Define workunit main picture	*/
		$picture = __( 'No picture defined', 'digirisk' );
		if ( !empty( $workunit->thumbnail_id ) && ( true === is_int( (int)$workunit->thumbnail_id ) ) ) {
			$picture_definition = wp_get_attachment_image_src( $workunit->thumbnail_id, 'digirisk-element-thumbnail' );
			$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
			$picture = '';
			if ( is_file( $picture_final_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> $picture_final_path,
					'option'	=> array(
						'size'	=> 2,
					),
				);
			}
		}

		/**	Définition des informations de l'adresse de l'unité de travail / Define informations about workunit address	*/
		$option[ 'address' ] = $option[ 'postcode' ] = $option[ 'town' ] = '-';
		if ( !empty( $workunit->contact[ 'address' ] ) && ( true === is_int( (int)$workunit->contact[ 'address' ] ) ) ) {
			$work_unit_address_definition = address_class::g()->get( array( 'comment__in' => (int)$workunit->contact[ 'address' ][ 0 ] ) );
			// extract( get_object_vars( $work_unit_address_definition ) );
		}

		/**	Définition finale de l'unité de travail / Final definition for workunit	*/
		$workunit_sheet_details = array(
			'referenceUnite'	=> $workunit->unique_identifier,
			'nomUnite'			=> $workunit->title,
			'photoDefault'		=> $picture,
			'description'		=> $workunit->content,
			'adresse'			=> $option[ 'address' ],
			'codePostal'		=> $option[ 'postcode' ],
			'ville'				=> $option[ 'town' ],
			'telephone'			=> implode( ', ', $workunit->contact[ 'phone' ] ),
		);

		/**	Ajout des utilisateurs dans le document final / Add affected users' into final document	*/
		$workunit_sheet_details[ 'utilisateursAffectes' ] = $workunit_sheet_details[ 'utilisateursDesaffectes' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->user_info[ 'affected_id' ][ 'user' ] ) ) {
			$user_affectation_for_export = \digi\user_class::g()->build_list_for_document_export( $workunit->user_info[ 'affected_id' ][ 'user' ] );
			if ( null !== $user_affectation_for_export ) {
				$workunit_sheet_details[ 'utilisateursAffectes' ] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export[ 'affected' ],
				);
				if ( !empty( $user_affectation_for_export[ 'unaffected' ] ) ) {
					$workunit_sheet_details[ 'utilisateursDesaffectes' ] = array(
						'type'	=> 'segment',
						'value'	=> $user_affectation_for_export[ 'unaffected' ],
					);
				}
			}
		}

		/**	Ajout des préconisations affectées a l'unité de travail / Add recommendation affected to workunit	*/
		$affected_recommendation = array( );
		$workunit_sheet_details[ 'affectedRecommandation' ] = array( 'type' => 'segment', 'value' => array(), );
		if ( !empty( $workunit->associated_recommendation ) ) {
			foreach ( $workunit->associated_recommendation as $recommendation_id => $recommendation_detail ) {
				foreach ( $recommendation_detail as $recommendation ) {
					if ( 'valid' == $recommendation[ 'status' ] ) {
						$the_recommendation = recommendation_class::g()->get( array( 'id' => $recommendation_id ) );
						$the_recommendation = $the_recommendation[0];

						if ( !empty( $the_recommendation ) && !empty( $the_recommendation->parent_id ) ) {
							if ( empty( $affected_recommendation ) || empty( $affected_recommendation[ $the_recommendation->id ] ) ) {
								$the_recommendation_category = recommendation_category_class::g()->get( array( 'id' => $the_recommendation->parent_id ) );
								$the_recommendation_category = $the_recommendation_category[0];

								$picture_definition = wp_get_attachment_image_src( $the_recommendation_category->thumbnail_id, 'digirisk-element-thumbnail' );
								$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] ) );
								$picture = '';
								if ( is_file( $picture_final_path ) ) {
									$picture = array(
										'type'		=> 'picture',
										'value'		=> $picture_final_path,
										'option'	=> array(
											'size'	=> 2,
										),
									);
								}

								$affected_recommendation[ $the_recommendation->id ] = array(
									'recommandationCategoryIcon' => $picture,
									'recommandationCategoryName' => $the_recommendation_category->name,
								);
							}

							$picture_definition = wp_get_attachment_image_src( $the_recommendation->thumbnail_id, 'digirisk-element-thumbnail' );
							$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
							$picture = '';
							if ( is_file( $picture_final_path ) ) {
								$picture = array(
									'type'		=> 'picture',
									'value'		=> $picture_final_path,
									'option'	=> array(
										'size'	=> 2,
									),
								);
							}
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'type' ] = 'sub_segment';
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'value' ][] = array(
								'identifiantRecommandation'	=> $recommendation[ 'unique_identifier' ],
								'recommandationIcon'		=> $picture,
								'recommandationName'		=> $the_recommendation->name,
								'recommandationComment'		=> $recommendation[ 'comment' ],
							);
						}
					}
				}
			}
		}
		$workunit_sheet_details[ 'affectedRecommandation' ] = array(
			'type'	=> 'segment',
			'value'	=> $affected_recommendation,
		);

		/**	Ajout des personnes présentes lors de l'évaluation dans le document final / Add users' who were present when evaluation have been done into final document	*/
		$workunit_sheet_details[ 'utilisateursPresents' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->user_info[ 'affected_id' ][ 'evaluator' ] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $workunit );
			if ( !empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' == $evaluator_affectation_info[ 'affectation_info' ][ 'status' ] ) {
							$affected_users[] = array(
								'idUtilisateur'			=> evaluator_class::g()->element_prefix . $evaluator_affectation_info['affectation_info']['id'],
								'nomUtilisateur'		=> $evaluator_affectation_info['user_info']->lastname,
								'prenomUtilisateur'	=> $evaluator_affectation_info['user_info']->firstname,
								'dateEntretien'			=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info[ 'affectation_info' ][ 'start' ][ 'date' ], true ),
								'dureeEntretien'		=> evaluator_class::g()->get_duration( $evaluator_affectation_info[ 'affectation_info' ] ),
							);
						}
					}
				}

				$workunit_sheet_details[ 'utilisateursPresents' ] = array(
					'type'	=> 'segment',
					'value'	=> $affected_users,
				);
			}
		}

		/**	Construction de l'affichage des risques dans la fiche imprimée / Build risks display into printed sheet	*/
		$workunit_sheet_details[ 'risq80' ] = $workunit_sheet_details[ 'risq51' ] = $workunit_sheet_details[ 'risq48' ] = $workunit_sheet_details[ 'risq' ] = array( 'type' => 'segment', 'value' => array(), );
		/**	On récupère la définition des risques associés à l'unité de travail / Get definition of risks associated to workunit	*/
		$risk_list = risk_class::g()->get( array( 'post_parent' => $workunit->id ) );

		$risk_list_to_order = array();
		foreach ( $risk_list as $risk ) {
			// $complete_risk = risk_class::g()->get_risk( $risk->id );
			$comment_list = '';
			if ( !empty( $risk->comment ) ) :
				foreach ( $risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$risk_list_to_order[ $risk->evaluation[0]->scale ][] = array(
				'nomDanger'			=> $risk->danger_category[0]->danger[0]->name,
				'identifiantRisque'	=> $risk->unique_identifier . '-' . $risk->evaluation[0]->unique_identifier,
				'quotationRisque'	=> $risk->evaluation[0]->risk_level[ 'equivalence' ],
				'commentaireRisque'	=> $comment_list,
			);
		}
		krsort( $risk_list_to_order );

		if ( !empty( $risk_list_to_order ) ) {
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = !empty( evaluation_method_class::g()->list_scale[$risk_level] ) ? evaluation_method_class::g()->list_scale[$risk_level] : '';
				$workunit_sheet_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}

		/**	Call document creation function / Appel de la fonction de création du document	*/
		$document_creation_response = document_class::g()->create_document( $workunit, array( 'fiche_de_poste' ), $workunit_sheet_details );
		if ( !empty( $document_creation_response[ 'id' ] ) ) {
			$workunit->associated_document_id[ 'document' ][] = $document_creation_response[ 'id' ];
			$workunit = workunit_class::g()->update( $workunit );
		}

		return $document_creation_response;
	}
}
