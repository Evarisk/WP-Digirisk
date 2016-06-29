<?php
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
	public function __construct() {
		add_shortcode( 'digi_evaluation_method', array( $this, 'callback_digi_evaluation_method' ) );
		add_shortcode( 'digi_evaluation_method_complex', array( $this, 'callback_evaluation_method_complex' ) );
	}

	/**
	* Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	*
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	* @param string $param['display'] La méthode d'affichage pour le template
	*
	* @author Jimmy Latour <jimmy.latour@gmail.com>
	*
	* @since 6.0.0.0
	*
	* @return void
	*/
	public function callback_digi_evaluation_method( $param ) {
		global $evaluation_method_class;
		global $wpdigi_risk_evaluation_ctr;
		global $wpdigi_risk_ctr;

		$display = !empty( $param['display'] ) ? sanitize_text_field( $param['display'] ) : 'edit';
		$risk_id = !empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;
		$term_evarisk_simple = get_term_by( 'slug', 'evarisk-simplified', $evaluation_method_class->get_taxonomy() );
		$term_evarisk_complex = get_term_by( 'slug', 'evarisk', $evaluation_method_class->get_taxonomy() );
		$scale = 1;
		$equivalence = 1;
		$digi_method_id = $term_evarisk_simple->term_id;
		$target = 'wp-digi-risk-cotation-chooser';

		if ( $risk_id != 0 ) {
			$risk = $wpdigi_risk_ctr->show( $risk_id );
			$risk_evaluation = $wpdigi_risk_evaluation_ctr->show( $risk->option['current_evaluation_id'] );
			$digi_method_id = $risk->taxonomy['digi-method'][0];
			$scale = !empty( $risk_evaluation->option['risk_level']['scale'] ) ? $risk_evaluation->option['risk_level']['scale'] : 0;
			$equivalence = !empty( $risk_evaluation->option['risk_level']['equivalence'] ) ? $risk_evaluation->option['risk_level']['equivalence'] : 0;

			if ( $digi_method_id === $term_evarisk_complex->term_id ) {
				$target = "wpdigi-method-evaluation-render";
			}
		}

    require( WPDIGI_EVALMETHOD_VIEW . $display . '-simple-evaluation-method.view.php' );
	}

	/**
	* Récupère le niveau et l'équivalence de la méthode d'évaluation complexe du risque courant.
	*
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	*
	* @author Jimmy Latour <jimmy.latour@gmail.com>
	*
	* @since 6.0.0.0
	*
	* @return void
	*/
	public function callback_evaluation_method_complex( $param ) {
		$term_evarisk = get_term_by( 'slug', 'evarisk', evaluation_method_class::get()->get_taxonomy() );
		$risk_id = !empty( $param['risk_id'] ) ? (int) $param['risk_id'] : 0;

		if ( !empty( $term_evarisk ) ) {
			$risk = risk_class::get()->show( $risk_id );
			$risk_evaluation = risk_evaluation_class::get()->show( $risk->option['current_evaluation_id'] );
			$evarisk_evaluation_method = evaluation_method_class::get()->show( $term_evarisk->term_id );
			$list_evaluation_method_variable = array();
			if ( !empty( $evarisk_evaluation_method->option['formula'] ) ) {
				foreach ( $evarisk_evaluation_method->option['formula'] as $key => $formula ) {
					if ( $key % 2 == 0 ) {
						$list_evaluation_method_variable[] = evaluation_method_variable_class::get()->show( $formula );
					}
				}
			}
		}

		require( EVALUATION_METHOD_VIEW_DIR . 'popup/popup.view.php' );
	}
}

new evaluation_method_shortcode();
