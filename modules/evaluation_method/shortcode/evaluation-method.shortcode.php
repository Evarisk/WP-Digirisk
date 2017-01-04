<?php
/**
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package evaluation_method
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

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
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	public function callback_digi_evaluation_method( $param ) {
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$display = ! empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';

		$term_evarisk_simple = get_term_by( 'slug', 'evarisk-simplified', evaluation_method_class::g()->get_taxonomy() );
		$term_evarisk_complex = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );

		$scale = 0;
		$equivalence = 1;
		$digi_method_id = 0;
		$target = 'wp-digi-risk-cotation-chooser';

		$class = '';

		if ( 0 !== $risk_id ) {
			$risk = Risk_Class::g()->get( array( 'post__in' => array( $risk_id ) ) );
			$risk = $risk[0];
			$digi_method_id = max( $risk->taxonomy['digi-method'] );
			$scale = ! empty( $risk->evaluation->scale ) ? $risk->evaluation->scale : 0;
			$equivalence = ! empty( $risk->evaluation->risk_level['equivalence'] ) ? $risk->evaluation->risk_level['equivalence'] : 0;
			if ( $digi_method_id === $term_evarisk_complex->term_id ) {
				$target = 'wpdigi-method-evaluation-render';
				$class = 'open-popup';
			} else {
				$class = '';
			}
		} else {
			$risk = Risk_Class::g()->get( array( 'schema' => true ) );
			$risk = $risk[0];
			$risk->taxonomy['digi-method'][] = $term_evarisk_simple->term_id;
			$digi_method_id = $term_evarisk_simple->term_id;
		}

		$view_data = array(
			'target'							=> $target,
			'term_evarisk_simple'	=> $term_evarisk_simple,
			'risk'								=> $risk,
			'digi_method_id' 			=> $digi_method_id,
			'class'								=> $class,
			'display'							=> $display,
		);

		if ( 'view' === $display ) {
			View_Util::exec( 'evaluation_method', 'view-evaluation-method', $view_data );
		} else {
			View_Util::exec( 'evaluation_method', 'edit-digirisk-evaluation-method', $view_data );
		}
	}

	/**
	 * Récupère le niveau et l'équivalence de la méthode d'évaluation complexe du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	public function callback_evaluation_method_evarisk( $param ) {
		$term_evarisk = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );
		$risk_id = ! empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$risk = array();
		$list_evaluation_method_variable = array();

		if ( ! empty( $term_evarisk ) ) {
			$evarisk_evaluation_method = evaluation_method_class::g()->get( array( 'id' => $term_evarisk->term_id ) );
			$evarisk_evaluation_method = $evarisk_evaluation_method[0];

			$list_evaluation_method_variable = evaluation_method_variable_class::g()->get_evaluation_method_variable( $evarisk_evaluation_method->formula );
		}

		if ( ! empty( $risk_id ) ) {
			$risk = risk_class::g()->get( array( 'id' => $risk_id ), array( '\digi\evaluation_method', '\digi\evaluation' ) );
			$risk = ! empty( $risk[0] ) ? $risk[0] : array();
		}

		view_util::exec( 'evaluation_method', 'popup/popup', array( 'term_evarisk' => $term_evarisk, 'risk_id' => $risk_id, 'risk' => $risk, 'list_evaluation_method_variable' => $list_evaluation_method_variable, 'evarisk_evaluation_method' => $evarisk_evaluation_method ) );
	}
}

new Evaluation_Method_Shortcode();
