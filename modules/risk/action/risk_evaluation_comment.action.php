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

class risk_evaluation_comment_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_risk
	*/
	public function __construct() {
		add_action( 'save_risk_evaluation_comment', array( $this, 'callback_save_risk_evaluation_comment' ) );
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
	public function callback_save_risk_evaluation_comment() {
    $list_comment = !empty( $_POST['list_comment'] ) ? (array) $_POST['list_comment' ] : array();

		$risk_evaluation_id = risk_evaluation_class::get()->get_last_entry();
		$risk_id = risk_class::get()->get_last_entry();

		if ( !empty( $_POST['risk_id'] ) ) {
			$risk_id = (int) $_POST['risk_id'];
		}

		if ( !empty( $list_comment ) ) {
		  foreach ( $list_comment as $key => $element ) {
				if ( !empty( $element['comment_content'] ) ) {
					$data = array(
						'author_id' => get_current_user_id(),
						'parent_id' => $risk_evaluation_id,
						'post_id' => $risk_id,
						'status' => '-34070',
						'date' => sanitize_text_field( date_util::get()->formatte_date( $element['comment_date'] ) ),
						'content' => sanitize_text_field( $element['comment_content'] ),
					);

					if ( !empty( $element['comment_id'] ) ) {
						$data['id'] = (int)  $element['comment_id'];
					}

					risk_evaluation_comment_class::get()->update( $data );
				}
		  }
		}

		do_action( 'save_risk_evaluation_method' );
	}
}

new risk_evaluation_comment_action();
