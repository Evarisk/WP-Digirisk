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

class risk_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* callback_display_risk
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-risk
	* wp_ajax_wpdigi-load-risk
	* wp_ajax_wpdigi-edit-risk
	* wp_ajax_delete_comment
	*/
	public function __construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for risks management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );
		// Remplacé les - en _
		add_action( 'display_risk', array( $this, 'callback_display_risk' ), 10, 1 );
		add_action( 'wp_ajax_delete_risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_wpdigi-load-risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
	* Déclares le post type: risque
	*/
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create risk : main element 	*/
		$labels = array(
			'name'                => __( 'Risks', 'digirisk' ),
			'singular_name'       => __( 'Risk', 'digirisk' ),
			'menu_name'           => __( 'Risks', 'digirisk' ),
			'name_admin_bar'      => __( 'Risks', 'digirisk' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => __( 'Risks', 'digirisk' ),
			'add_new_item'        => __( 'Add risk', 'digirisk' ),
			'add_new'             => __( 'Add risk', 'digirisk' ),
			'new_item'            => __( 'New risk', 'digirisk' ),
			'edit_item'           => __( 'Edit risk', 'digirisk' ),
			'update_item'         => __( 'Update risk', 'digirisk' ),
			'view_item'           => __( 'View risk', 'digirisk' ),
			'search_items'        => __( 'Search risk', 'digirisk' ),
			'not_found'           => __( 'Not found', 'digirisk' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'digirisk' ),
		);
		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'Digirisk risk', 'digirisk' ),
			'description'         => __( 'Manage risks into digirisk', 'digirisk' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);
		register_post_type( risk_class::g()->get_post_type(), $args );
	}


	/**
  * Enregistres un risque.
	* Ce callback est le dernier de l'action "save_risk"
  *
	* int $_POST['element_id'] L'ID de l'élement ou le risque sera affecté
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_display_risk( $society_id ) {
		ob_start();
		risk_class::g()->display( $society_id );
		wp_send_json_success( array( 'module' => 'risk', 'callback_success' => 'save_risk_success', 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_risk() {
		// todo : global
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_delete_risk_' . $id );

		$risk = risk_class::g()->get( array( 'id' => $id ) );
		$risk = $risk[0];

		if ( empty( $risk ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$risk->status = 'trash';

		risk_class::g()->update( $risk );

		wp_send_json_success( array( 'module' => 'risk', 'callback_success' => 'delete_success' ) );
	}

	/**
	* Charges un risque
	*
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_risk() {
		if ( 0 === (int)$_POST['risk_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['risk_id'];

		check_ajax_referer( 'ajax_load_risk_' . $risk_id );

		$risk = risk_class::g()->get( array( 'id' => $risk_id ), array( 'danger_category', 'danger', 'evaluation', 'comment' ) );
		$risk = $risk[0];

		ob_start();
		view_util::exec( 'risk', 'item-edit', array( 'risk_id' => $risk_id, 'risk' => $risk ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un commentaire sur un risque (met le status du commentaire à "trash")
	*
	* int $_POST['id'] L'ID du commentaire
	* int $_POST['risk_id'] L'ID du risque
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_delete_comment() {
		$id = !empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;

		check_ajax_referer( 'ajax_delete_risk_comment_' . $risk_id . '_' . $id );

		$risk_evaluation_comment = risk_evaluation_comment_class::g()->get( array( 'id' => $id ) );
		$risk_evaluation_comment = $risk_evaluation_comment[0];
		$risk_evaluation_comment->status = 'trash';
		risk_evaluation_comment_class::g()->update( $risk_evaluation_comment );

		wp_send_json_success();
	}
}

new risk_action();
