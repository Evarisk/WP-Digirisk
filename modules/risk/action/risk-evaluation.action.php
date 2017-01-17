<?php namespace digi;
/**
* Enregistres l'évaluation d'un risque.
* Gères la méthode d'évaluation simple
* Géres la méthode d'évalution complexe
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2017 Evarisk
* @package risk
* @subpackage action
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux évaluations des risques.
 */
class Risk_Evaluation_Action {
	/**
	 * Le constructeur appelle l'action ajax: wp_ajax_save_risk
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_edit_risk', array( $this, 'ajax_edit_risk' ) );
	}

	/**
	 * Enregistres l'évaluation d'un risque
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	*/
	public function ajax_edit_risk() {
		$risk = !empty( $_POST['risk'] ) ? $_POST['risk'] : array();

		// Cette action vérifie que la variable $_POST['can_update'] est à true. (Utile pour la page "Tous les risques").
		do_action( 'can_update' );

		if ( empty( $risk ) ) {
			wp_send_json_error();
		}

		if ( isset( $risk['id'] ) ) {
			$risk['evaluation']['method_id'] = max( $risk['taxonomy']['digi-method'] );

			if ( !empty( $risk['variable'] ) ) {
				$risk['evaluation']['variable'] = $risk['variable'];
			}

			$risk['evaluation'] = Risk_Evaluation_Class::g()->update( $risk['evaluation'] );

			if ( $risk['evaluation'] ) {
				$risk['current_evaluation_id'] = $risk['evaluation']->id;
			}
			else {
				unset( $list_risk[$key] );
			}
		}

		do_action( 'save_risk', $risk );
	}
}

new Risk_Evaluation_Action();
