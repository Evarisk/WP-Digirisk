<?php namespace digi;
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

class comment_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_risk
	*/
	public function __construct() {
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
  * Enregistres le commentaire d'une evaluation d'un risque
  * Ce callback est hoocké après wp_ajax_save_risk de risk_save_action
  *
  * string $_POST['comment_date'] La date du commentaire
  * string $_POST['comment_content'] Le contenu du commentaire
	*
  * @param array $_POST Les données envoyées par le formulaire
  */
 	public function callback_delete_comment() {
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$id = (int)$_POST['id'];

		$comment = comment_class::g()->get( array( 'id' => $id ) );
		$comment = $comment[0];

		if ( empty( $comment ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$comment->status = '-34071';

		comment_class::g()->update( $comment );

		wp_send_json_success( array( 'module' => 'comment', 'callback_success' => 'delete_success' ) );
	}
}

new comment_action();
