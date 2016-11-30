<?php namespace digi;

function construct_evaluation( $data ) {
	if ( !empty( $data ) && !empty( $data[ 'method_id' ] ) ) {
		$method_evaluation_digirisk_simplified = get_term_by( 'slug', 'evarisk-simplified', evaluation_method_class::g()->get_taxonomy() );
		$method_evaluation_digirisk_complex = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );
		if ( $data['method_id'] == $method_evaluation_digirisk_simplified->term_id ) {
			$data = update_method_simplified( $data['scale'] );

			if ( !$data ) {
				wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
			}
		}
		else if ( $data['method_id'] == $method_evaluation_digirisk_complex->term_id ) {
			$data = update_method_complex( $data['variable'], $method_evaluation_digirisk_complex->term_id );

			if ( !$data ) {
				wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
			}
		}
	}

	return $data;
}


/**
* Prépares les données pour la méthode simplifiée
*
* @param int $risk_evaluation_level Le level de l'évaluation du risque
*
*/
function update_method_simplified( $risk_evaluation_level ) {
	// Récupère la variable de la méthode simplifiée
	$term_method_variable = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );

	if ( $risk_evaluation_level < 0 || $risk_evaluation_level > 4 ) {
		return false;
	}

	// Le niveau du risque + la force du risque par rapport à son level
	$risk_level = array(
		'method_result' => $risk_evaluation_level,
		'equivalence' => evaluation_method_class::g()->list_scale[$risk_evaluation_level],
	);

	// Les détails de la cotation
	$quotation_detail = array(
		'variable_id' => $term_method_variable->term_id,
		'value' => $risk_evaluation_level
	);

	// Les données de l'évaluation
	$data = array(
		'scale' => $risk_evaluation_level,
		'risk_level' => $risk_level,
		'quotation_detail' => $quotation_detail,
	);

	return $data;
}

/**
* Prépares les données pour la méthode d'évaluation complexe
*
* @param int $term_id L'ID de la méthode évaluation complexe
*
*/
function update_method_complex( $list_variable, $term_id ) {

	$risk_evaluation_level = 1;

	if ( empty( $list_variable ) ) {
		return false;
	}

	if ( !empty( $list_variable ) ) {
		foreach ( $list_variable as $element ) {
			if ( (int) $element < 0 || (int) $element > 5 ) {
				return false;
			}
			$risk_evaluation_level *= (int) $element;
		}
	}

	$evaluation_method = evaluation_method_class::g()->get( array( 'id' => $term_id ) );
	if ( $risk_evaluation_level < 0 || $risk_evaluation_level > max( array_keys( $evaluation_method[0]->matrix ) ) ) {
		return false;
	}

	$equivalence = $evaluation_method[0]->matrix[$risk_evaluation_level];
	$scale = scale_util::get_scale( $equivalence );

	$risk_level = array(
		'method_result' => $risk_evaluation_level,
		'equivalence' => $equivalence,
	);

	$quotation_detail = array();

	if ( !empty( $list_variable ) ) {
		foreach ( $list_variable as $key => $element ) {
			$quotation_detail[] = array( 'variable_id' => $key, 'value' => $element );
		}
	}

	$option = array(
		'risk_level' => $risk_level,
		'quotation_detail' => $quotation_detail
	);

	$data = array(
		'scale' => $scale,
		'risk_level' => $risk_level,
		'quotation_detail' => $quotation_detail,
	);

	return $data;
}
