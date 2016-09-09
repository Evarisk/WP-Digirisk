<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class risk_class extends post_class {

	protected $model_name   = 'risk_model';
	protected $post_type    = 'digi-risk';
	protected $meta_key    	= '_wpdigi_risk';
	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/risk';
	protected $version = '0.1';

	public $element_prefix = 'R';

	protected $limit_risk = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for risks management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Définition d'un shortcode permettant d'afficher les risques associés à un élément / Define a shortcode allowing to display risk associated to a given element 	*/
		add_shortcode( 'risk', array( $this, 'risk_shortcode' ) );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_workunit_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_workunit_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for group tabs	*/
		add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );
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
		register_post_type( $this->post_type, $args );
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$risk_list = risk_class::g()->get( array( 'post_parent' => $society_id, 'posts_per_page' => -1 ), array( 'comment', 'evaluation_method', 'evaluation', 'danger_category', 'danger' ) );

		if ( count( $risk_list ) > 1 ) {
			usort( $risk_list, function( $a, $b ) {
				if( $a->evaluation[0]->risk_level['equivalence'] == $b->evaluation[0]->risk_level['equivalence'] ) {
					return 0;
				}
				return ( $a->evaluation[0]->risk_level['equivalence'] > $b->evaluation[0]->risk_level['equivalence'] ) ? -1 : 1;
			} );
		}

		require( RISK_VIEW_DIR . 'main.view.php' );
	}
}
