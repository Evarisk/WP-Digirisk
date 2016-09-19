<?php if ( !defined( 'ABSPATH' ) ) exit;

class epi_class extends post_class {

	protected $model_name   = 'epi_model';
	protected $post_type    = 'digi-epi';
	protected $meta_key    	= '_wpdigi_epi';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to epi from WP Rest API	*/
	protected $base = 'digiepi/epi';
	protected $version = '0.1';

	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );
	public $element_prefix = 'EPI';

	protected $limit_epi = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for epis management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );
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
		register_post_type( $this->post_type, $args );
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		require( EPI_VIEW_DIR . 'main.view.php' );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for epis through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_epi_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$epi_list = epi_class::g()->get( array( 'post_parent' => $society->id ), array( false ) );

		require( EPI_VIEW_DIR . 'list.view.php' );
	}
}
