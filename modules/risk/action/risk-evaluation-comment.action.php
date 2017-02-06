<?php
/**
 * Enregistres les commentaires des risques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enregistres les commentaires des risques
 */
class Risk_Evaluation_Comment_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'save_risk_evaluation_comment', array( $this, 'callback_save_risk_evaluation_comment' ), 10, 2 );
	}

	/**
	 * Enregistres le commentaire d'une evaluation d'un risque
	 * Ce callback est hoocké après wp_ajax_save_risk de risk_save_action
	 *
	 * @param array $risk_obj Les données envoyées par le formulaire.
	 * @param array $risk     Les données du risque.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_save_risk_evaluation_comment( $risk_obj, $risk ) {
		if ( isset( $risk_obj->id ) ) {
			if ( ! empty( $_POST['list_comment'] ) ) {
				foreach ( $_POST['list_comment'] as $comment ) {
					if ( ! empty( $comment['content'] ) ) {
						$comment['post_id'] = $risk_obj->id;
						Risk_Evaluation_Comment_Class::g()->update( $comment );
					}
				}
			}
		}

		do_action( 'display_risk', $_POST['parent_id'], $risk_obj );
	}
}

new Risk_Evaluation_Comment_Action();
