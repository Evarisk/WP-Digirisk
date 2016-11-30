<?php
/**
 * Functions helper pour les préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package recommendation
 * @subpackage helper
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'une préconisation
 *
 * @param  Recommendation_Model $data L'objet.
 * @return Recommendation_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_recommendation( $data ) {
	$args_recommendation_category_term = array( 'schema' => true );
	$args_recommendation_term = array( 'schema' => true );
	$args_recommendation_comment = array( 'schema' => true );

	if ( ! empty( $data->taxonomy['digi-recommendation-category'] ) ) {
		$args_recommendation_category_term = array( 'include' => array( max( $data->taxonomy['digi-recommendation-category'] ) ) );
	}

	if ( ! empty( $data->taxonomy['digi-recommendation'] ) ) {
		$args_recommendation_term = array( 'include' => array( max( $data->taxonomy['digi-recommendation'] ) ) );
	}

	if ( ! empty( $data->id ) ) {
		$args_recommendation_comment = array( 'post_id' => $data->id );
	}

	$data->recommendation_category_term = Recommendation_Category_Term_Class::g()->get( $args_recommendation_category_term );
	$data->recommendation_category_term[0]->recommendation_term = Recommendation_Term_Class::g()->get( $args_recommendation_term );

	// Récupères les commentaires.
	$data->comment = Recommendation_Comment_Class::g()->get( $args_recommendation_comment );

	return $data;
}
