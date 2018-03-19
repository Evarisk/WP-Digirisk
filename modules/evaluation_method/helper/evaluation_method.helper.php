<?php
/**
 * Fonctions 'helpers' pour les méthodes d'évaluation des risques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.9
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères les variables des méthodes d'évaluations
 *
 * @since 6.5.0
 * @version 6.5.0
 *
 * @param  Evaluation_Method_Model $data Les données de la méthode d'évaluation.
 * @return Evaluation_Method_Model       Les données de la méthode d'évaluation avec ses variables.
 */
function get_full_method_evaluation( $data ) {
	if ( ! empty( $data->formula ) ) {
		$data->variables = Evaluation_Method_Variable_Class::g()->get( array(
			'include' => $data->formula,
		) );
	}

	return $data;
}
