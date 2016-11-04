<?php if ( !defined( 'ABSPATH' ) ) exit;

class accident_class extends post_class {

	protected $model_name   = 'accident_model';
	protected $post_type    = 'digi-accident';
	protected $meta_key    	= '_wpdigi_accident';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to accident from WP Rest API	*/
	protected $base = 'digirisk/accident';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $element_prefix = 'AC';

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
			'name'                => __( 'Risks', 'digiaccident' ),
			'singular_name'       => __( 'Risk', 'digiaccident' ),
			'menu_name'           => __( 'Risks', 'digiaccident' ),
			'name_admin_bar'      => __( 'Risks', 'digiaccident' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digiaccident' ),
			'all_items'           => __( 'Risks', 'digiaccident' ),
			'add_new_item'        => __( 'Add accident', 'digiaccident' ),
			'add_new'             => __( 'Add accident', 'digiaccident' ),
			'new_item'            => __( 'New accident', 'digiaccident' ),
			'edit_item'           => __( 'Edit accident', 'digiaccident' ),
			'update_item'         => __( 'Update accident', 'digiaccident' ),
			'view_item'           => __( 'View accident', 'digiaccident' ),
			'search_items'        => __( 'Search accident', 'digiaccident' ),
			'not_found'           => __( 'Not found', 'digiaccident' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'digiaccident' ),
		);
		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'Digiaccident accident', 'digiaccident' ),
			'description'         => __( 'Manage accidents into digiaccident', 'digiaccident' ),
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
		register_post_type( $this->post_type, $args );
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$accident = $this->get( array( 'schema' => true ) );
		$accident = $accident[0];
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

		$accident_list = accident_class::g()->get( array( 'post_parent' => $society->id ), array( 'list_risk', 'evaluation', 'list_user' ) );

		require( ACCIDENT_VIEW_DIR . 'list.view.php' );
	}
}
