<?php namespace digi;
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package epi
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class epi_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-epi
	* wp_ajax_wpdigi-load-epi
	* wp_ajax_wpdigi-edit-epi
	*/
	public function __construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for epis management	*/
		add_action( 'init', array( $this, 'custom_post_type' ), 5 );

		add_action( 'wp_ajax_edit_epi', array( $this, 'ajax_edit_epi' ) );
		add_action( 'wp_ajax_wpdigi-delete-epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'ajax_load_epi' ) );
		add_action( 'wp_ajax_wpdigi-edit-epi', array( $this, 'ajax_edit_epi' ) );
	}

	/**
	* Déclares le post type: risque
	*/
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create epi : main element 	*/
		$labels = array(
			'name'                => __( 'Risks', 'digiepi' ),
			'singular_name'       => __( 'Risk', 'digiepi' ),
			'menu_name'           => __( 'Risks', 'digiepi' ),
			'name_admin_bar'      => __( 'Risks', 'digiepi' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digiepi' ),
			'all_items'           => __( 'Risks', 'digiepi' ),
			'add_new_item'        => __( 'Add epi', 'digiepi' ),
			'add_new'             => __( 'Add epi', 'digiepi' ),
			'new_item'            => __( 'New epi', 'digiepi' ),
			'edit_item'           => __( 'Edit epi', 'digiepi' ),
			'update_item'         => __( 'Update epi', 'digiepi' ),
			'view_item'           => __( 'View epi', 'digiepi' ),
			'search_items'        => __( 'Search epi', 'digiepi' ),
			'not_found'           => __( 'Not found', 'digiepi' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'digiepi' ),
		);
		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'Digiepi epi', 'digiepi' ),
			'description'         => __( 'Manage epis into digiepi', 'digiepi' ),
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
		register_post_type( epi_class::g()->get_post_type(), $args );
	}

	public function ajax_edit_epi() {
		check_ajax_referer( 'edit_epi' );

		if ( !empty( $_POST['epi'] ) ) {
		  foreach ( $_POST['epi'] as $element ) {
				$element['parent_id'] = $_POST['parent_id'];
				epi_class::g()->update( $element );
		  }
		}

		ob_start();
		epi_class::g()->display( $_POST['parent_id'] );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_epi() {
		if ( 0 === (int)$_POST['epi_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$epi_id = (int)$_POST['epi_id'];

		check_ajax_referer( 'ajax_delete_epi_' . $epi_id );

		$epi = epi_class::g()->get( array( 'id' => $epi_id ) );
		$epi = $epi[0];

		if ( empty( $epi ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$epi->status = 'trash';

		epi_class::g()->update( $epi );

		wp_send_json_success();
	}

	/**
	* Charges un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_epi() {
		$epi_id = !empty( $_POST['epi_id'] ) ? (int)$_POST['epi_id'] : 0;

		check_ajax_referer( 'ajax_load_epi_' . $epi_id );
		$epi = epi_class::g()->get( array( 'include' => $epi_id ) );
		$epi = $epi[0];
		$society_id = $epi->parent_id;

		ob_start();
		view_util::exec( 'epi', 'item-edit', array( 'society_id' => $society_id, 'epi' => $epi, 'epi_id' => $epi_id ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new epi_action();
