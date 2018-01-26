<?php
/**
 * Gestion des fonctions 'helpers' relatifs aux affichages légaux
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères tous les éléments nécessaires pour le fonctionnement de l'affichage légal
 * Inspection du travail avec son adresse, Nom du médecin avec son adresse
 *
 * @since 6.0.0
 * @version 6.5.0
 *
 * @param  Legal_Display_Model $data L'objet.
 * @return Legal_Display_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_legal_display( $data ) {
	$args_detective_work                      = array( 'schema' => true );
	$args_detective_work_address              = array( 'schema' => true );
	$args_occupational_health_service         = array( 'schema' => true );
	$args_occupational_health_service_address = array( 'schema' => true );

	if ( ! empty( $data->id ) ) {
		$args_detective_work              = array( 'id' => $data->detective_work_id );
		$args_occupational_health_service = array( 'id' => $data->occupational_health_service_id );
	}

	$data->detective_work = Third_Class::g()->get( $args_detective_work, true );

	if ( ! empty( $data->detective_work->contact['address_id'] ) ) {
		$args_detective_work_address = array( 'id' => $data->detective_work->contact['address_id'] );
	}

	$data->detective_work->address = Address_Class::g()->get( $args_detective_work_address, true );

	$data->occupational_health_service = Third_Class::g()->get( $args_occupational_health_service, true );

	if ( ! empty( $data->occupational_health_service->contact['address_id'] ) ) {
		$args_occupational_health_service_address = array( 'id' => $data->occupational_health_service->contact['address_id'] );
	}

	$data->occupational_health_service->address = Address_Class::g()->get( $args_occupational_health_service_address, true );

	return $data;
}
