<?php
/**
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.9
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
 */
class Evaluation_Method_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_dropdown_evaluation_method', array( $this, 'callback_dropdown_evaluation_method' ) );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 * @return void
	 *
	 * @since 6.2.9
	 * @version 6.5.0
	 */
	public function callback_dropdown_evaluation_method( $param ) {
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$display = ! empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';

		$risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );

		$method_evaluation_simplified = Evaluation_Method_Class::g()->get( array( 'slug' => 'evarisk-simplified' ), true );
		$variables                    = $method_evaluation_simplified->data['variables'];

		$evaluation_method_id = $risk->data['evaluation_method']->data['id'];

		if ( empty( $evaluation_method_id ) ) {
			$evaluation_method_id = $method_evaluation_simplified->data['id'];
		}

		if ( $method_evaluation_simplified->data['id'] === $evaluation_method_id ) {
			\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/main', array(
				'risk'                         => $risk,
				'evaluation_method_id'         => $evaluation_method_id,
				'method_evaluation_simplified' => $method_evaluation_simplified,
				'variables'                    => $variables,
			) );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/edit-modal', array(
				'risk_id'                      => $risk_id,
				'evaluation_method'            => $risk->data['evaluation_method'],
			) );
		}
	}
}

new Evaluation_Method_Shortcode();
