<?php
/**
 * Functions helper pour les préconisations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'une préconisation
 *
 * @since 6.2.1
 * @version 6.5.0
 *
 * @param  Recommendation_Model $data L'objet.
 * @return Recommendation_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_recommendation( $data ) {
	$args_recommendation_category_term = array( 'schema' => true );
	$args_recommendation_term          = array( 'schema' => true );
	$args_recommendation_comment       = array( 'schema' => true );

	if ( ! empty( $data->taxonomy['digi-recommendation-category'] ) ) {
		$args_recommendation_category_term = array( 'id' => end( $data->taxonomy['digi-recommendation-category'] ) );
	}

	if ( ! empty( $data->taxonomy['digi-recommendation'] ) ) {
		$args_recommendation_term = array( 'id' => end( $data->taxonomy['digi-recommendation'] ) );
	}

	if ( ! empty( $data->id ) ) {
		$args_recommendation_comment = array( 'post_id' => $data->id );
	}

	$data->recommendation_category_term                      = Recommendation_Category_Term_Class::g()->get( $args_recommendation_category_term, true );
	$data->recommendation_category_term->recommendation_term = Recommendation_Term_Class::g()->get( $args_recommendation_term, true );

	// Récupères les commentaires.
	$data->comment = Recommendation_Comment_Class::g()->get( $args_recommendation_comment );

	return $data;
}
