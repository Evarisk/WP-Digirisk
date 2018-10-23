<?php
/**
 * Classe gérant les filtres principaux des ODT.
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
 * Gestion des filtres relatifs aux identifiants de DigiRisk.
 */
class ODT_Filter {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	public function __construct() {}

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
}
