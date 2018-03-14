<?php
/**
 * Fonctions 'helpers' pour les méthodes d'évaluation des risques.
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
 * Construit les données pour l'évaluation du risque.
 *
 * @since 6.0.0
 * @version 6.5.0
 *
 * @param  array $data Les données du risque.
 * @return array       Les données de la méthode d'évaluation.
 */
function construct_evaluation( $data ) {
	if ( ! empty( $data ) && ! empty( $data['method_id'] ) ) {

		$tmp_data = array();

		$method_evaluation_digirisk_simplified = get_term_by( 'slug', 'evarisk-simplified', Evaluation_Method_Class::g()->get_type() );
		$method_evaluation_digirisk_complex    = get_term_by( 'slug', 'evarisk', Evaluation_Method_Class::g()->get_type() );

		if ( $data['method_id'] === $method_evaluation_digirisk_simplified->term_id ) {
			$tmp_data = update_method_simplified( $data['scale'] );

			if ( ! $tmp_data ) {
				wp_send_json_error();
			}
		} elseif ( $data['method_id'] === $method_evaluation_digirisk_complex->term_id ) {
			$tmp_data = update_method_complex( $data['variable'], $method_evaluation_digirisk_complex->term_id );

			if ( ! $tmp_data ) {
				wp_send_json_error();
			}
		}

		$data['scale']            = $tmp_data['scale'];
		$data['risk_level']       = $tmp_data['risk_level'];
		$data['quotation_detail'] = $tmp_data['quotation_detail'];

		// @todo: Doublon des données (Doit être supprimer dans les modèles d'évaluation méthode).
		if ( ! empty( $data['risk_level'] ) && ! empty( $data['risk_level']['equivalence'] ) ) {
			$data['equivalence'] = (int) $data['risk_level']['equivalence'];
		}
	}


	return $data;
}


/**
 * Prépares les données pour la méthode simplifiée
 *
 * @since 6.0.0
 * @version 6.5.0
 *
 * @param int $risk_evaluation_level Le level de l'évaluation du risque.
 *
 * @return array                     Les données de la méthode d'évaluation simplifiée.
 */
function update_method_simplified( $risk_evaluation_level ) {
	// Récupère la variable de la méthode simplifiée.
	$term_method_variable = get_term_by( 'slug', 'evarisk', Evaluation_Method_Class::g()->get_type() );

	if ( $risk_evaluation_level < 0 || $risk_evaluation_level > 4 ) {
		return false;
	}

	// Le niveau du risque + la force du risque par rapport à son level.
	$risk_level = array(
		'method_result' => (int) $risk_evaluation_level,
		'equivalence'   => (int) Evaluation_Method_Class::g()->list_scale[ (int) $risk_evaluation_level ],
	);

	// Les détails de la cotation.
	$quotation_detail = array(
		'variable_id' => $term_method_variable->term_id,
		'value'       => (int) $risk_evaluation_level,
	);

	// Les données de l'évaluation.
	$data = array(
		'scale'            => (int) $risk_evaluation_level,
		'risk_level'       => $risk_level,
		'quotation_detail' => $quotation_detail,
	);

	return $data;
}

/**
 * Prépares les données pour la méthode d'évaluation complexe
 *
 * @since 6.0.0
 * @version 6.5.0
 *
 * @param array $list_variable Les ID des variables de la méthode kinney.
 * @param int   $term_id       L'ID de la méthode évaluation kinney.
 *
 * @return array       Les données de la méthode d'évaluation kinney.
 */
function update_method_complex( $list_variable, $term_id ) {

	$risk_evaluation_level = 1;

	if ( empty( $list_variable ) ) {
		return false;
	}

	if ( ! empty( $list_variable ) ) {
		foreach ( $list_variable as $element ) {
			if ( (int) $element < 0 || (int) $element > 5 ) {
				return false;
			}
			$risk_evaluation_level *= (int) $element;
		}
	}

	$evaluation_method = Evaluation_Method_Class::g()->get( array( 'id' => $term_id ) );
	if ( $risk_evaluation_level < 0 || $risk_evaluation_level > max( array_keys( $evaluation_method[0]->matrix ) ) ) {
		return false;
	}

	$equivalence = $evaluation_method[0]->matrix[ $risk_evaluation_level ];
	$scale       = (int) Scale_Util::get_scale( $equivalence );

	$risk_level = array(
		'method_result' => (int) $risk_evaluation_level,
		'equivalence'   => (int) $equivalence,
	);

	$quotation_detail = array();

	if ( ! empty( $list_variable ) ) {
		foreach ( $list_variable as $key => $element ) {
			$quotation_detail[] = array(
				'variable_id' => $key,
				'value'       => $element,
			);
		}
	}

	$option = array(
		'risk_level'       => $risk_level,
		'quotation_detail' => $quotation_detail,
	);

	$data = array(
		'scale'            => (int) $scale,
		'risk_level'       => $risk_level,
		'quotation_detail' => $quotation_detail,
	);

	return $data;
}
