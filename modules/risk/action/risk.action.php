<?php
/**
 * Les actions relatives aux risques.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
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
	 * @version 6.2.4
	 */
	public function __construct() {
		add_action( 'display_risk', array( $this, 'callback_display_risk' ), 10, 2 );
		add_action( 'wp_ajax_delete_risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_load_risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
	 * Affiches un risque.
	 *
	 * @param  integer    $society_id L'ID de la société.
	 * @param  Risk_Model $risk       Les données du risque.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.4.4
	 */
	public function callback_display_risk( $society_id, $risk ) {
		$module           = 'risk';
		$callback_success = 'savedRiskSuccess';
		$template         = '';
		$page             = ! empty( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : '';

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
	 * @version 6.4.4
	 */
	public function ajax_delete_risk() {
		check_ajax_referer( 'ajax_delete_risk' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$risk = Risk_Class::g()->get( array(
			'id' => $id,
		) );
		$risk = $risk[0];

		if ( empty( $risk ) ) {
			wp_send_json_error();
		}

		$risk->status = 'trash';

		Risk_Class::g()->update( $risk );

		do_action( 'digi_add_historic', array(
			'parent_id' => $risk->parent_id,
			'id'        => $risk->id,
			'content'   => __( 'Suppression du risque', 'digirisk' ) . ' ' . $risk->unique_identifier,
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
	 * @version 6.2.9.0
	 */
	public function ajax_load_risk() {
		check_ajax_referer( 'ajax_load_risk' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$risk = Risk_Class::g()->get( array( 'id' => $id ) );
		$risk = $risk[0];

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'item-edit', array( 'society_id' => $risk->parent_id, 'risk' => $risk ) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'risk',
			'callback_success' => 'loadedRiskSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un commentaire sur un risque (met le status du commentaire à "trash")
	 *
	 * @since 6.0.0
	 * @version 6.2.4.0
	 */
	public function callback_delete_comment() {
		check_ajax_referer( 'ajax_delete_risk_comment' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$risk_id = ! empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;

		$risk_evaluation_comment = Risk_Evaluation_Comment_Class::g()->get( array( 'id' => $id ) );
		$risk_evaluation_comment = $risk_evaluation_comment[0];
		$risk_evaluation_comment->status = 'trash';
		Risk_Evaluation_Comment_Class::g()->update( $risk_evaluation_comment );

		wp_send_json_success();
	}
}

new Risk_Action();
