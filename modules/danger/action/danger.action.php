<?php if ( !defined( 'ABSPATH' ) ) exit;

class danger_action {

	/**
	* Le constructeur appelle l'action WordPress suivante: init (Pour déclarer la taxonomy danger)
	*/
	public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ), 1 );
	}

	/**
	 * Déclares la taxonomy danger
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

		register_taxonomy( danger_class::g()->get_taxonomy(), array( risk_class::g()->get_post_type() ), $args );
	}
}

new danger_action();
