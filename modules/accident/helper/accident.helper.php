<?php
/**
 * Fonctions "helpers" pour les accidents
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement d'un accident
 * Risque et commentaire.
 *
 * @param  Accident_Model $data L'objet.
 * @return Accident_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_accident( $data ) {
	if ( empty( $data->registration_date_in_register ) ) {
		$data->registration_date_in_register = current_time( 'd/m/Y' );
	}
	$data->victim_identity = User_Digi_Class::g()->get( array(
		'schema' => true,
	), true );

	if ( ! empty( $data->risk_id ) ) {
		$data->risk = Risk_Class::g()->get( array(
			'include' => $data->risk_id,
		), true );
	}

	if ( ! empty( $data->victim_identity_id ) ) {
		$data->victim_identity = User_Digi_Class::g()->get( array(
			'include' => $data->victim_identity_id,
		), true );
	}

	if ( ! isset( $data->modified_unique_identifier ) ) {
		$data->modified_unique_identifier = '';
	}

	$data->document = Accident_Travail_Benin_Class::g()->get( array(
		'post_parent' => $data->id,
	) , true );

	return $data;
}
