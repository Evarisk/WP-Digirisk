<?php
/**
 * Les actions relatives à la sauvegarde des risques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives à la sauvegarde des risques
 */
class Risk_Save_Action {

	/**
	 * Le constructeur appelle la méthode personnalisé: save_risk
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_edit_risk', array( $this, 'callback_edit_risk' ) );
	}

	/**
	 * Enregistres un risque.
	 *
	 * @since 6.0.0
	 */
	public function callback_edit_risk() {
		check_ajax_referer( 'edit_risk' );

		$id                   = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id            = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		$from_preset          = ! empty( $_POST['from_preset'] ) ? (int) $_POST['from_preset'] : 0;
		$page                 = ! empty( $_POST['page'] ) ? sanitize_text_field( wp_unslash( $_POST['page'] ) ) : '';
		$risk_category_id     = ! empty( $_POST['risk_category_id'] ) ? (int) $_POST['risk_category_id'] : 0;
		$evaluation_method_id = ! empty( $_POST['evaluation_method_id'] ) ? (int) $_POST['evaluation_method_id'] : 0;
		$comments             = ! empty( $_POST['list_comment'] ) ? (array) $_POST['list_comment'] : array();
		$image                = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;

		$risk_data = array(
			'id'        => $id,
			'parent_id' => $parent_id,
		);

		$risk = Risk_Class::g()->save( $risk_data, $risk_category_id, $evaluation_method_id );

		if ( ! empty( $risk->errors ) ) {
			wp_send_json_error( $risk->errors );
		}

		$evaluation_method_variables = ! empty( $_POST['evaluation_variables'] ) ? wp_unslash( (string) $_POST['evaluation_variables'] ) : '';
		$evaluation_method_variables = json_decode( $evaluation_method_variables, true );

		$risk_evaluation = Risk_Evaluation_Class::g()->save( $risk->data['id'], $evaluation_method_id, $evaluation_method_variables );

		if ( $from_preset ) {
			if ( ! empty( $comments ) ) {
				foreach ( $comments as &$comment ) {
					$comment['id']      = 0;
					$comment['post_id'] = $risk->data['id'];
				}
			}
		}

		$risk->data['current_equivalence'] = $risk_evaluation->data['equivalence'];

		$risk = Risk_Class::g()->update( $risk->data );

		Risk_Evaluation_Comment_Class::g()->save( $risk, $comments );

		if ( ! empty( $image ) && empty( $id ) ) {
			$args = array(
				'id'         => $risk->data['id'],
				'model_name' => '\digi\Risk_Class',
				'field_name' => 'image',
				'file_id'    => $image,
			);

			\eoxia\WPEO_Upload_Class::g()->set_thumbnail( $args );
			\eoxia\WPEO_Upload_Class::g()->associate_file( $args );
		}

		do_action( 'digi_add_historic', array(
			'parent_id' => $parent_id,
			'id'        => $risk->data['id'],
			// translators: Mise à jour du risque R1.
			'content'   => sprintf( __( 'Mise à jour du risque %s', 'digirisk' ), $risk->data['unique_identifier'] ),
		) );

		$module = 'risk';

		ob_start();
		if ( 'all_risk' === $page ) {
			$module = 'risk_page';
			\eoxia\View_Util::exec( 'digirisk', 'risk', 'page/item-edit', array(
				'risk' => $risk,
			) );
		} elseif ( 'setting_risk' === $page ) {
			$module = 'setting';
			\eoxia\View_Util::exec( 'digirisk', 'setting', 'preset/item', array(
				'risk' => $risk,
			) );
		} else {
			Risk_Class::g()->display( $risk->data['parent_id'] );
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => $module,
			'risk'             => $risk->data,
			'callback_success' => 'savedRiskSuccess',
			'template'         => ob_get_clean(),
		) );
	}
}

new Risk_Save_Action();
