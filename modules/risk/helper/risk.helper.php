<?php
/**
 * Fonctions 'helpers' pour les risques.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'un risque
 * Danger catégorie, danger, méthode d'évaluation, évaluation et commentaire.
 *
 * @param  Risk_Model $data L'objet.
 * @return Risk_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_risk( $data ) {
	$args_category_risk = array( 'schema' => true );
	$args_evaluation_method = array( 'schema' => true );
	$args_evaluation = array( 'schema' => true );
	$args_risk_evaluation_comment = array( 'schema' => true );

	if ( ! empty( $data->id ) ) {
		$args_category_risk = array( 'include' => $data->taxonomy['digi-category-risk'] );
		$args_evaluation = array( 'comment__in' => array( $data->current_evaluation_id ) );
		$args_risk_evaluation_comment = array( 'post_id' => $data->id );
		$args_evaluation_method = array( 'post_id' => $data->id );
	}

	// Récupères la catégorie du danger.
	$danger_categories = Risk_Category_Class::g()->get( $args_category_risk );
	$data->risk_category = $danger_categories[0];

	// Récupères la méthode d'évaluation.
	$evaluation_methods = Evaluation_Method_Class::g()->get( $args_evaluation_method );
	$data->evaluation_method = $evaluation_methods[0];

	// Récupères l'évaluation du risque.
	$risk_evaluations = Risk_Evaluation_Class::g()->get( $args_evaluation );
	$data->evaluation = $risk_evaluations[0];

	// Récupères les commentaires.
	$risk_evaluation_comments = Risk_Evaluation_Comment_Class::g()->get( $args_risk_evaluation_comment );

	if ( ! empty( $args['schema'] ) ) {
		$data->comment = $risk_evaluation_comments[0];
	}
	else {
		$data->comment = $risk_evaluation_comments;
	}

	if ( ! isset( $data->modified_unique_identifier ) ) {
		$data->modified_unique_identifier = '';
	}

	return $data;
}
