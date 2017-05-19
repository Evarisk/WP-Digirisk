<?php
/**
 * Gestion des actions dans les commentaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des actions dans les commentaires
 */
class Comment_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_comment', array( $this, 'callback_save_comment' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
	 * Sauvegardes un commentaire
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.9.0
	 */
	public function callback_save_comment() {
		check_ajax_referer( 'save_comment' );

		$type = ! empty( $_POST['type'] ) ? $_POST['type'] : '';
		$model_name = '\digi\\' . $type . '_class';

		$comment = array(
			'post_id' => (int) $_POST['list_comment'][0]['post_id'],
			'author_id' => (int) $_POST['list_comment'][0]['author_id'],
			'date' => sanitize_text_field( $_POST['list_comment'][0]['date'] ),
			'content' => sanitize_text_field( $_POST['list_comment'][0]['content'] ),
		);

		$model_name::g()->update( $comment );

		ob_start();
		do_shortcode( '[digi_comment id="' . (int) $_POST['list_comment'][0]['post_id'] . '" type="' . $type . '" display="edit"]' );
		wp_send_json_success( array(
			'view' => ob_get_clean(),
			'namespace' => 'digirisk',
			'module' => 'comment',
			'callback_success' => 'saved_comment_success',
		) );
	}

	/**
	 * Supprimes un commentaire en le passant au status -34071 au lieu de -34072
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_delete_comment() {
		check_ajax_referer( 'ajax_delete_comment_' . $_POST['id'] );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$comment = Comment_Class::g()->get( array(
			'id' => $id,
		) );
		$comment = $comment[0];

		if ( empty( $comment ) ) {
			wp_send_json_error();
		}

		$comment->status = '-34071';

		Comment_Class::g()->update( $comment );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'comment',
			'callback_success' => 'delete_success',
		) );
	}
}

new Comment_Action();
