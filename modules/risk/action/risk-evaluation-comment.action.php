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

						if ( empty( $comment['parent_id'] ) ) {
							$comment['parent_id'] = $risk_obj->current_evaluation_id;
						}

						if ( empty( $risk['id'] ) ) {
							unset( $comment['id'] );
						}

						Risk_Evaluation_Comment_Class::g()->update( $comment );

						do_action( 'digi_add_historic', array(
							'parent_id' => $_POST['parent_id'],
							'id' => $risk_obj->id,
							'content' => __( 'Modification du risque ', 'digirisk' ) . ' ' . $risk_obj->unique_identifier . ' ' . __( 'ajout du commentaire: ', 'digirisk' ) . ' ' . $comment['content'],
						) );
					}
				}
			}
		}

		do_action( 'display_risk', $_POST['parent_id'], $risk_obj );
	}
}

new Risk_Evaluation_Comment_Action();
