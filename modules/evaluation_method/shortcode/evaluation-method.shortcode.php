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
		add_shortcode( 'digi_dropdown_simple_evaluation_method', array( $this, 'callback_dropdown_simple_evaluation_method' ) );
		// add_shortcode( 'digi_evaluation_method_evarisk', array( $this, 'callback_evaluation_method_evarisk' ) );
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
	public function callback_dropdown_simple_evaluation_method( $param ) {
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$display = ! empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';

		if ( 0 !== $risk_id ) {
			$risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );
		} else {
			$risk = Risk_Class::g()->get( array( 'schema' => true ), true );
		}

		$method_evaluation_simplified = Evaluation_Method_Class::g()->get( array( 'slug' => 'evarisk-simplified' ), true );
		$variables                    = $method_evaluation_simplified->data['variables'];

		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/main', array(
			'risk'                         => $risk,
			'method_evaluation_simplified' => $method_evaluation_simplified,
			'variables'                    => $variables,
		) );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation complexe du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 * @return void
	 *
	 * @since 6.2.9
	 * @version 6.2.9
	 */
	public function callback_evaluation_method_evarisk( $param ) {
		$term_evarisk = get_term_by( 'slug', 'evarisk', Evaluation_Method_Class::g()->get_type() );
		$risk_id      = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$risk         = array();

		$list_evaluation_method_variable = array();

		if ( ! empty( $term_evarisk ) ) {
			$evarisk_evaluation_method       = Evaluation_Method_Class::g()->get( array( 'id' => $term_evarisk->term_id ), true );
			$list_evaluation_method_variable = Evaluation_Method_Variable_Class::g()->get_evaluation_method_variable( $evarisk_evaluation_method->formula );
		}

		if ( ! empty( $risk_id ) ) {
			$risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );
		}

		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'popup/popup', array(
			'term_evarisk'                    => $term_evarisk,
			'risk_id'                         => $risk_id,
			'risk'                            => $risk,
			'list_evaluation_method_variable' => $list_evaluation_method_variable,
			'evarisk_evaluation_method'       => $evarisk_evaluation_method,
		) );
	}
}

new Evaluation_Method_Shortcode();
