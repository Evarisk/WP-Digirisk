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

class risk_evaluation_comment_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_risk
	*/
	public function __construct() {
		add_action( 'save_risk_evaluation_comment', array( $this, 'callback_save_risk_evaluation_comment' ), 10, 2 );
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
 	public function callback_save_risk_evaluation_comment( $risk_obj, $risk ) {
		if ( isset( $risk['id'] ) ) {
			if ( !empty( $risk['list_comment'] ) ) {
			  foreach ( $risk['list_comment'] as $comment ) {
					$comment['post_id'] = $risk['id'];
					risk_evaluation_comment_class::g()->update( $comment );
			  }
			}
		}

		do_action( 'display_risk', $_POST['parent_id'] );
	}
}

new risk_evaluation_comment_action();
