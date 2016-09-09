<?php if ( !defined( 'ABSPATH' ) ) exit;

class accident_class extends post_class {

	protected $model_name   = 'accident_model';
	protected $post_type    = 'digi-accident';
	protected $meta_key    	= '_wpdigi_accident';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to accident from WP Rest API	*/
	protected $base = 'digirisk/accident';
	protected $version = '0.1';

	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );
	public $element_prefix = 'A';

	protected $limit_accident = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for accidents management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );
	}

	/**
	* Déclares le post type: risque
	*/
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create accident : main element 	*/
		$labels = array(
			'name'                => __( 'Accidents', 'digirisk' ),
			'singular_name'       => __( 'Accident', 'digirisk' ),
			'menu_name'           => __( 'Accidents', 'digirisk' ),
			'name_admin_bar'      => __( 'Accident', 'digirisk' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => __( 'Accident', 'digirisk' ),
			'add_new_item'        => __( 'Add accident', 'digirisk' ),
			'add_new'             => __( 'Add accident', 'digirisk' ),
			'new_item'            => __( 'New accident', 'digirisk' ),
			'edit_item'           => __( 'Edit accident', 'digirisk' ),
			'update_item'         => __( 'Update accident', 'digirisk' ),
			'view_item'           => __( 'View accident', 'digirisk' ),
			'search_items'        => __( 'Search accident', 'digirisk' ),
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
			'label'               => __( 'Digiaccident accident', 'digirisk' ),
			'description'         => __( 'Manage accidents into digirisk', 'digirisk' ),
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
		require( ACCIDENT_VIEW_DIR . 'main.view.php' );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for accidents through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_accident_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$accident_list = accident_class::g()->index( array( 'post_parent' => $society->id ) );

		if ( !empty( $accident_list ) ) {
		  foreach ( $accident_list as $key => $element ) {
				$accident_list[$key] = $this->get_accident( $element->id );
		  }
		}

		// Tries les risques par ordre de cotation
		if ( count( $accident_list ) > 1 ) {
			usort( $accident_list, function( $a, $b ) {
				if( $a->evaluation->option[ 'accident_level' ][ 'equivalence' ] == $b->evaluation->option[ 'accident_level' ][ 'equivalence' ] ) {
					return 0;
				}
				return ( $a->evaluation->option[ 'accident_level' ][ 'equivalence' ] > $b->evaluation->option[ 'accident_level' ][ 'equivalence' ] ) ? -1 : 1;
			} );
		}

		require( ACCIDENT_VIEW_DIR . 'list.view.php' );
	}
}
