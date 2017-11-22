<?php
/**
 * Fonctions "helpers" pour les accidents
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
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
		'posts_per_page' => 1,
	), true );

	if ( empty( $data->document ) ) {
		$data->document = Accident_Travail_Benin_Class::g()->get( array(
			'schema' => true,
		), true);
	}

	$data->stopping_days = Accident_Travail_Stopping_Day_Class::g()->get( array(
		'post_parent' => $data->id,
	) );

	$data->number_field_completed = accident_calcul_completed_field( $data );
	return $data;
}

/**
 * Compiles le nombre de jour d'arrêt.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  Accident_Model $data L'objet.
 * @return Accident_Model
 */
function accident_compile_stopping_days( $data ) {
	$data->compiled_stopping_days = 0;

	if ( ! empty( $data->stopping_days ) ) {
		foreach ( $data->stopping_days as $stopping_days ) {
			$data->compiled_stopping_days += (int) $stopping_days->content;
		}
	}

	return $data;
}

/**
 * Calcule le nombre de champ en DUR complété dans les données.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  Accident_Model $data L'objet.
 * @return integer       Le nombre de champ complétés.
 */
function accident_calcul_completed_field( $data ) {
	$number_field_completed = 0;

	if ( ! empty( $data->victim_identity_id ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->accident_date ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->place ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->id ) ) {
		$number_comments = get_comments( array(
			'post_id' => $data->id,
			'status' => -34070,
			'count' => true,
			'number' => 1,
		) );

		if ( 0 < $number_comments ) {
			$number_field_completed++;
		}
	}

	if ( ! empty( $data->stopping_days ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->location_of_lesions ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->nature_of_lesions ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->name_and_address_of_witnesses ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->name_and_address_of_third_parties_involved ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->observation ) ) {
		$number_field_completed++;
	}

	if ( ! empty( $data->have_investigation ) ) {
		$number_field_completed++;
	}

	if ( 0 < count( $data->associated_document_id['signature_of_the_caregiver_id'] ) ) {
		$number_field_completed++;
	}

	if ( 0 < count( $data->associated_document_id['signature_of_the_victim_id'] ) ) {
		$number_field_completed++;
	}

	return $number_field_completed;
}
