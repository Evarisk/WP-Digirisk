<?php
/**
 * Classe gérant les fiches de groupement et poste.
 *
 * Elle gère l'affichage des fiches de groupement et poste.
 * Elle gère également la génération d'une fiche de groupement et de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet class.
 */
class Sheet_Class extends Document_Class {

	/**
	 * Le type du document
	 *
	 * @since 7.0.0
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @since 7.0.0
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La version de l'objet
	 *
	 * @since 7.0.0
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Appelle le template main.view.php dans le dossier /view/
	 *
	 * @since 7.0.0
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 */
	public function display( $element_id ) {
		$element = $this->get( array(
			'schema' => true,
		), true );

		$action = 'generate_fiche_de_groupement';

		if ( $element->data['type'] === Sheet_Workunit_Class::g()->get_type() ) {
			$action = 'generate_fiche_de_poste';
		}

		\eoxia\View_Util::exec( 'digirisk', 'document', 'main', array(
			'_this'      => $this,
			'action'     => $action,
			'element'    => $element,
			'element_id' => $element_id,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/
	 *
	 * @since 7.0.0
	 *
	 * @param integer $element_id L'ID de l'élement.
	 */
	public function display_document_list( $element_id ) {
		$list_document = $this->get( array(
			'post_parent' => $element_id,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'document', 'list', array(
			'_this'         => $this,
			'list_document' => $list_document,
		) );
	}

	/**
	 * Cette méthode génère la fiche de groupement
	 *
	 * @since 7.0.0
	 *
	 * @param  int $society_id L'ID de la société.
	 *
	 * @return array
	 */
	public function generate( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );
		$society_infos = $this->get_infos( $society );

		$sheet_details = array(
			'reference'   => $society->data['unique_identifier'],
			'nom'         => $society->data['title'],
			'description' => $society->data['content'],
			'adresse'     => $society_infos['adresse'],
			'telephone'   => ! empty( $society->data['contact']['phone'] ) ? end( $society->data['contact']['phone'] ) : '',
			'codePostal'  => $society_infos['codePostal'],
			'ville'       => $society_infos['ville'],
		);

		$sheet_details['photoDefault'] = $this->set_picture( $society );

		$sheet_details = wp_parse_args( $sheet_details, $this->set_evaluators( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_risks( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_recommendations( $society ) );

		$type = 'groupement';

		if ( Workunit_Class::g()->get_type() === $society->data['type'] ) {
			$type = 'unite_de_travail';
		}

		$document_creation_response = $this->create_document( $society, array( $type ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'element'           => $society,
			'success'           => true,
		);
	}

	/**
	 * Récupères les informations comme l'adresse, le code postal, la ville et les renvoies dans un tableau.
	 *
	 * @since 6.2.1
	 *
	 * @param Group_Model $society L'objet groupement.
	 * @return array {
	 *         @type string adresse    L'adresse de l'entreprise.
	 *         @type string codePostal Le code postal de l'entreprise.
	 *         @type string ville      La ville de l'entreprise.
	 * }
	 */
	public function get_infos( $society ) {
		$infos = array(
			'adresse'    => '',
			'codePostal' => '',
			'ville'      => '',
		);

		$address = Society_Class::g()->get_address( $society );

		$infos['adresse']    = $address->data['address'] . ' ' . $address->data['additional_address'];
		$infos['codePostal'] = $address->data['postcode'];
		$infos['ville']      = $address->data['town'];

		return $infos;
	}

	/**
	 * Définie l'image du document
	 *
	 * @since 7.0.0
	 *
	 * @param Group_Model $society L'objet groupement.
	 * @return string|false|array {
	 *         @type string type   Le type du noeud pour l'ODT.
	 *         @type string value  Le lien vers le media.
	 *         @type array  option {
	 *               @type integer size La taille en CM du media.
	 *         }
	 * }
	 */
	public function set_picture( $society ) {
		$picture = __( 'No picture defined', 'digirisk' );

		if ( ! empty( $society->thumbnail_id ) ) {
			$picture_definition = wp_get_attachment_image_src( $society->thumbnail_id, 'full' );
			$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type' => 'picture',
					'value' => str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option' => array(
						'size' => 9,
					),
				);
			}
		}

		return $picture;
	}

	/**
	 * Récupères les évaluateurs affectés à la société
	 *
	 * @since 7.0.0
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return array La liste des évéluateurs affectés à la société
	 */
	public function set_evaluators( $society ) {
		$evaluators = array( 'utilisateursPresents' => array( 'type' => 'segment', 'value' => array() ) );
		$affected_evaluators = array();

		if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $society );
			if ( ! empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' === $evaluator_affectation_info['affectation_info']['status'] ) {
							$affected_evaluators[] = array(
								'idUtilisateur'              => Evaluator_Class::g()->element_prefix . $evaluator_affectation_info['user_info']->id,
								'nomUtilisateur'             => $evaluator_affectation_info['user_info']->lastname,
								'prenomUtilisateur'          => $evaluator_affectation_info['user_info']->firstname,
								'dateAffectationUtilisateur' => mysql2date( 'd/m/Y', $evaluator_affectation_info['affectation_info']['start']['date'], true ),
								'dureeEntretien'             => Evaluator_Class::g()->get_duration( $evaluator_affectation_info['affectation_info'] ),
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
	 * @since 7.0.0
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return array Les risques dans la société
	 */
	public function set_risks( $society ) {
		$risks = Risk_Class::g()->get( array( 'post_parent' => $society->data['id'] ) );

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
					'nomDanger'         => $risk->risk_category->name,
					'identifiantRisque' => $risk->unique_identifier . '-' . $risk->evaluation->unique_identifier,
					'quotationRisque'   => $risk->evaluation->risk_level['equivalence'],
					'commentaireRisque' => $comment_list,
				);
			}
		}

		krsort( $risk_list_to_order );

		if ( ! empty( $risk_list_to_order ) ) {
			$result_treshold = Scale_Util::get_scale( 'score' );
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = ! empty( Evaluation_Method_Class::g()->list_scale[ $risk_level ] ) ? Evaluation_Method_Class::g()->list_scale[ $risk_level ] : '';
				$risk_details[ 'risq' . $final_level ]['value'] = $risk_for_export;
			}
		}

		return $risk_details;
	}

	/**
	 * Récupères les recommandations dans la société
	 *
	 * @since 7.0.0
	 *
	 * @param Group_Model $society L'objet unité de travail.
	 *
	 * @return array Les recommandations dans la société
	 */
	public function set_recommendations( $society ) {
		$recommendations = Recommendation::g()->get( array( 'post_parent' => $society->data['id'] ) );

		$recommendations_details = array( 'affectedRecommandation' => array( 'type' => 'segment', 'value' => array() ) );
		$recommendations_filled = array();

		if ( ! empty( $recommendations ) ) {
			foreach ( $recommendations as $element ) {
				/** Récupères la catégorie parent */
				$recommendations_filled[ $element->data['id'] ] = array(
					'recommandationCategoryIcon' => $this->get_picture_term( $element->data['recommendation_category_term'][0]->thumbnail_id ),
					'recommandationCategoryName' => $element->data['recommendation_category_term'][0]->name,
				);

				$recommendations_filled[ $element->data['id'] ]['recommendations']['type'] = 'sub_segment';
				$recommendations_filled[ $element->data['id'] ]['recommendations']['value'][] = array(
					'identifiantRecommandation' => $element->data['unique_identifier'],
					'recommandationIcon'        => $this->get_picture_term( $element->data['recommendation_category_term'][0]->recommendation_term[0]->thumbnail_id ),
					'recommandationName'        => $element->data['recommendation_category_term'][0]->name,
					'recommandationComment'     => $element->data['comment'][0]->content,
				);
			}
		}

		$recommendations_details['affectedRecommandation']['value'] = $recommendations_filled;

		return $recommendations_details;
	}

	/**
	 * Récupères le lien vers l'image de la recommendation
	 *
	 * @since 6.2.1
	 *
	 * @param  int $term_id    L'ID de la recommendation.
	 *
	 * @return false|string    Le lien vers l'image
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

Sheet_Class::g();
