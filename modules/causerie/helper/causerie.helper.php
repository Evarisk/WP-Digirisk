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
 *
 * @since   6.6.0
 * @version 6.6.0
 *
 * @param  Causerie_Model $data L'objet.
 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
 */
function get_full_causerie( $data ) {
	if ( ! empty( $data->id ) ) {
		$data->risk_category = Risk_Category_Class::g()->get( array(
			'id' => max( $data->taxonomy[ Risk_Category_Class::g()->get_type() ] ),
		), true );

		$data->exclude_user_ids = '';

		if ( ! empty( $data->former['user_id'] ) ) {
			$data->exclude_user_ids = $data->former['user_id'] . ',';
		}

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
	}

	return $data;
}
