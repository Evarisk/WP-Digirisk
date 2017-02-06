<?php
/**
 * Functions helper pour les groupements
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'un groupement
 * Groupements enfant, Unités de travail enfant.
 *
 * @param  Group_Model $data L'objet.
 * @return Group_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_group( $data ) {
	// Récupères les risques du groupement.
	$data->list_risk = Risk_Class::g()->get( array( 'post_parent' => $data->id ) );

	$data->list_workunit = Workunit_Class::g()->get( array( 'post_parent' => $data->id, 'posts_per_page' => -1 ) );

	if ( ! empty( $data->list_workunit ) ) {
		foreach ( $data->list_workunit as $workunit ) {
			$workunit->list_risk = Risk_Class::g()->get( array( 'post_parent' => $workunit->id ) );
		}
	}

	$data->list_group = Group_Class::g()->get(
		array(
			'posts_per_page' 	=> -1,
			'post_parent'			=> $data->id,
			'post_status' 		=> array( 'publish', 'draft' ),
			'orderby'					=> array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
		)
	);

	if ( ! empty( $data->list_group ) ) {
		foreach ( $data->list_group as $group ) {
			$group = get_full_group( $group );
		}
	}

	return $data;
}
