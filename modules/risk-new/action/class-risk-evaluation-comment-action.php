<?php
/**
 * Enregistres les commentaires des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enregistres les commentaires des risques
 */
class Risk_Evaluation_Comment_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'save_risk_evaluation_comment', array( $this, 'callback_save_risk_evaluation_comment' ), 10, 2 );
	}

	/**
	 * Enregistres le commentaire d'une evaluation d'un risque
	 * Ce callback est hoocké après wp_ajax_save_risk de risk_save_action
	 *
	 * @param array $risk_obj Les données du risque.
	 * @param array $risk     Les données envoyées par le formulaire.
	 *
	 * @since 6.0.0
	 */
	public function callback_save_risk_evaluation_comment( $risk_obj, $risk ) {
		do_action( 'display_risk', $_POST['parent_id'], $risk_obj );
	}
}

new Risk_Evaluation_Comment_Action();
