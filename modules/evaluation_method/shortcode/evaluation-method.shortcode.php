<?php
/**
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
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
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
 */
class Evaluation_Method_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_evaluation_method', array( $this, 'callback_digi_evaluation_method' ) );
		add_shortcode( 'digi_evaluation_method_evarisk', array( $this, 'callback_evaluation_method_evarisk' ) );
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function callback_digi_evaluation_method( $param ) {
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$display = ! empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';

		$term_evarisk_simple  = get_term_by( 'slug', 'evarisk-simplified', Evaluation_Method_Class::g()->get_type() );
		$term_evarisk_complex = get_term_by( 'slug', 'evarisk', Evaluation_Method_Class::g()->get_type() );

		$scale          = 0;
		$equivalence    = 1;
		$digi_method_id = 0;
		$target         = 'wp-digi-risk-cotation-chooser';

		$class = '';

		if ( 0 !== $risk_id ) {
			$risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );

			if ( $risk->preset ) {
				$digi_method_id = (int) $term_evarisk_simple->term_id;
			} else {
				$digi_method_id = (int) end( $risk->taxonomy['digi-method'] );
			}

			$scale       = ! empty( $risk->evaluation->scale ) ? $risk->evaluation->scale : 0;
			$equivalence = ! empty( $risk->evaluation->risk_level['equivalence'] ) ? $risk->evaluation->risk_level['equivalence'] : 0;
			if ( $digi_method_id === $term_evarisk_complex->term_id ) {
				$target = 'wpdigi-method-evaluation-render';
				$class  = 'open-popup';
			} else {
				$class = '';
			}

			if ( $risk->preset && ! empty( $risk->taxonomy['digi-method'] ) ) {
				$digi_method_id = (int) end( $risk->taxonomy['digi-method'] );
			}
		} else {
			$risk                            = Risk_Class::g()->get( array( 'schema' => true ), true );
			$risk->taxonomy['digi-method'][] = $term_evarisk_simple->term_id;
			$digi_method_id                  = $term_evarisk_simple->term_id;
		}

		$view_data = array(
			'target'               => $target,
			'term_evarisk_simple'  => $term_evarisk_simple,
			'term_evarisk_complex' => $term_evarisk_complex,
			'risk'                 => $risk,
			'digi_method_id'       => $digi_method_id,
			'class'                => $class,
			'display'              => $display,
		);

		if ( 'view' === $display ) {
			\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'view-evaluation-method', $view_data );
		} else {
			if ( $term_evarisk_simple->term_id === $digi_method_id ) {
				\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'edit-digirisk-evaluation-method', $view_data );
			} else {
				\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'edit-evarisk-evaluation-method', $view_data );
			}
		}
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation complexe du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.6
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
