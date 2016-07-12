<?php if ( !defined( 'ABSPATH' ) ) exit;

class danger_action {

	/**
	* Ajoutes l'action init
	*/
	public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ), 1 );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les dangers / Create wordpress element type for managing dangers
	 *
	 * @uses register_taxonomy()
	 */
	function callback_init() {
		$labels = array(
			'name'                       => _x( 'Dangers', 'digirisk' ),
			'singular_name'              => _x( 'Danger', 'digirisk' ),
			'search_items'               => __( 'Search Dangers', 'digirisk' ),
			'popular_items'              => __( 'Popular Dangers', 'digirisk' ),
			'all_items'                  => __( 'All Dangers', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Danger', 'digirisk' ),
			'update_item'                => __( 'Update Danger', 'digirisk' ),
			'add_new_item'               => __( 'Add New Danger', 'digirisk' ),
			'new_item_name'              => __( 'New Danger Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate dangers with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove dangers', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used dangers', 'digirisk' ),
			'not_found'                  => __( 'No dangers found.', 'digirisk' ),
			'menu_name'                  => __( 'Dangers', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'danger' ),
		);

		register_taxonomy( danger_class::get()->get_taxonomy(), array( risk_class::get()->get_post_type() ), $args );

	}
}

new danger_action();
