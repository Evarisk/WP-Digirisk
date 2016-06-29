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
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 2 );
	}

	/**
  * Enregistres le commentaire d'une evaluation d'un risque
  * Ce callback est hoocké après wp_ajax_save_risk de risk_evaluation_action
  *
  * @param string $_POST['comment_date'] La date du commentaire
  * @param string $_POST['comment_content'] Le contenu du commentaire
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  */
	public function callback_save_risk() {
		check_ajax_referer( 'save_risk' );

		global $wpdigi_risk_evaluation_ctr;
		global $wpdigi_risk_evaluation_comment_ctr;
		global $wpdigi_risk_ctr;

    $list_comment_content = !empty( $_POST['comment_content'] ) ? (array) $_POST['comment_content' ] : array();
    $list_comment_date = !empty( $_POST['comment_date'] ) ? (array) $_POST['comment_date' ] : array();
    $list_comment_id = !empty( $_POST['comment_id'] ) ? (array) $_POST['comment_id' ] : array();

		$risk_evaluation_id = $wpdigi_risk_evaluation_ctr->get_last_entry();
		$risk_id = $wpdigi_risk_ctr->get_last_entry();

		if ( !empty( $list_comment_content ) ) {
		  foreach ( $list_comment_content as $key => $element ) {
				if ( !empty( $element ) ) {
					// On change les slasles dans la date en virgule
					$comment_date = str_replace( '/', ',', $list_comment_date[$key] );

					$data = array(
						'author_id' => get_current_user_id(),
						'parent_id' => $risk_evaluation_id,
						'post_id' => $risk_id,
						'status' => '-34070',
						'date' => sanitize_text_field( $comment_date ),
						'content' => sanitize_text_field( $element ),
					);

					if ( $list_comment_id[$key] != 0 ) {
						$data['id'] = (int) $list_comment_id[$key];
					}

					$wpdigi_risk_evaluation_comment_ctr->update( $data );
				}
		  }
		}
	}
}

new risk_evaluation_comment_action();
