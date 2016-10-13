<?php namespace digi;
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
		add_action( 'wp_ajax_edit_risk', array( $this, 'ajax_edit_risk' ) );
	}

	/**
  * Enregistres l'évaluation d'un risque
  *
  * int $_POST['risk_evaluation_level'] Le level de l'évaluation du risque
  *
  * @param array $_POST Les données envoyées par le formulaire
  *
  */
	public function ajax_edit_risk() {
		$list_risk = !empty( $_POST['risk'] ) ? $_POST['risk'] : array();

		if ( empty( $list_risk ) ) {
			wp_send_json_success();
		}

		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $key => &$risk ) {
				if ( isset( $risk['id'] ) ) {
					$risk['evaluation']['method_id'] = max( $risk['taxonomy']['digi-method'] );
					$risk['evaluation']['variable'] = $risk['variable'];
					$risk['evaluation'] = risk_evaluation_class::g()->update( $risk['evaluation'] );

					if ( $risk['evaluation'] ) {
						$risk['current_evaluation_id'] = $risk['evaluation']->id;
					}
					else {
						unset( $list_risk[$key] );
					}
				}
		  }
		}

		do_action( 'save_risk', $list_risk );
	}
}

new risk_evaluation_action();
