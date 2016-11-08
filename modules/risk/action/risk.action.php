<?php namespace digi;
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
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
		add_action( 'display_risk', array( $this, 'callback_display_risk' ), 10, 2 );
		add_action( 'wp_ajax_delete_risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_load_risk', array( $this, 'ajax_load_risk' ) );
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
	public function callback_display_risk( $society_id, $risk ) {
		$module = "risk";
		$callback_success = "save_risk_success";
		$template = '';
		$page = !empty( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : '';

		if ( $page == 'all_risk' ) {
			$module = "risk_page";
			ob_start();
			$risk = risk_class::g()->get( array( 'include' => $risk->id ),  array( 'comment', 'evaluation_method', 'evaluation', 'danger_category', 'danger' ) );
			$risk = $risk[0];
			$risk->parent = society_class::g()->show_by_type( $risk->parent_id );
			if ( $risk->parent->type == 'digi-group' ) {
				$risk->parent_group = $risk->parent;
			}
			else {
				$risk->parent_workunit = $risk->parent;
				$risk->parent_group = society_class::g()->show_by_type( $risk->parent_workunit->parent_id );
			}

			view_util::exec( 'risk', '/page/item-edit', array( 'risk' => $risk ) );
			$template = ob_get_clean();
		}
		else {
			ob_start();
			risk_class::g()->display( $society_id );
			$template = ob_get_clean();
		}

		wp_send_json_success( array( 'module' => $module, 'callback_success' => $callback_success, 'template' => $template ) );
	}

	/**
	* Supprimes un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_risk() {
		if ( 0 === (int)$_POST['id'] )
		wp_send_json_error( array( 'error' => __LINE__, ) );
		else
		$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_delete_risk_' . $id );

		$risk = risk_class::g()->get( array( 'id' => $id ) );
		$risk = $risk[0];

		if ( empty( $risk ) )
		wp_send_json_error( array( 'error' => __LINE__ ) );

		$risk->status = 'trash';

		risk_class::g()->update( $risk );

		wp_send_json_success( array( 'module' => 'risk', 'callback_success' => 'delete_success' ) );
	}

	/**
	* Charges un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_risk() {
		if ( 0 === (int)$_POST['id'] )
		wp_send_json_error( array( 'error' => __LINE__, ) );
		else
		$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_load_risk_' . $id );

		$risk = risk_class::g()->get( array( 'id' => $id ), array( 'danger_category', 'danger', 'evaluation', 'comment' ) );
		$risk = $risk[0];

		ob_start();
		view_util::exec( 'risk', 'item-edit', array( 'society_id' => $risk->parent_id, 'risk' => $risk ) );
		wp_send_json_success( array( 'module' => 'risk', 'callback_success' => 'load_success', 'template' => ob_get_clean() ) );
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
