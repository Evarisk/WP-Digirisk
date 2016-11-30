<?php
/**
 * Functions helper pour les catégories des préconisations
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
function get_full_recommendation_category( $data ) {
	$args_recommendation_term = array( 'parent' => $data->id );

	$data->recommendation_term = Recommendation_Term_Class::g()->get( $args_recommendation_term );

	return $data;
}
