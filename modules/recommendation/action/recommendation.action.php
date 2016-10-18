<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
		add_action( 'wp_ajax_save_recommendation', array( $this, 'ajax_save_recommendation' ) );
		add_action( 'wp_ajax_load_recommendation', array( $this, 'ajax_load_recommendation' ) );
		add_action( 'wp_ajax_delete_recommendation', array( $this, 'ajax_delete_recommendation' ) );
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
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_load_recommendation_' . $id );

		$recommendation = recommendation_class::g()->get( array( 'id' => $id ), array() );
		$recommendation = $recommendation[0];

		ob_start();
		view_util::exec( 'recommendation', 'item-edit', array( 'society_id' => $recommendation->parent_id, 'recommendation' => $recommendation ), array( '\digi\recommendation_category_term', '\digi\recommendation_term' ) );
		wp_send_json_success( array( 'module' => 'recommendation', 'callback_success' => 'load_recommendation_success', 'template' => ob_get_clean() ) );
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
	public function ajax_save_recommendation() {
		$recommendation_term = recommendation_term_class::g()->get( array( 'include' => $_POST['taxonomy']['digi-recommendation'] ) );
		$recommendation_term = $recommendation_term[0];
		$_POST['taxonomy']['digi-recommendation-category'][] = $recommendation_term->parent_id;
		$recommendation = recommendation_class::g()->update( $_POST );

		if ( !empty( $_POST['list_comment'] ) ) {
		  foreach ( $_POST['list_comment'] as $element ) {
				$element['post_id'] = $recommendation->id;
				recommendation_comment_class::g()->update( $element );
		  }
		}

		ob_start();
		recommendation_class::g()->display( $recommendation->parent_id );
		wp_send_json_success( array( 'module' => 'recommendation', 'callback_success' => 'save_recommendation_success', 'template' => ob_get_clean() ) );
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
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_delete_recommendation_' . $id );

		$recommendation = recommendation_class::g()->get( array( 'id' => $id ) );
		$recommendation = $recommendation[0];

		if ( empty( $recommendation ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$recommendation->status = 'trash';

		recommendation_class::g()->update( $recommendation );

		wp_send_json_success( array( 'module' => 'recommendation', 'callback_success' => 'delete_recommendation_success', 'template' => ob_get_clean() ) );
	}
}

new recommendation_action();
