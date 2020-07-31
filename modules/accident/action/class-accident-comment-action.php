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
class Accident_Comment_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'save_accident_comment', array( $this, 'callback_save_accident_comment' ), 10, 2 );
	}

	/**
	 * Enregistres le commentaire d'une evaluation d'un risque
	 * Ce callback est hoocké après wp_ajax_save_accident de accident_save_action
	 *
	 * @param array $accident_obj Les données du risque.
	 * @param array $accident     Les données envoyées par le formulaire.
	 *
	 * @since 6.0.0
	 */
	public function callback_save_accident_comment( $risk_obj, $risk ) {
		do_action( 'display_accident', $_POST['parent_id'], $risk_obj );
	}
}

new Accident_Comment_Action();
