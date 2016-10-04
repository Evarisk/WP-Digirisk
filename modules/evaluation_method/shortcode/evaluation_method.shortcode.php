<?php namespace digi;
/**
* Ajoutes deux shortcodes
* digi_evaluation_method permet d'afficher la méthode d'évaluation simple
* digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_shortcode {
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
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	* @param string $param['display'] La méthode d'affichage pour le template
	*
	* @return bool
	*/
	public function callback_digi_evaluation_method( $param ) {
		$display = !empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';
		$risk_id = !empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;

		$term_evarisk_simple = get_term_by( 'slug', 'evarisk-simplified', evaluation_method_class::g()->get_taxonomy() );
		$term_evarisk_complex = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );

		$scale = 0;
		$equivalence = 1;
		$digi_method_id = 0;
		$target = 'wp-digi-risk-cotation-chooser';

		if ( $risk_id != 0 ) {
			$risk = risk_class::g()->get( array( 'id' => $risk_id ), array( 'evaluation_method', 'evaluation' ) );
			$risk = $risk[0];
			$digi_method_id = $risk->evaluation_method[0]->id;
			$scale = !empty( $risk->evaluation[0]->scale ) ? $risk->evaluation[0]->scale : 0;
			$equivalence = !empty( $risk->evaluation[0]->risk_level['equivalence'] ) ? $risk->evaluation[0]->risk_level['equivalence'] : 0;

			if ( $digi_method_id === $term_evarisk_complex->term_id ) {
				$target = "wpdigi-method-evaluation-render";
			}
		}
		else {
			$risk = risk_class::g()->get( array( 'schema' => true ), array( 'evaluation_method', 'evaluation' ) );
			$risk = $risk[0];
		}

		$view_data = array(
			'target'							=> $target,
			'term_evarisk_simple'	=> $term_evarisk_simple,
			'risk'								=> $risk
		);

		view_util::exec( 'evaluation_method', $display . '-simple-evaluation-method', $view_data );
	}

	/**
	* Récupère le niveau et l'équivalence de la méthode d'évaluation complexe du risque courant.
	*
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	*
	* @return bool
	*/
	public function callback_evaluation_method_evarisk( $param ) {
		$term_evarisk = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );
		$risk_id = !empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$risk = array();

		if ( !empty( $term_evarisk ) ) {
			$risk = risk_class::g()->get( array( 'id' => $risk_id ), array( '\digi\evaluation_method', '\digi\evaluation' ) );
			$risk = !empty( $risk[0] ) ? $risk[0] : array();

			$evarisk_evaluation_method = evaluation_method_class::g()->get( array( 'id' => $term_evarisk->term_id ) );
			$evarisk_evaluation_method = $evarisk_evaluation_method[0];

			$list_evaluation_method_variable = evaluation_method_variable_class::g()->get_evaluation_method_variable( $evarisk_evaluation_method->formula );
		}

		view_util::exec( 'evaluation_method', 'popup/popup', array( 'term_evarisk' => $term_evarisk, 'risk_id' => $risk_id, 'risk' => $risk, 'list_evaluation_method_variable' => $list_evaluation_method_variable, 'evarisk_evaluation_method' => $evarisk_evaluation_method ) );
	}
}

new evaluation_method_shortcode();
