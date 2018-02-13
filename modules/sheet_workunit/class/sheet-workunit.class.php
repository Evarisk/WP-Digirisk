<?php
/**
 * Gères la génération de la fiche de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3
 * @version 6.4.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de la fiche de poste
 */
class Sheet_Workunit_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Workunit_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'fiche_de_poste';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'fiche-de-poste';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'FP';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche de poste';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'unite_de_travail';

	/**
	 * Appelle le template main.view.php dans le dossier /view/
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function display( $element_id ) {
		$element = $this->get( array(
			'schema' => true,
		), true );

		\eoxia\View_Util::exec( 'digirisk', 'sheet_workunit', 'main', array(
			'element' => $element,
			'element_id' => $element_id,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function display_document_list( $element_id ) {
		$list_document = $this->get( array(
			'post_parent' => $element_id,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'sheet_workunit', 'list', array(
			'list_document' => $list_document,
			'element_id' => $element_id,
		) );
	}

	/**
	 * Cette méthode génère la fiche de groupement
	 *
	 * @param  int $society_id L'ID de la société.
	 *
	 * @return bool
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function generate( $society_id ) {
		$society = Workunit_Class::g()->get( array(
			'id' => $society_id,
		), true );

		$society_infos = $this->get_infos( $society );

		$sheet_details = array(
			'referenceUnite' => $society->unique_identifier,
			'nomUnite' => $society->title,
			'description' => $society->content,
			'adresse' => $society_infos['adresse'],
			'codePostal' => $society_infos['codePostal'],
			'ville' => $society_infos['ville'],
			'telephone' => ! empty( $society->contact['phone'] ) ? max( $society->contact['phone'] ) : '',
		);

		$sheet_details['photoDefault'] = $this->set_picture( $society );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_users( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_evaluators( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_risks( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_recommendations( $society ) );

		$document_creation_response = $this->create_document( $society, array( 'unite_de_travail' ), $sheet_details );
		if ( ! empty( $document_creation_response['id'] ) ) {
			$society->associated_document_id['document'][] = $document_creation_response['id'];
			$society = Workunit_Class::g()->update( $society );
		}

		return array(
			'creation_response' => $document_creation_response,
			'element' => $society,
			'success' => true,
		);
	}

	/**
	 * Récupères les informations comme l'adresse, le code postal, la ville et les renvoies dans un tableau.
	 *
	 * @since 6.2.1.2
	 * @version 6.2.1.2
	 *
	 * @param Workunit_Model $society L'objet unité de travail.
	 * @return array
	 */
	public function get_infos( $society ) {
		$infos = array( 'adresse' => '', 'codePostal' => '', 'ville' => '' );

		$address = Society_Class::g()->get_address( $society );
		$address = $address[0];

		$infos['adresse'] = $address->address . ' ' . $address->additional_address;
		$infos['codePostal'] = $address->postcode;
		$infos['ville'] = $address->town;

		return $infos;
	}

	/**
	 * Définie l'image du document
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return string|false|array
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function set_picture( $society ) {
		$picture = __( 'No picture defined', 'digirisk' );

		if ( ! empty( $society->thumbnail_id ) ) {
			$picture_definition = wp_get_attachment_image_src( $society->thumbnail_id, 'medium' );
			$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option'	=> array(
						'size' => 9,
					),
				);
			}
		}

		return $picture;
	}

	/**
	 * Récupères les utilisateurs affectés et désaffectés de la société
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return array La liste des utilisateurs affectés et désaffectés à la société
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function set_users( $society ) {
		$users = array(
			'utilisateursAffectes' => array( 'type' => 'segment', 'value' => array() ),
			'utilisateursDesaffectes' => array( 'type' => 'segment', 'value' => array() ),
		);

		if ( ! empty( $society->user_info['affected_id']['user'] ) ) {
			$user_affectation_for_export = user_digi_class::g()->build_list_for_document_export( $society->user_info['affected_id']['user'] );
			if ( null !== $user_affectation_for_export ) {
				$users['utilisateursAffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['affected'],
				);
				$users['utilisateursDesaffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['unaffected'],
				);
			}
		}

		return $users;
	}

	/**
	 * Récupères les évaluateurs affectés à la société
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return array La liste des évéluateurs affectés à la société
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function set_evaluators( $society ) {
		$evaluators = array( 'utilisateursPresents' => array( 'type' => 'segment', 'value' => array() ) );
		$affected_evaluators = array();

		if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $society );
			if ( ! empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' === $evaluator_affectation_info['affectation_info']['status'] ) {
							$affected_evaluators[] = array(
								'idUtilisateur'			=> evaluator_class::g()->element_prefix . $evaluator_affectation_info['user_info']->id,
								'nomUtilisateur'		=> $evaluator_affectation_info['user_info']->lastname,
								'prenomUtilisateur'	=> $evaluator_affectation_info['user_info']->firstname,
								'dateEntretien'			=> mysql2date( 'd/m/Y', $evaluator_affectation_info['affectation_info']['start']['date'], true ),
								'dureeEntretien'		=> evaluator_class::g()->get_duration( $evaluator_affectation_info['affectation_info'] ),
							);
						}
					}
				}

				$evaluators['utilisateursPresents'] = array(
					'type'	=> 'segment',
					'value'	=> $affected_evaluators,
				);
			}
		}

		return $evaluators;
	}

	/**
	 * Récupères les risques dans la société
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return array Les risques dans la société
	 *
	 * @since 6.0.0
	 * @version 6.2.10.0
	 */
	public function set_risks( $society ) {
		$risks = Risk_Class::g()->get( array( 'post_parent' => $society->id ) );

		usort( $risks, function( $a, $b ) {
			if( $a->current_equivalence == $b->current_equivalence ) {
				return 0;
			}
			return ( $a->current_equivalence > $b->current_equivalence ) ? -1 : 1;
		} );

		$risk_details = array(
			'risq80' => array( 'type' => 'segment', 'value' => array() ),
			'risq51' => array( 'type' => 'segment', 'value' => array() ),
			'risq48' => array( 'type' => 'segment', 'value' => array() ),
			'risq' => array( 'type' => 'segment', 'value' => array() ),
		);

		$risk_list_to_order = array();

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$comment_list = '';
				if ( ! empty( $risk->comment ) ) :
					foreach ( $risk->comment as $comment ) :
						$comment_list .= $comment->date['date_input']['fr_FR']['date'] . ' : ' . $comment->content . "
			";
					endforeach;
				endif;

				$risk_list_to_order[ $risk->evaluation->scale ][] = array(
					'nomDanger'					=> $risk->risk_category->name,
					'identifiantRisque'	=> $risk->unique_identifier . '-' . $risk->evaluation->unique_identifier,
					'quotationRisque'		=> $risk->evaluation->risk_level['equivalence'],
					'commentaireRisque'	=> $comment_list,
				);
			}
			krsort( $risk_list_to_order );

			if ( ! empty( $risk_list_to_order ) ) {
				$result_treshold = scale_util::get_scale( 'score' );
				foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
					$final_level = ! empty( evaluation_method_class::g()->list_scale[ $risk_level ] ) ? evaluation_method_class::g()->list_scale[ $risk_level ] : '';
					$risk_details[ 'risq' . $final_level ]['value'] = $risk_for_export;
				}
			}
		}

		return $risk_details;
	}

	/**
	 * Récupères les recommandations dans la société
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return array Les recommandations dans la société
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function set_recommendations( $society ) {
		$recommendations = Recommendation_Class::g()->get( array( 'post_parent' => $society->id ) );

		$recommendations_details = array( 'affectedRecommandation' => array( 'type' => 'segment', 'value' => array() ) );
		$recommendations_filled = array();

		if ( ! empty( $recommendations ) ) {
			foreach ( $recommendations as $element ) {
				/** Récupères la catégorie parent */
				$recommendations_filled[ $element->id ] = array(
					'recommandationCategoryIcon' => $this->get_picture_term( $element->recommendation_category_term[0]->thumbnail_id ),
					'recommandationCategoryName' => $element->recommendation_category_term[0]->name,
				);

				$recommendations_filled[ $element->id ]['recommendations']['type'] = 'sub_segment';
				$recommendations_filled[ $element->id ]['recommendations']['value'][] = array(
					'identifiantRecommandation' => $element->unique_identifier,
					'recommandationIcon'				=> $this->get_picture_term( $element->recommendation_category_term[0]->recommendation_term[0]->thumbnail_id ),
					'recommandationName'				=> $element->recommendation_category_term[0]->name,
					'recommandationComment'			=> $element->comment[0]->content,
				);
			}
		}

		$recommendations_details['affectedRecommandation']['value'] = $recommendations_filled;

		return $recommendations_details;
	}

	/**
	 * Récupères le lien vers l'image de la recommendation
	 *
	 * @param  int $term_id    L'ID de la recommendation.
	 * @return false|string    Le lien vers l'image
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function get_picture_term( $term_id ) {
		$picture_definition = wp_get_attachment_image_src( $term_id, 'thumbnail' );

		if ( ! $picture_definition ) {
			return false;
		}

		$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ) );
		$picture = '';
		if ( is_file( $picture_final_path ) ) {
			$picture = array(
				'type'		=> 'picture',
				'value'		=> $picture_final_path,
				'option'	=> array(
					'size'	=> 1,
				),
			);
		}

		return $picture;
	}
}

Sheet_Workunit_Class::g();
