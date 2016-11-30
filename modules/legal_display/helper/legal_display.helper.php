<?php
/**
 * Functions helper pour l'affichage légal
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement de l'affichage légal
 * Inspection du travail avec son adresse, Nom du médecin avec son adresse
 *
 * @param  Legal_Display_Model $data L'objet.
 * @return Legal_Display_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_legal_display( $data ) {
	$args_detective_work = array( 'schema' => true );
	$args_detective_work_address = array( 'schema' => true );

	$args_occupational_health_service = array( 'schema' => true );
	$args_occupational_health_service_address = array( 'schema' => true );

	if ( ! empty( $data->id ) ) {
		$args_detective_work = array( 'include' => $data->detective_work_id );
		$args_occupational_health_service = array( 'include' => $data->occupational_health_service_id );
	}

	$data->detective_work = Third_Class::g()->get( $args_detective_work );

	if ( ! empty( $data->detective_work[0]->contact['address_id'] ) ) {
		$args_detective_work_address = array( 'comment__in' => array( $data->detective_work[0]->contact['address_id'] ) );
	}

	$data->detective_work[0]->address = Address_Class::g()->get( $args_detective_work_address );

	$data->occupational_health_service = Third_Class::g()->get( $args_occupational_health_service );

	if ( ! empty( $data->occupational_health_service[0]->contact['address_id'] ) ) {
		$args_occupational_health_service_address = array( 'comment__in' => array( $data->occupational_health_service[0]->contact['address_id'] ) );
	}

	$data->occupational_health_service[0]->address = Address_Class::g()->get( $args_occupational_health_service_address );

	return $data;
}
