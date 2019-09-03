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
	 * @since 6.2.9
	 *
	 * @param array $param Tableau de donnée.
	 */
	public function callback_dropdown_evaluation_method( $param ) {
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$display = ! empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';
		$preset  = ! empty( $param['preset'] ) ? true : false;

		$risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );

		$can_edit_type_cotation       = (bool) get_option( 'edit_type_cotation', false );
		$method_evaluation_simplified = Evaluation_Method_Class::g()->get( array( 'slug' => 'evarisk-simplified' ), true );
		$variables                    = $method_evaluation_simplified->data['variables'];

		$evaluation_method_id = $risk->data['evaluation_method']->data['id'];

		if ( empty( $evaluation_method_id ) ) {
			$evaluation_method_id = $method_evaluation_simplified->data['id'];
		}

		if ( 'edit' === $display ) {
			if ( $method_evaluation_simplified->data['id'] === $evaluation_method_id || $can_edit_type_cotation || $preset ) {
				// Méthode simplifié.
				\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/main-edit', array(
					'risk'                         => $risk,
					'evaluation_method_id'         => $evaluation_method_id,
					'method_evaluation_simplified' => $method_evaluation_simplified,
					'variables'                    => $variables,
					'display'                      => $display,
					'can_edit_type_cotation'       => $can_edit_type_cotation,
					'preset'                       => $preset,
				) );
			} else {
				// Tout autre méthode nécéssitant une modal.
				\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/edit-modal', array(
					'risk'                 => $risk,
					'evaluation_method_id' => $evaluation_method_id,
					'evaluation_method'    => $risk->data['evaluation_method'],
				) );
			}
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'main', array(
				'risk'                         => $risk,
				'evaluation_method_id'         => $evaluation_method_id,
				'method_evaluation_simplified' => $method_evaluation_simplified,
				'variables'                    => $variables,
				'display'                      => $display,
			) );
		}
	}
}

new Evaluation_Method_Shortcode();
