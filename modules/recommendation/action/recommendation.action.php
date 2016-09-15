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
class recommendation_action {

	public $unique_identifier = 'PA';
	/**
	 * Le constructeur appelle les méthodes ajax suivantes:
	 * wp_ajax_wpdigi-create-recommendation
	 * wp_ajax_wpdigi-delete-recommendation
	 * wp_ajax_wpdigi-load-recommendation
	 * wp_ajax_wpdigi-edit-recommendation
	 */
	function __construct() {
		add_action( 'wp_ajax_wpdigi-create-recommendation', array( $this, 'ajax_create_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-delete-recommendation', array( $this, 'ajax_delete_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-load-recommendation', array( $this, 'ajax_load_recommendation' ), 12 );
		add_action( 'wp_ajax_wpdigi-edit-recommendation', array( $this, 'ajax_edit_recommendation' ), 12 );
	}

	/**
	* Créer une recommendation
	*
	* int $_POST['workunit_id'] L'ID de l'unité de travail
	* int $_POST['recommendation_id'] L'ID de la recommendation
	* string $_POST['recommendation_comment'] Le commentaire de la recommendation
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	function ajax_create_recommendation() {
		check_ajax_referer( 'ajax_create_recommendation' );

		if (  0 === (int) $_POST['workunit_id'] )
			wp_send_json_error();
		else
			$workunit_id = (int) $_POST['workunit_id'];

		$workunit = society_class::g()->show_by_type( $workunit_id );

		if (  0 === (int) $_POST['recommendation_id'] )
			wp_send_json_error();
		else
			$recommendation_id = (int) $_POST['recommendation_id'];

		// Récupèration des l'identifiant unique
		$unique_identifier = get_option( recommendation_class::g()->last_affectation_index_key, 0 );
		$unique_identifier++;
		update_option( recommendation_class::g()->last_affectation_index_key, $unique_identifier );

		$recommendation_in_workunit = array(
			'status' 			=> 'valid',
			'unique_key' 		=> $unique_identifier,
			'unique_identifier' => $this->unique_identifier . $unique_identifier,
			'efficiency' 		=> 0,
			'comment'			=> sanitize_text_field( stripslashes($_POST['recommendation_comment'] ) ),
			'type'				=> '',
			'affectation_date'	=> current_time( 'mysql' ),
			'last_update_date'	=> current_time( 'mysql' ),
		);

		$workunit->associated_recommendation[$recommendation_id][] = $recommendation_in_workunit;

		society_class::g()->update_by_type( $workunit );

		$term = recommendation_class::g()->get( array( 'id' => $recommendation_id ) );
		$term = $term[0];
		$term_id = $term->id;
		$index = count( $workunit->associated_recommendation[$recommendation_id] ) - 1;
		$element = new stdClass();
		$element->id = $workunit_id;

		ob_start();
		require( DIGI_RECOM_TEMPLATES_MAIN_DIR . 'list-item.php' );

		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Charges une recommendation
	*
	* int $_POST['workunit_id'] L'ID de l'unité de travail
	* int $_POST['term_id'] L'ID de la recommendation
	* int $_POST['index'] L'index du tableau
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
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

		check_ajax_referer( 'ajax_load_recommendation_' . $term_id. '_' . $index );

		$workunit = society_class::g()->show_by_type( $workunit_id );
		$recommendation_in_workunit = $workunit->associated_recommendation[$term_id][$index];
		$list_recommendation_category = recommendation_category_class::g()->get();

		$term = recommendation_class::g()->get( array( 'id' => $term_id ) );
		$term = $term[0];

		ob_start();
		require( DIGI_RECOM_TEMPLATES_MAIN_DIR . 'list-item-edit.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Edites une recommendation
	*
	* int $_POST['workunit_id'] L'ID de l'unité de travail
	* int $_POST['term_id'] L'ID de la recommendation
	* int $_POST['index'] L'index du tableau
	* string $_POST['recommendation_comment'] Le commentaire de la recommendation
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
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

		check_ajax_referer( 'ajax_edit_recommendation_' . $term_id . '_' . $index );

		$workunit = society_class::g()->show_by_type( $workunit_id );

		$workunit->associated_recommendation[$term_id][$index]['comment'] = $_POST['recommendation_comment'];
		$workunit->associated_recommendation[$term_id][$index]['last_update_date'] = current_time( 'mysql' );

		society_class::g()->update_by_type( $workunit );

		$term = recommendation_class::g()->get( array( 'id' => $term_id ) );
		$term = $term[0];
		$recommendation_in_workunit = $workunit->associated_recommendation[$term_id][$index];
		$element = new StdClass();
		$element->id = $workunit_id;

		ob_start();
		require( DIGI_RECOM_TEMPLATES_MAIN_DIR . 'list-item.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes une recommendation (Passes son status en "deleted" dans le tableau)
	*
	* int $_POST['workunit_id'] L'ID de l'unité de travail
	* int $_POST['term_id'] L'ID de la recommendation
	* int $_POST['index'] L'index du tableau
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
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

		check_ajax_referer( 'ajax_delete_recommendation_' . $term_id . '_' . $index );
		$workunit = society_class::g()->show_by_type( $workunit_id );

		$workunit->associated_recommendation[$term_id][$index]['status'] = 'deleted';
		society_class::g()->update_by_type( $workunit );

		wp_send_json_success();
	}
}

new recommendation_action();
