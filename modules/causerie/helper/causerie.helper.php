<?php
/**
 * Fonctions 'helpers' pour les causeries.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'une causerie
 * Categories de risque
 *
 * @since 6.5.0
 * @version 6.5.0
 *
 * @param  Causerie_Model $data L'objet.
 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_causerie( $data ) {
	$args_category_risk = array(
		'schema' => true,
	);

	if ( ! empty( $data->id ) ) {
		$args_category_risk = array(
			'include' => $data->taxonomy['digi-category-risk'],
		);
	}

	// Récupères la catégorie du danger.
	$danger_categories = Risk_Category_Class::g()->get( $args_category_risk );
	$data->risk_category = $danger_categories[0];

	if ( ! isset( $data->modified_unique_identifier ) ) {
		$data->modified_unique_identifier = '';
	}

	return $data;
}
