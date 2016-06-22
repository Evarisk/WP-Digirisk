<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class sheet_groupment_action_01 {

	/**
	 * CORE - Instanciation des actions ajax pour les unités de travail / Instanciate ajax treatment for work unit
	 */
	function __construct() {
    add_action( 'wp_ajax_wpdigi_save_sheet_digi-group', array( $this, 'generate_sheet' ) );
  }

	public function generate_sheet() {
		$response = array(
			'status' 	=> false,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'wpdigi-i18n' ),
		);

		if ( 0 === (int) $_POST['element_id'] )
			wp_send_json_error();
		else
			$element_id = (int) $_POST['element_id'];

		/**	Début de la génération du document / Start document generation	*/
		$document_controller = new document_controller_01();

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$group_model_to_use = null;
		$group_model_id_to_use = !empty( $_POST ) && !empty( $_POST[ 'document_model_id' ] ) && is_int( (int)$_POST[ 'document_model_id' ] ) ? (int)$_POST[ 'document_model_id' ] : null ;

		/**	Récupération de la liste des modèles existants pour l'élément actuel / Get model list for current group	*/
		if ( null === $group_model_id_to_use ) {
			$response = $document_controller->get_model_for_element( array( 'fiche_de_groupement', ) );
			if ( false === $response[ 'status' ] ) {
				wp_send_json_error( $response );
			}

			$group_model_id_to_use = ( is_int( (int)$response[ 'model_id' ] ) && !empty( $response['model_id'] ) ) ? (int)$response[ 'model_id' ] : $response[ 'model_path' ];
		}

		if ( is_int( $group_model_id_to_use ) ) {
			$group_model_to_use = get_attached_file( $group_model_id_to_use );
		}
		else {
			$group_model_to_use = $group_model_id_to_use;
		}

		if ( empty( $group_model_to_use ) ) {
			$response[ 'message' ] = __( 'An error occured while getting model content to use for generation', 'wpdigi-i18n' );
			wp_send_json_error( $response );
		}

		global $wpdigi_group_ctr;
		$group = $wpdigi_group_ctr->show( $element_id );

		/**	Définition de la révision du document / Define the document version	*/
		$document_revision = $document_controller->get_document_type_next_revision( array( 'fiche_de_groupement' ), $group->id );

		/**	Enregistrement de la fiche de l'unité de travail dans la base de donnée / Save group sheet into database	*/
		$group_sheet_id = 0;
		$group_sheet_media_args = array(
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_author'		 => get_current_user_id(),
			'post_date'			 => current_time( 'mysql', 0 ),
			'post_title'		 => mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $group->option[ 'unique_identifier' ] . '_' . sanitize_title( str_replace( ' ', '_', $group->title ) ) . '_V' . $document_revision,
		);
		$group_sheet_id = wp_insert_attachment( $group_sheet_media_args, '', $group->id );

		if ( !empty( $group_sheet_id ) ) {
			$group->option[ 'associated_document_id' ][ 'document' ][] = $group_sheet_id;
			$group = $wpdigi_group_ctr->update( $group );
			wp_set_object_terms( $group_sheet_id, array( 'printed', 'fiche_de_groupement', ), $document_controller->attached_taxonomy_type );
		}

		$group = $wpdigi_group_ctr->show( $group->id );

		// $picture = __( 'No picture defined', 'wpdigi-i18n' );
		// if ( !empty( $group->thumbnail_id ) && ( true === is_int( (int)$group->thumbnail_id ) ) ) {
		// 	$picture_definition = wp_get_attachment_image_src( $group->thumbnail_id, 'digirisk-element-thumbnail' );
		// 	$picture = array(
		// 		'type'		=> 'picture',
		// 		'value'		=> str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] ),
		// 		'option'	=> array(
		// 			'size'	=> 8,
		// 		),
		// 	);
		// }

		/**	Définition des informations de l'adresse de l'unité de travail / Define informations about workunit address	*/
		$option[ 'address' ] = $option[ 'postcode' ] = $option[ 'town' ] = '-';
		if ( !empty( $group->option[ 'contact' ][ 'address' ] ) && ( true === is_int( (int)$group->option[ 'contact' ][ 'address' ] ) ) ) {
			global $wpdigi_address_ctr;
			$work_unit_address_definition = $wpdigi_address_ctr->show( (int)$group->option[ 'contact' ][ 'address' ][ 0 ] );
			extract( get_object_vars( $work_unit_address_definition ) );
		}

		/**	Définition finale de l'unité de travail / Final definition for group	*/
		$group_sheet_details = array(
			'reference'	=> $group->option[ 'unique_identifier' ],
			'nom'				=> $group->title,
			'photoDefault'		=> '',
			'description'			=> $group->content,
			'adresse'					=> $option[ 'address' ],
			'telephone'				=> implode( ', ', $group->option[ 'contact' ][ 'phone' ] ),
		);

		/**	Ajout des utilisateurs dans le document final / Add affected users' into final document	*/
		$group_sheet_details[ 'utilisateursAffectes' ] = $group_sheet_details[ 'utilisateursDesaffectes' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $group->option[ 'user_info' ][ 'affected_id' ][ 'user' ] ) ) {
			global $wpdigi_user_ctr;
			$user_affectation_for_export = $wpdigi_user_ctr->build_list_for_document_export( $group->option[ 'user_info' ][ 'affected_id' ][ 'user' ] );
			if ( null !== $user_affectation_for_export ) {
				$group_sheet_details[ 'utilisateursAffectes' ] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export[ 'affected' ],
				);
				$group_sheet_details[ 'utilisateursDesaffectes' ] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export[ 'unaffected' ],
				);
			}
		}

		/**	Ajout des personnes présentes lors de l'évaluation dans le document final / Add users' who were present when evaluation have been done into final document	*/
		$group_sheet_details[ 'utilisateursPresents' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $group->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) ) {
			global $wpdigi_evaluator_ctr;
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = $wpdigi_evaluator_ctr->get_list_affected_evaluator( $group );
			if ( !empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' == $evaluator_affectation_info[ 'affectation_info' ][ 'status' ] ) {
							$affected_users[] = array(
								'idUtilisateur'			=> $wpdigi_evaluator_ctr->element_prefix . $evaluator_affectation_info[ 'user_info' ]->id,
								'nomUtilisateur'		=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'lastname' ],
								'prenomUtilisateur'	=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'firstname' ],
								'dateEntretien'			=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info[ 'affectation_info' ][ 'start' ][ 'date' ], true ),
								'dureeEntretien'		=> $wpdigi_evaluator_ctr->get_duration( $evaluator_affectation_info[ 'affectation_info' ] ),
							);
						}
					}
				}

				$group_sheet_details[ 'utilisateursPresents' ] = array(
					'type'	=> 'segment',
					'value'	=> $affected_users,
				);
			}
		}

		/**	Construction de l'affichage des risques dans la fiche imprimée / Build risks display into printed sheet	*/
		$group_sheet_details[ 'risq80' ] = $group_sheet_details[ 'risq51' ] = $group_sheet_details[ 'risq48' ] = $group_sheet_details[ 'risq' ] = array( 'type' => 'segment', 'value' => array(), );
		/**	On récupère la définition des risques associés à l'unité de travail / Get definition of risks associated to group	*/
		global $wpdigi_risk_ctr;
		$risk_list = array();

		if ( !empty( $group->option[ 'associated_risk'] ) ) {
			$risk_list = $wpdigi_risk_ctr->index( array(
				'include' => $group->option[ 'associated_risk' ],
			) );
		}

		$risk_list_to_order = array();
		foreach ( $risk_list as $risk ) {
			$complete_risk = $wpdigi_risk_ctr->get_risk( $risk->id );
			$comment_list = '';
			if ( !empty( $complete_risk->comment ) ) :
				foreach ( $complete_risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$risk_list_to_order[ $complete_risk->evaluation->option[ 'risk_level' ][ 'scale' ] ][] = array(
				'nomDanger'					=> $complete_risk->danger->name,
				'identifiantRisque'	=> $risk->option[ 'unique_identifier' ] . '-' . $complete_risk->evaluation->option[ 'unique_identifier' ],
				'quotationRisque'		=> $complete_risk->evaluation->option[ 'risk_level' ][ 'equivalence' ],
				'commentaireRisque'	=> $comment_list,
			);
		}
		krsort( $risk_list_to_order );

		if ( !empty( $risk_list_to_order ) ) {
			global $wpdigi_evaluation_method_controller;
			$result_treshold = $wpdigi_evaluation_method_controller->get_method_treshold( 'score' );
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = !empty( $result_treshold[ $risk_level ] ) ? $result_treshold[ $risk_level ] : '';

				$group_sheet_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}



		/**	On créé le document / Create the document	*/
		$group_sheet_details = apply_filters( 'wpdigi_group_sheet_details', $group_sheet_details );
		$document_creation = $document_controller->create_document( $group_model_to_use, $group_sheet_details, $group->type. '/' . $group->id . '/' . $group_sheet_media_args[ 'post_title' ] . '.odt' , $group_sheet_id );
		$filetype = 'unknown';
		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
		}

		/**	On met à jour les informations concernant le document dans la base de données / Update data for document into database	*/
		$next_document_key = ( wpdigi_utils::get_last_unique_key( 'post', $document_controller->get_post_type() ) + 1 );
		$group_sheet_args = array(
			'id'					=> $group_sheet_id,
			'status'    	=> 'inherit',
			'author_id'		=> get_current_user_id(),
			'date'			 	=> current_time( 'mysql', 0 ),
			'mime_type'		=> $filetype[ 'type' ],
			'option'			=> array (
				'unique_key'						=> $next_document_key,
				'unique_identifier' 		=> $document_controller->element_prefix . $next_document_key,
				'model_id' 							=> $group_model_to_use,
				'document_meta' 				=> json_encode( $group_sheet_details ),
				'version'								=> '',
			),
		);
		$document = $document_controller->update( $group_sheet_args );

		$document = $document_controller->show( $group_sheet_id );
		$document_full_path = null;
		if ( is_file( $document_controller->get_document_path( 'basedir' ) . '/' . $group->type . '/' . $group->id . '/' . $document->title . '.odt' ) ) {
			$document_full_path = $document_controller->get_document_path( 'baseurl' ) . '/' . $group->type . '/' . $group->id . '/' . $document->title . '.odt';
		}
		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'common', 'printed-list', 'item' ) );
		$response[ 'output' ] = ob_get_contents();
		ob_end_clean();

		if( !empty( $_POST['return'] ) ) {
			$response['name'] = $group_sheet_media_args[ 'post_title' ] . '.odt';
			$response['link'] = $document_creation[ 'link' ];
			return $response;
		}

		wp_die( json_encode( $response ) );
	}
}

global $sheet_groupment_action;
$sheet_groupment_action = new sheet_groupment_action_01();
