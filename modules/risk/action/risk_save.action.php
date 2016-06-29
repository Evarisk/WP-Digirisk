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

class risk_save_action {
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 2 );
	}

	/**
  * Enregistres un risque.
	* Ce callback est appelé après le callback callback_save_risk de risk_evaluation_action
  *
  * @param int $_POST['establishment']['establishment_id'] L'id de l'établissement
  * @param int $_POST['danger_id'] L'id du danger
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
	public function callback_save_risk() {
		ini_set("display_errors", true);

		global $wpdigi_risk_ctr;
		global $wpdigi_risk_evaluation_ctr;
		global $wpdigi_danger_ctr;
		global $file_management_class;

		$ctr = !empty( $_POST['global'] ) ? sanitize_text_field( $_POST['global'] ) : '';
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;
		global ${$ctr};

		if ( 0 === $element_id || 0 === $method_evaluation_id ) {
			wp_send_json_error();
		}

		$data = array( 'option' => array() );

		// Si risk id existe
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;
		$risk = $wpdigi_risk_ctr->show( $risk_id );

		$file_id = !empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;

		// Charge le danger
		$danger_id = !empty( $_POST['danger_id'] ) ? (int) $_POST['danger_id'] : 0;
		$danger = $wpdigi_danger_ctr->show( $danger_id );

    $last_unique_key = wpdigi_utils::get_last_unique_key( 'post', $wpdigi_risk_ctr->get_post_type() );
    $unique_key = $last_unique_key + 1;

		// Charge l'évaluation créer dans le callback callback_save_risk de risk_evaluation_action
		$evaluation_id = $wpdigi_risk_evaluation_ctr->get_last_entry();
		$evaluation = $wpdigi_risk_evaluation_ctr->show( $evaluation_id );

		// L'unique identifier du risque et de l'évaluation
		$unique_identifier = $wpdigi_risk_ctr->element_prefix . $unique_key . ' - ' . $evaluation->option['unique_identifier'];

		// Les données du risque
		if ( $risk_id === 0 ) {
			$risk->title = $danger->name;
			$risk->taxonomy['digi-danger'][] = $danger_id;
			$risk->taxonomy['digi-danger-category'][] = $danger->parent_id;
			$risk->option['unique_key'] = $unique_key;
			$risk->option['unique_identifier'] = $unique_identifier;
			$risk->parent_id = $element_id;
			$risk->author_id = get_current_user_id();
			$risk->option['risk_date'] = array(
				'start' => current_time( 'mysql' ),
				'end' => current_time( 'mysql' )
			);
			// @TODO : Le type du modèle est pas le bon quand on utilise la méthode show()
			$risk->type = $wpdigi_risk_ctr->get_post_type();
			$risk->taxonomy['digi-method'][] = $method_evaluation_id;
			unset( $risk->id );
		}
		else {
			$risk->option['unique_identifier'] = $wpdigi_risk_ctr->element_prefix . $risk->option['unique_key'] . ' - ' . $evaluation->option['unique_identifier'];
		}

		$risk->option['current_evaluation_id'] = $evaluation_id;
		$risk->option['associated_evaluation'][] =  $evaluation_id;

		$risk = $wpdigi_risk_ctr->update( $risk );

		if ( $risk->id === 0 ) {
			wp_send_json_error();
		}

		if ( $file_id != 0 ) {
			$file_management_class->associate_file( $file_id, $risk->id, 'wpdigi_risk_ctr' );
		}


		// Ajoutes le risque à l'établissement
		$element = ${$ctr}->show( $element_id );
		$element->option['associated_risk'][] = $risk->id;
		${$ctr}->update( $element );
	}
}

new risk_save_action();
