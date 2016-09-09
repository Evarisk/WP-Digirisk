<?php if ( !defined( 'ABSPATH' ) ) exit;

class chemical_product_class extends post_class {

	protected $model_name   = 'chemical_product_model';
	protected $post_type    = 'digi-chemical_product';
	protected $meta_key    	= '_wpdigi_chemical_product';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to chemical_product from WP Rest API	*/
	protected $base = 'digirisk/chemical_product';
	protected $version = '0.1';

	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );
	public $element_prefix = 'PC';

	protected $limit_chemical_product = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for chemical_products management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );
	}

	/**
	* Déclares le post type: risque
	*/
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create chemical_product : main element 	*/
		$labels = array(
			'name'                => __( 'Chemical products', 'digirisk' ),
			'singular_name'       => __( 'Chemical product', 'digirisk' ),
			'menu_name'           => __( 'Chemical products', 'digirisk' ),
			'name_admin_bar'      => __( 'Chemical products', 'digirisk' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => __( 'Chemical products', 'digirisk' ),
			'add_new_item'        => __( 'Add chemical_product', 'digirisk' ),
			'add_new'             => __( 'Add chemical_product', 'digirisk' ),
			'new_item'            => __( 'New chemical_product', 'digirisk' ),
			'edit_item'           => __( 'Edit chemical_product', 'digirisk' ),
			'update_item'         => __( 'Update chemical_product', 'digirisk' ),
			'view_item'           => __( 'View chemical_product', 'digirisk' ),
			'search_items'        => __( 'Search chemical_product', 'digirisk' ),
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
			'label'               => __( 'Digichemical_product chemical_product', 'digirisk' ),
			'description'         => __( 'Manage chemical_products into digirisk', 'digirisk' ),
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
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for chemical_products through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_chemical_product_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$chemical_product_list = chemical_product_class::g()->index( array( 'post_parent' => $society->id ) );

		if ( !empty( $chemical_product_list ) ) {
		  foreach ( $chemical_product_list as $key => $element ) {
				$chemical_product_list[$key] = $this->get_chemical_product( $element->id );
		  }
		}

		// Tries les risques par ordre de cotation
		if ( count( $chemical_product_list ) > 1 ) {
			usort( $chemical_product_list, function( $a, $b ) {
				if( $a->evaluation->option[ 'chemical_product_level' ][ 'equivalence' ] == $b->evaluation->option[ 'chemical_product_level' ][ 'equivalence' ] ) {
					return 0;
				}
				return ( $a->evaluation->option[ 'chemical_product_level' ][ 'equivalence' ] > $b->evaluation->option[ 'chemical_product_level' ][ 'equivalence' ] ) ? -1 : 1;
			} );
		}

		require( EPI_VIEW_DIR . 'list.view.php' );
	}
}
