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
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_risk
	*/
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'ajax_save_risk' ) );
	}

	/**
  * Enregistres l'évaluation d'un risque
  *
  * int $_POST['risk_evaluation_level'] Le level de l'évaluation du risque
  *
  * @param array $_POST Les données envoyées par le formulaire
  *
  */
	public function ajax_save_risk() {
		// todo
		// check_ajax_referer( 'ajax_save_risk' );

		$risk_evaluation_level = !empty( $_POST['risk_evaluation_level'] ) ? (int) $_POST['risk_evaluation_level'] : 0;
		$method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

    if ( $risk_evaluation_level === 0 || $method_evaluation_id === 0 ) {
      wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
    }

		$method_evaluation_digirisk_simplified = get_term_by( 'slug', 'evarisk-simplified', evaluation_method_class::g()->get_taxonomy() );
		$method_evaluation_digirisk_complex = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );

		if ( $method_evaluation_id != $method_evaluation_digirisk_simplified->term_id && $method_evaluation_id != $method_evaluation_digirisk_complex->term_id ) {
			wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
		}

		$data = array();

		if ( $method_evaluation_id == $method_evaluation_digirisk_simplified->term_id ) {
			$data = $this->update_method_simplified( $risk_evaluation_level );

			if ( !$data ) {
				wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
			}
		}
		else if ( $method_evaluation_id == $method_evaluation_digirisk_complex->term_id ) {
			$data = $this->update_method_complex( $method_evaluation_digirisk_complex->term_id );

			if ( !$data ) {
				wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
			}
		}

		$risk_evaluation = risk_evaluation_class::g()->update( $data );

		do_action( 'save_risk', $risk_evaluation->id );
	}

	/**
  * Prépares les données pour la méthode simplifiée
  *
  * @param int $risk_evaluation_level Le level de l'évaluation du risque
  *
  */
	public function update_method_simplified( $risk_evaluation_level ) {
		// Récupère la variable de la méthode simplifiée
		$term_method_variable = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );

		if ( $risk_evaluation_level < 0 || $risk_evaluation_level > 4 ) {
			return false;
		}

		// Le niveau du risque + la force du risque par rapport à son level
		$risk_level = array(
			'method_result' => $risk_evaluation_level,
			'equivalence' => evaluation_method_class::g()->list_scale[$risk_evaluation_level],
		);

		// Les détails de la cotation
		$quotation_detail = array(
			'variable_id' => $term_method_variable->term_id,
			'value' => $risk_evaluation_level
		);

		// Les données de l'évaluation
		$data = array(
			'scale' => $risk_evaluation_level,
			'risk_level' => $risk_level,
			'quotation_detail' => $quotation_detail,
		);

		return $data;
	}

	/**
  * Prépares les données pour la méthode d'évaluation complexe
  *
  * @param int $term_id L'ID de la méthode évaluation complexe
  *
  */
	public function update_method_complex( $term_id ) {

		$risk_evaluation_level = 1;

		$list_variable = !empty( $_POST['variable'] ) ? (array) $_POST['variable'] : array();

		if ( empty( $list_variable ) ) {
			return false;
		}

		if ( !empty( $list_variable ) ) {
		  foreach ( $list_variable as $element ) {
				if ( (int) $element < 0 || (int) $element > 5 ) {
					return false;
				}
				$risk_evaluation_level *= (int) $element;
		  }
		}

		$evaluation_method = evaluation_method_class::g()->get( array( 'id' => $term_id ) );
		if ( $risk_evaluation_level < 0 || $risk_evaluation_level > max( array_keys( $evaluation_method[0]->matrix ) ) ) {
			return false;
		}

		$equivalence = $evaluation_method[0]->matrix[$risk_evaluation_level];
		$scale = scale_util::get_scale( $equivalence );

		$risk_level = array(
			'method_result' => $risk_evaluation_level,
			'equivalence' => $equivalence,
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
			'scale' => $scale,
			'risk_level' => $risk_level,
			'quotation_detail' => $quotation_detail,
		);

		return $data;
	}
}

new risk_evaluation_action();
