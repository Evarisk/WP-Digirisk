<?php
/**
 * Gères l'action AJAX de la génération du DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action AJAX de la génération du DUER
 */
class DUER_Action {

	/**
	 * Le constructeur
	 */
	function __construct() {
		add_action( 'init', array( $this, 'custom_type_creation' ) );

		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
	}

	 /**
 	* Déclares le post type: risque
 	*/
 	function custom_type_creation() {
 		/**	Créé les sociétés: élément principal / Create risk : main element 	*/
 		$labels = array(
 			'name'                => __( 'DUERS', 'digirisk' ),
 			'singular_name'       => __( 'DUER', 'digirisk' ),
 			'menu_name'           => __( 'DUERS', 'digirisk' ),
 			'name_admin_bar'      => __( 'DUERS', 'digirisk' ),
 			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
 			'all_items'           => __( 'DUERS', 'digirisk' ),
 			'add_new_item'        => __( 'Add DUER', 'digirisk' ),
 			'add_new'             => __( 'Add DUER', 'digirisk' ),
 			'new_item'            => __( 'New DUER', 'digirisk' ),
 			'edit_item'           => __( 'Edit DUER', 'digirisk' ),
 			'update_item'         => __( 'Update DUER', 'digirisk' ),
 			'view_item'           => __( 'View DUER', 'digirisk' ),
 			'search_items'        => __( 'Search DUER', 'digirisk' ),
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
 			'label'               => __( 'Digirisk DUER', 'digirisk' ),
 			'description'         => __( 'Manage DUERS into digirisk', 'digirisk' ),
 			'labels'              => $labels,
 			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', ),
 			'hierarchical'        => true,
 			'public'              => true,
 			'show_ui'             => true,
 			'show_in_menu'        => false,
 			'show_in_admin_bar'   => false,
 			'show_in_nav_menus'   => false,
 			'can_export'          => true,
 			'has_archive'         => true,
 			'exclude_from_search' => true,
 			'publicly_queryable'  => true,
 			'rewrite'             => $rewrite,
 			'capability_type'     => 'page',
 		);
 		register_post_type( DUER_Class::g()->get_post_type(), $args );
 	}

	/**
	 * La méthode qui gère la réponse de la requête.
	 * Cette méthode appelle la méthode generate de DUER_Generate_Class.
	 *
	 * @return void
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'callback_ajax_generate_duer' );
		$duer = DUER_Generate_Class::g()->generate( $_POST );
		wp_send_json_success( array( 'module' => 'DUER', 'callback_success' => 'callback_generate_duer_success', 'duer' => $duer ) );
	}
}

new DUER_Action();
