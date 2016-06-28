<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de controlle des requêtes  ajax pour les recommendations / Recommendation' ajax request main class
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de controlle des requêtes ajax pour les recommendations / Recommendation' ajax request main class
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class recommendation_action_01 extends wpdigi_recommendation_ctr_01 {

	public $unique_identifier = 'PA';
	/**
	 * CORE - Instanciation des actions ajax pour les recommendation / Instanciate ajax treatment for recommendation
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_asset' ) );
		add_action( 'wp_ajax_wpdigi-create-recommendation', array( $this, 'ajax_create_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-delete-recommendation', array( $this, 'ajax_delete_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-load-recommendation', array( $this, 'ajax_load_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-edit-recommendation', array( $this, 'ajax_edit_recommendation' ), 12 );
	}

	public function admin_asset() {
		wp_enqueue_script( 'wpdigi-recommendation-backend-js', WPDIGI_EVALUATOR_URL . 'asset/js/backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
	}

	function ajax_create_recommendation() {
		wpdigi_utils::check( 'ajax_create_recommendation' );

		if (  0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		global $wpdigi_workunit_ctr;
		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		if (  0 === (int) $_POST['recommendation_id'] )
			wp_send_json_error();
		else
			$recommendation_id = (int) $_POST['recommendation_id'];

		global $digi_recommendation_controller;

		// Récupèration des l'identifiant unique
		$unique_identifier = get_option( $digi_recommendation_controller->last_affectation_index_key );
		$unique_identifier++;
		update_option( $digi_recommendation_controller->last_affectation_index_key, $unique_identifier );

		$recommendation_in_workunit = array(
				'status' 			=> 'valid',
				'unique_key' 		=> $unique_identifier,
				'unique_identifier' => $this->unique_identifier . $unique_identifier,
				'efficiency' 		=> 0,
				'comment'			=> sanitize_text_field( $_POST['recommendation_comment'] ),
				'type'				=> '',
				'affectation_date'	=> current_time( 'mysql' ),
				'last_update_date'	=> current_time( 'mysql' ),
		);

		$workunit->option['associated_recommendation'][$recommendation_id][] = $recommendation_in_workunit;

		$wpdigi_workunit_ctr->update( $workunit );

		$term = $digi_recommendation_controller->show( $recommendation_id );
		$term_id = $term->id;
		$index = count( $workunit->option['associated_recommendation'][$recommendation_id] ) - 1;
		$element = new stdClass();
		$element->id = $workunit_id;

		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_RECOM_DIR, DIGI_RECOM_TEMPLATES_MAIN_DIR, '', 'list', 'item' ) );

		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_load_recommendation() {
		if (  0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		if (  0 === (int) $_POST['term_id'] )
			wp_send_json_error();
		else
			$term_id = (int) $_POST['term_id'];

		if ( !isset( $_POST['index'] ) )
			wp_send_json_error();
		else
			$index = (int) $_POST['index'];

		wpdigi_utils::check( 'ajax_load_recommendation_' . $term_id. '_' . $index );

		global $wpdigi_workunit_ctr;
		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );
		$recommendation_in_workunit = $workunit->option['associated_recommendation'][$term_id][$index];
		global $digi_recommendation_category_controller;
		global $digi_recommendation_controller;
		$list_recommendation_category = $digi_recommendation_category_controller->index();

		$term = $digi_recommendation_controller->show( $term_id );

		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_RECOM_DIR, DIGI_RECOM_TEMPLATES_MAIN_DIR, '', 'list', 'item-edit' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_edit_recommendation() {
		if (  0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		if (  0 === (int) $_POST['term_id'] )
			wp_send_json_error();
		else
			$term_id = (int) $_POST['term_id'];

		if ( !isset( $_POST['index'] ) )
			wp_send_json_error();
		else
			$index = (int) $_POST['index'];

		wpdigi_utils::check( 'ajax_edit_recommendation_' . $term_id . '_' . $index );

		global $digi_recommendation_controller;

		global $wpdigi_workunit_ctr;
		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		$workunit->option['associated_recommendation'][$term_id][$index]['comment'] = $_POST['recommendation_comment'];
		$workunit->option['associated_recommendation'][$term_id][$index]['last_update_date'] = current_time( 'mysql' );

		$wpdigi_workunit_ctr->update( $workunit );

		global $digi_recommendation_controller;
		$term = $digi_recommendation_controller->show( $term_id );
		$recommendation_in_workunit = $workunit->option['associated_recommendation'][$term_id][$index];
		$element = new StdClass();
		$element->id = $workunit_id;

		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_RECOM_DIR, DIGI_RECOM_TEMPLATES_MAIN_DIR, '', 'list', 'item' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_delete_recommendation() {
		if (  0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		if (  0 === (int) $_POST['term_id'] )
			wp_send_json_error();
		else
			$term_id = (int) $_POST['term_id'];

		if ( !isset( $_POST['index'] ) )
			wp_send_json_error();
		else
			$index = (int) $_POST['index'];

		wpdigi_utils::check( 'ajax_delete_recommendation_' . $term_id . '_' . $index );

		global $digi_recommendation_controller;

		global $wpdigi_workunit_ctr;
		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		$workunit->option['associated_recommendation'][$term_id][$index]['status'] = 'deleted';
		$wpdigi_workunit_ctr->update( $workunit );

		wp_send_json_success();
	}
}

new recommendation_action_01();
