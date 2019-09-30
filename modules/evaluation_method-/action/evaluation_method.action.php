<?php
/**
 * Les actions relatives aux méthodes d'évaluations.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux méthodes d'évaluations.
 */
class Evaluation_Method_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_get_scale', array( $this, 'ajax_get_scale' ) );
		add_action( 'wp_ajax_load_modal_method_evaluation', array( $this, 'ajax_load_modal_method_evaluation' ) );
	}

	/**
	 * Appelle la méthode get_scale pour avoir le niveau de l'évaluation
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 */
	public function ajax_get_scale() {
		$method_evaluation_id        = ! empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;
		$evaluation_method_variables = ! empty( $_POST['variables'] ) ? wp_unslash( (string) $_POST['variables'] ) : '';

		if ( empty( $method_evaluation_id ) || empty( $evaluation_method_variables ) ) {
			wp_send_json_error();
		}

		$evaluation_method_variables = json_decode( $evaluation_method_variables, true );

		$details = Evaluation_Method_Class::g()->get_details( $method_evaluation_id, $evaluation_method_variables );

		wp_send_json_success( array(
			'details' => $details,
		) );
	}

	/**
	 * Charges les données selon la méthode d'évaluation puis renvois la vue de la modal.
	 *
	 * @since 7.0.0
	 * @version 7.0.0
	 *
	 * @return void
	 */
	public function ajax_load_modal_method_evaluation() {
		check_ajax_referer( 'load_modal_method_evaluation' );

		$id                          = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$risk_id                     = ! empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0; // WPCS: input var ok.
		$evaluation_method_variables = ! empty( $_POST['variables'] ) ? wp_unslash( (string) $_POST['variables'] ) : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$evaluation_method = Evaluation_Method_Class::g()->get( array(
			'id' => $id,
		), true );

		$args = array(
			'id' => $risk_id,
		);

		if ( 0 === $risk_id ) {
			$args['schema'] = true;
		}

		$risk = Risk_Class::g()->get( $args, true );

		$evaluation_method_variables = json_decode( $evaluation_method_variables, true );

		if ( ! empty( $evaluation_method_variables ) ) {
			foreach ( $evaluation_method_variables as $variable_id => $variable ) {
				$risk->data['evaluation']->data['variables'][ $variable_id ] = $variable;
			}

			$details = Evaluation_Method_Class::g()->get_details( $evaluation_method->data['id'], $evaluation_method_variables );
			$risk->data['evaluation']->data['equivalence'] = $details['equivalence'];
			$risk->data['evaluation']->data['scale']       = $details['scale'];
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'popup/main', array(
			'evaluation_method' => $evaluation_method,
			'risk'              => $risk,
		) );
		$main_view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'popup/footer', array(
			'risk' => $risk,
		) );
		$footer_view = ob_get_clean();

		wp_send_json_success( array(
			'view'             => $main_view,
			'buttons_view'     => $footer_view,
			'namespace'        => 'digirisk',
			'module'           => 'evaluationMethod',
			'callback_success' => 'loadedModalMethodEvaluationSuccess',
		) );
	}
}

new Evaluation_Method_Action();
