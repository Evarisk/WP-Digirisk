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

class risk_save_action {
	/**
	* Le constructeur appelle la méthode personnalisé: save_risk
	*/
	public function __construct() {
		add_action( 'save_risk', array( $this, 'callback_save_risk' ), 10, 1 );
	}

	/**
  * Enregistres un risque.
	* Ce callback est appelé après le callback callback_save_risk de risk_evaluation_action
  *
  * int $_POST['establishment']['establishment_id'] L'id de l'établissement
  * int $_POST['danger_id'] L'id du danger
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_save_risk( $list_posted_risk ) {
		$parent_id = !empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( !empty( $list_posted_risk ) ) {
		  foreach ( $list_posted_risk as &$posted_risk ) {
				if ( isset( $posted_risk['id'] ) ) {
					$danger = danger_class::g()->get( array( 'include' => $posted_risk['danger_id'] ) );
					$danger = $danger[0];

					$image_id = 0;
					
					if ( !empty( $posted_risk['associated_document_id'] ) ) {
						$image_id = $posted_risk['associated_document_id']['image'][0];
					}

					$posted_risk['title'] = $danger->name;
					$posted_risk['parent_id'] = $parent_id;
					$posted_risk['taxonomy']['digi-danger'][] = $danger->id;
					$posted_risk['taxonomy']['digi-danger-category'][] = $danger->parent_id;

					$risk = risk_class::g()->update( $posted_risk );

					if ( !$risk ) {
						wp_send_json_error();
					}

					$posted_risk['id'] = $risk->id;

					$risk_evaluation = risk_evaluation_class::g()->update( array( 'id' => $risk->current_evaluation_id, 'post_id' => $risk->id ) );

					if ( !$risk_evaluation ) {
						wp_send_json_error();
					}

					if ( !empty( $image_id ) ) {
						file_management_class::g()->associate_file( $image_id, $risk->id, 'risk_class' );
					}
			  }
			}
		}

		do_action( 'save_risk_evaluation_comment', $list_posted_risk );
	}
}

new risk_save_action();
