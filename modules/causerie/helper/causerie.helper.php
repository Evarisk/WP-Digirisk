<?php
/**
 * Fonctions 'helpers' pour les causeries.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'une causerie
 * - Categorie de risque
 * - Document ODT
 * - Unique identifiant modifié
 *
 * @since   6.6.0
 * @version 6.6.0
 *
 * @param  Causerie_Model $data L'objet.
 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_causerie( $data ) {
	$args_category_risk = array(
		'schema'         => true,
		'posts_per_page' => 1,
	);

	if ( ! empty( $data->id ) ) {
		$args_category_risk = array(
			'include' => $data->taxonomy['digi-category-risk'],
		);
	}

	$data->risk_category = null;

	if ( ! empty( $data->taxonomy['digi-category-risk'] ) ) {
		$risk_categories     = Risk_Category_Class::g()->get( $args_category_risk );
		$data->risk_category = $risk_categories[0];
	} else {
		$data->risk_category = Risk_Category_Class::g()->get( $args_category_risk, true );
	}

	if ( empty( $data->taxonomy['digi-category-risk'] ) ) {
		$data->risk_category = null;
	}

	// Récupères le document ODT.
	$data->document = null;

	$data->document = Sheet_Causerie_Class::g()->get( array(
		'post_parent'    => $data->id,
		'posts_per_page' => 1,
	), true );

	// Récupères le document ODT.
	$data->document_intervention_causerie = null;

	$data->document_intervention_causerie = Sheet_Causerie_Intervention_Class::g()->get( array(
		'post_parent'    => $data->id,
		'posts_per_page' => 1,
	), true );

	$data->exclude_user_ids = '';

	if ( ! empty( $data->former['user_id'] ) ) {
		$data->exclude_user_ids = $data->former['user_id'] . ',';
	}

	return $data;
}

function get_user_renderer( $data ) {
	$data->former['rendered'] = null;

	if ( ! empty( $data->former['user_id'] ) ) {
		$data->former['rendered'] = User_Digi_Class::g()->get( array( 'id' => $data->former['user_id'] ), true );
	}

	if ( ! empty( $data->participants ) ) {
		foreach ( $data->participants as &$participant ) {
			if ( ! empty( $participant['user_id'] ) ) {
				$participant['rendered'] = User_Digi_Class::g()->get( array( 'id' => $participant['user_id'] ), true );

				$data->exclude_user_ids .= $participant['user_id'] . ',';
			}
		}
	}

	$data->exclude_user_ids = substr( $data->exclude_user_ids, 0, -1 );

	return $data;
}
