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
	public function callback_save_risk( $risk_evaluation_id ) {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

		if ( 0 === $method_evaluation_id ) {
			wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
		}

		$data = array( 'option' => array() );

		// Si risk id existe
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;
		$risk = risk_class::g()->get( array( 'id' => $risk_id ) );

		$file_id = !empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;

		// Charge le danger
		$danger_id = !empty( $_POST['danger_id'] ) ? (int) $_POST['danger_id'] : 0;
		$danger = danger_class::g()->get( array( 'id' => $danger_id ) );

		// if ( $danger->id === 0 ) {
		// 	wp_send_json_error( array( 'file' => __FILE__, 'line' => __LINE__ ) );
		// }

		// Charge l'évaluation créer dans le callback callback_save_risk de risk_evaluation_action
		$evaluation = risk_evaluation_class::g()->get( array( 'id' => $risk_evaluation_id ) );

		// Les données du risque
		if ( $risk_id === 0 ) {
			$risk[0]->title = $danger[0]->name;
			$risk[0]->taxonomy['digi-danger'][] = $danger[0]->id;
			$risk[0]->taxonomy['digi-danger-category'][] = $danger[0]->parent_id;
			$risk[0]->parent_id = $element_id;
			$risk[0]->author_id = get_current_user_id();
			// $risk[0]->option['risk_date'] = array(
			// 	'start' => current_time( 'mysql' ),
			// 	'end' => current_time( 'mysql' )
			// );
			$risk[0]->taxonomy['digi-method'][] = $method_evaluation_id;
			unset( $risk[0]->id );
		}

		$risk[0]->current_evaluation_id = $risk_evaluation_id;

		$risk = risk_class::g()->update( $risk[0] );

		if ( $risk->id !== 0 ) {
			$evaluation[0]->post_id = $risk->id;
			risk_evaluation_class::g()->update( $evaluation[0] );
		}

		if ( $file_id !== 0 ) {
			file_management_class::g()->associate_file( $file_id, $risk->id, 'risk_class' );
		}

		do_action( 'save_risk_evaluation_comment', $risk->id, $risk_evaluation_id );
	}
}

new risk_save_action();
