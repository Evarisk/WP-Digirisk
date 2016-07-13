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
	/**
	* Le constructeur appelle la méthode personnalisé: save_risk
	*/
	public function __construct() {
		add_action( 'save_risk', array( $this, 'callback_save_risk' ), 1 );

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
	public function callback_save_risk() {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

		if ( 0 === $method_evaluation_id ) {
			wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
		}

		$data = array( 'option' => array() );

		// Si risk id existe
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;
		$risk = risk_class::get()->show( $risk_id );

		$file_id = !empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;

		// Charge le danger
		$danger_id = !empty( $_POST['danger_id'] ) ? (int) $_POST['danger_id'] : 0;
		$danger = danger_class::get()->show( $danger_id );

		if ( $danger->id === 0 ) {
			wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
		}

    $last_unique_key = wpdigi_utils::get_last_unique_key( 'post', risk_class::get()->get_post_type() );
    $unique_key = $last_unique_key + 1;

		// Charge l'évaluation créer dans le callback callback_save_risk de risk_evaluation_action
		$evaluation_id = risk_evaluation_class::get()->get_last_entry();
		$evaluation = risk_evaluation_class::get()->show( $evaluation_id );

		// L'unique identifier du risque et de l'évaluation
		$unique_identifier = risk_class::get()->element_prefix . $unique_key;

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
			$risk->type = risk_class::get()->get_post_type();
			$risk->taxonomy['digi-method'][] = $method_evaluation_id;
			unset( $risk->id );
		}
		else {
			$risk->option['unique_identifier'] = risk_class::get()->element_prefix . $risk->option['unique_key'];
		}

		$risk->option['current_evaluation_id'] = $evaluation_id;
		$risk->option['associated_evaluation'][] =  $evaluation_id;

		$risk = risk_class::get()->update( $risk );

		if ( $file_id != 0 ) {
			file_management_class::get()->associate_file( $file_id, $risk->id, 'wpdigi_risk_ctr' );
		}

		do_action( 'save_risk_evaluation_comment' );
	}
}

new risk_save_action();
