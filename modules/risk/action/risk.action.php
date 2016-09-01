<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* callback_display_risk
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-risk
	* wp_ajax_wpdigi-load-risk
	* wp_ajax_wpdigi-edit-risk
	* wp_ajax_delete_comment
	*/
	public function __construct() {
		// Remplacé les - en _
		add_action( 'display_risk', array( $this, 'callback_display_risk' ), 10, 1 );
		add_action( 'wp_ajax_wpdigi-delete-risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_wpdigi-load-risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
  * Enregistres un risque.
	* Ce callback est le dernier de l'action "save_risk"
  *
	* int $_POST['element_id'] L'ID de l'élement ou le risque sera affecté
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_display_risk( $society_id ) {
		ob_start();
		risk_class::g()->display( $society_id );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_risk() {
		// todo : global
		if ( 0 === (int)$_POST['risk_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['risk_id'];

		check_ajax_referer( 'ajax_delete_risk_' . $risk_id );

		$risk = risk_class::g()->get( array( 'id' => $risk_id ) );
		$risk = $risk[0];

		if ( empty( $risk ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$risk->status = 'trash';

		risk_class::g()->update( $risk );

		wp_send_json_success();
	}

	/**
	* Charges un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_risk() {
		if ( 0 === (int)$_POST['risk_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['risk_id'];

		check_ajax_referer( 'ajax_load_risk_' . $risk_id );

		$risk = risk_class::g()->get( array( 'id' => $risk_id ), array( 'danger_category', 'danger', 'evaluation', 'comment' ) );
		$risk = $risk[0];

		ob_start();
		require( RISK_VIEW_DIR . 'list-item-edit.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un commentaire sur un risque (met le status du commentaire à "trash")
	*
	* int $_POST['id'] L'ID du commentaire
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_delete_comment() {
		$id = !empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;

		check_ajax_referer( 'ajax_delete_risk_comment_' . $risk_id . '_' . $id );

		$risk_evaluation_comment = risk_evaluation_comment_class::g()->get( array( 'id' => $id ) );
		$risk_evaluation_comment = $risk_evaluation_comment[0];
		$risk_evaluation_comment->status = 'trash';
		risk_evaluation_comment_class::g()->update( $risk_evaluation_comment );

		wp_send_json_success();
	}
}

new risk_action();
