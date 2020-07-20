<?php
/**
 * Gestion des actions dans les commentaires
 *
 * @author Evarisk <dev@evarisk.com>
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
 * Gestion des actions dans les commentaires
 */
class Comment_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.3
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_comment', array( $this, 'callback_save_comment' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
	 * Sauvegardes un commentaire
	 *
	 * @since 6.2.3
	 * @version 6.4.4
	 *
	 * @return void
	 */
	public function callback_save_comment() {
		check_ajax_referer( 'save_comment' );

		$type         = ! empty( $_POST['type'] ) ? $_POST['type'] : '';
		$namespace    = ! empty( $_POST['namespace'] ) ? $_POST['namespace'] : '';
		$display      = ! empty( $_POST['display'] ) ? $_POST['display'] : 'edit';
		$id           = ! empty( $_POST['id'] ) ? $_POST['id'] : 0;
		$add_button   = isset( $_POST['add_button'] ) ? (int) $_POST['add_button'] : 1;
		$display_date = ! empty( $_POST['display_date'] ) ? 'true' : 'false';
		$display_user = ! empty( $_POST['display_user'] ) ? 'true' : 'false';

		$model_name = '\\' . $namespace . '\\' . $type . '_Class';

		$comment = array(
			'post_id'   => (int) $_POST['list_comment'][0]['post_id'],
			'author_id' => (int) $_POST['list_comment'][0]['author_id'],
			'date'      => ! empty( $_POST['list_comment'][0]['date'] ) ? sanitize_text_field( $_POST['list_comment'][0]['date'] ) : current_time( 'mysql' ),
			'content'   => $_POST['list_comment'][0]['content'],
		);

		$object = $model_name::g()->update( $comment );

		ob_start();
		do_shortcode( '[digi_comment id="' . (int) $_POST['list_comment'][0]['post_id'] . '" namespace="' . $namespace . '" type="' . $type . '" display="edit" display_date="' . $display_date . '" display_user="' . $display_user . '"]' );
		wp_send_json_success( array(
			'view'             => ob_get_clean(),
			'namespace'        => 'digirisk',
			'module'           => 'comment',
			'callback_success' => 'saved_comment_success',
			'object'           => $object,
		) );
	}

	/**
	 * Supprimes un commentaire.
	 *
	 * @since 6.0.0
	 */
	public function callback_delete_comment() {
		check_ajax_referer( 'ajax_delete_comment' );

		$id           = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$type         = ! empty( $_POST['type'] ) ? $_POST['type'] : '';
		$namespace    = ! empty( $_POST['namespace'] ) ? $_POST['namespace'] : '';
		$model_name   = '\\' . $namespace . '\\' . $type . '_class';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$comment = $model_name::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $comment ) ) {
			wp_send_json_error();
		}

		$comment->data['status'] = 'trash';
		$model_name::g()->update( $comment->data );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'comment',
			'callback_success' => 'delete_success',
			'object'           => $comment,
		) );
	}
}

new Comment_Action();
