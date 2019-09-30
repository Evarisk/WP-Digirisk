<?php
/**
 * Les actions relatives aux risques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux risques.
 */
class Risk_Action {

	/**
	 * Le constructeur appelle une action personnalisée:
	 * callback_display_risk
	 * Il appelle également les actions ajax suivantes:
	 * wp_ajax_wpdigi-delete-risk
	 * wp_ajax_wpdigi-load-risk
	 * wp_ajax_wpdigi-edit-risk
	 * wp_ajax_delete_comment
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'display_risk', array( $this, 'callback_display_risk' ), 10, 2 );
		add_action( 'wp_ajax_delete_risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_load_risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
		add_action( 'wp_ajax_move_risk_to', array( $this, 'callback_move_risk_to' ) );
	}

	/**
	 * Affiches un risque.
	 *
	 * @param  integer    $society_id L'ID de la société.
	 * @param  Risk_Model $risk       Les données du risque.
	 * @return void
	 *
	 * @since 6.0.0
	 */
	public function callback_display_risk( $society_id, $risk ) {
		$module           = 'risk';
		$callback_success = 'savedRiskSuccess';
		$template         = '';
		$page             = ! empty( $_POST['page'] ) ? sanitize_text_field( wp_unslash( $_POST['page'] ) ) : ''; // WPCS: input var ok, CSRF ok.

		if ( 'all_risk' === $page ) {
			$module = 'risk_page';

			ob_start();
			$risk = Risk_Class::g()->get( array(
				'id' => $risk->id,
			), true );

			$risk->parent = Society_Class::g()->show_by_type( $risk->parent_id );
			if ( 'digi-group' === $risk->parent->type ) {
				$risk->parent_group = $risk->parent;
			} else {
				$risk->parent_workunit = $risk->parent;
				$risk->parent_group    = Society_Class::g()->show_by_type( $risk->parent_workunit->parent_id );
			}

			\eoxia\View_Util::exec( 'digirisk', 'risk', '/page/item-edit', array(
				'risk' => $risk,
			) );
			$template = ob_get_clean();

		} elseif ( 'setting_risk' === $page ) {
			$module = 'setting';

			ob_start();
			$risk = Risk_Class::g()->get( array(
				'id' => $risk->id,
			), true );

			\eoxia\View_Util::exec( 'digirisk', 'setting', '/preset/item', array(
				'danger' => $risk,
			) );
			$template = ob_get_clean();

		} else {
			ob_start();
			Risk_Class::g()->display( $society_id );
			$template = ob_get_clean();
		} // End if().

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => $module,
			'callback_success' => $callback_success,
			'template'         => $template,
			'risk'             => $risk,
		) );
	}

	/**
	 * Supprimes un risque
	 *
	 * @since 6.0.0
	 */
	public function ajax_delete_risk() {
		check_ajax_referer( 'ajax_delete_risk' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$risk = Risk_Class::g()->get( array( 'id' => $id ), true );

		$risk->data['status'] = 'trash';

		Risk_Class::g()->update( $risk->data );

		do_action( 'digi_add_historic', array(
			'parent_id' => $risk->data['parent_id'],
			'id'        => $risk->data['id'],
			'content'   => __( 'Suppression du risque', 'digirisk' ) . ' ' . $risk->data['unique_identifier'],
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'risk',
			'callback_success' => 'deletedRiskSuccess',
			'risk'             => $risk,
		) );
	}

	/**
	 * Charges un risque
	 *
	 * @since 6.0.0
	 */
	public function ajax_load_risk() {
		check_ajax_referer( 'ajax_load_risk' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$can_edit_risk_category = (bool) get_option( 'edit_risk_category', false );

		$risk = Risk_Class::g()->get( array( 'id' => $id ), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'item-edit', array(
			'society_id'             => $risk->data['parent_id'],
			'risk'                   => $risk,
			'can_edit_risk_category' => $can_edit_risk_category,
		) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'risk',
			'callback_success' => 'loadedRiskSuccess',
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un commentaire sur un risque (met le status du commentaire à "trash")
	 *
	 * @since 6.0.0
	 */
	public function callback_delete_comment() {
		check_ajax_referer( 'ajax_delete_risk_comment' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$risk_evaluation_comment                 = Risk_Evaluation_Comment_Class::g()->get( array( 'id' => $id ), true );
		$risk_evaluation_comment->data['status'] = 'trash';
		Risk_Evaluation_Comment_Class::g()->update( $risk_evaluation_comment->data );

		wp_send_json_success();
	}

	/**
	 * Déplaces un risque vers une autre société.
	 *
	 * @since 7.1.0
	 */
	public function callback_move_risk_to() {
		$risk_id       = ! empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;
		$to_society_id = ! empty( $_POST['to_society_id'] ) ? (int) $_POST['to_society_id'] : 0;

		if ( empty( $risk_id ) || empty( $to_society_id ) ) {
			wp_send_json_error();
		}

		$risk                    = Risk_Class::g()->get( array( 'id' => $risk_id ), true );
		$risk->data['parent_id'] = $to_society_id;
		Risk_Class::g()->update( $risk->data );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'risk',
			'callback_success' => 'movedRiskSuccess',
		) );
	}
}

new Risk_Action();
