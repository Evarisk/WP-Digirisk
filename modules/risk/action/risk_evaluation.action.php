<?php
/**
* Enregistres l'évaluation d'un risque.
* Gères la méthode d'évaluation simple
* Géres la méthode d'évalution complexe
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_evaluation_action {
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 1 );
	}

	/**
  * Enregistres l'évaluation d'un risque
  *
  * @param int $_POST['risk_evaluation_level'] Le level de l'évaluation du risque
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  */
	public function callback_save_risk() {
		check_ajax_referer( 'save_risk' );

		ini_set("display_errors", true);
		error_reporting(E_ALL);

		global $wpdigi_evaluation_method_controller;
		global $wpdigi_risk_evaluation_ctr;

		$risk_evaluation_level = !empty( $_POST['risk_evaluation_level'] ) ? (int) $_POST['risk_evaluation_level'] : 0;
		$method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

    if ( $risk_evaluation_level === 0 || $method_evaluation_id === 0 ) {
      wp_send_json_error();
    }

		$method_evaluation_digirisk_simplified = get_term_by( 'slug', 'evarisk-simplified', $wpdigi_evaluation_method_controller->get_taxonomy() );
		$method_evaluation_digirisk_complex = get_term_by( 'slug', 'evarisk', $wpdigi_evaluation_method_controller->get_taxonomy() );

		$data = array();

		if ( $method_evaluation_id == $method_evaluation_digirisk_simplified->term_id ) {
			$data = $this->update_method_simplified( $risk_evaluation_level );
		}
		else if ( $method_evaluation_id == $method_evaluation_digirisk_complex->term_id ) {
			$data = $this->update_method_complex( $method_evaluation_digirisk_complex->term_id );
		}

		// Récupère la dernière clé unique
		$last_unique_key = wpdigi_utils::get_last_unique_key( 'comment', $wpdigi_risk_evaluation_ctr->get_type() );
		$new_unique_key = $last_unique_key + 1;

		$data['option']['unique_key'] = $new_unique_key;
		$data['option']['unique_identifier'] = 'E' . $new_unique_key;

		$wpdigi_risk_evaluation_ctr->update( $data );
	}

	/**
  * Prépares les données pour la méthode simplifiée
  *
  * @param int $risk_evaluation_level Le level de l'évaluation du risque
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
	* @return array : @todo : A détailler
  */
	public function update_method_simplified( $risk_evaluation_level ) {
		global $wpdigi_evaluation_method_controller;
		// Récupère la variable de la méthode simplifiée
		$term_method_variable = get_term_by( 'slug', 'evarisk', evaluation_method_variable_class::get()->get_taxonomy() );

		// Le niveau du risque + la force du risque par rapport à son level
		$risk_level = array(
			'method_result' => $risk_evaluation_level,
			'equivalence' => evaluation_method_class::get()->list_scale[$risk_evaluation_level],
			'scale' => $risk_evaluation_level
		);

		// Les détails de la cotation
		$quotation_detail = array(
			'variable_id' => $term_method_variable->term_id,
			'value' => $risk_evaluation_level
		);

		// Les options de l'évaluation
		$option = array(
			'risk_level' => $risk_level,
			'quotation_detail' => $quotation_detail
		);

		// Les données de l'évaluation
		$data = array(
			'option' => $option
		);

		return $data;
	}

	/**
  * Prépares les données pour la méthode d'évaluation complexe
  *
  * @param int $term_id L'ID de la méthode évaluation complexe
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
	* @return array : @todo : A détailler
  */
	public function update_method_complex( $term_id ) {
		global $wpdigi_evaluation_method_controller;

		$risk_evaluation_level = 1;

		$list_variable = !empty( $_POST['variable'] ) ? (array) $_POST['variable'] : array();

		if ( !empty( $list_variable ) ) {
		  foreach ( $list_variable as $element ) {
				$risk_evaluation_level *= (int) $element;
		  }
		}

		$evaluation_method = evaluation_method_class::get()->show( $term_id );
		$equivalence = $evaluation_method->option['matrix'][$risk_evaluation_level];
		$scale = scale_util::get()->get_scale( $equivalence );

		$risk_level = array(
			'method_result' => $risk_evaluation_level,
			'equivalence' => $equivalence,
			'scale' => $scale
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
			'option' => $option
		);

		return $data;
	}
}

new risk_evaluation_action();
