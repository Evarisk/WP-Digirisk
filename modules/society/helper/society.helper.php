<?php
/**
 * Fonctions 'helpers' pour les sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères le responsable
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  Society_Model $data L'objet.
 * @return Society_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_society( $data ) {

	if ( ! empty( $data->owner_id ) ) {
		$data->owner = User_Digi_Class::g()->get( array( 'id' => $data->owner_id ), true );
	} else {
		$data->owner = User_Digi_Class::g()->get( array( 'schema' => true ), true );
	}

	return $data;
}
