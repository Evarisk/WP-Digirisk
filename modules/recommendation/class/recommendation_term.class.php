<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_term_class extends term_class {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = '\digi\recommendation_term_model';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-recommendation';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_recommendation';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/recommendation-term';
	protected $version = '0.1';
	public $element_prefix = 'RE';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $last_affectation_index_key = '_wpdigi_last_recommendation_affectation_unique_key';

	/**
	* Le constructeur
	*/
	protected function construct() {
		/**	Define taxonomy for recommendation	*/
		add_action( 'init', array( $this, 'recommendation_type' ), 0 );
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Déclares la taxonomy recommendation
	*/
	function recommendation_type() {
		$labels = array(
			'name'                       => _x( 'Recommendations', 'digirisk' ),
			'singular_name'              => _x( 'Recommendation', 'digirisk' ),
			'search_items'               => __( 'Search recommendations', 'digirisk' ),
			'popular_items'              => __( 'Popular recommendations', 'digirisk' ),
			'all_items'                  => __( 'All recommendations', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit recommendation', 'digirisk' ),
			'update_item'                => __( 'Update recommendation', 'digirisk' ),
			'add_new_item'               => __( 'Add New recommendation', 'digirisk' ),
			'new_item_name'              => __( 'New recommendation Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate recommendations with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove recommendations', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used recommendations', 'digirisk' ),
			'not_found'                  => __( 'No recommendations found.', 'digirisk' ),
			'menu_name'                  => __( 'Recommendations', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'recommendation' ),
			'update_count_callback' => '_update_generic_term_count',
		);

		register_taxonomy( $this->taxonomy, array( 'risk', 'societies' ), $args );

	}


}

recommendation_term_class::g();
?>
