<?php if ( !defined( 'ABSPATH' ) ) exit;

class workunit_class extends post_class {
	public $element_prefix = 'UT';
	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );
	protected $model_name   = 'workunit_model';
	protected $post_type    = WPDIGI_STES_POSTTYPE_SUB;
	protected $meta_key    	= '_wp_workunit';
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
				'name'                => __( 'Work units', 'digirisk' ),
				'singular_name'       => __( 'Work unit', 'digirisk' ),
				'menu_name'           => __( 'Work units', 'digirisk' ),
				'name_admin_bar'      => __( 'Work units', 'digirisk' ),
				'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
				'all_items'           => __( 'Work units', 'digirisk' ),
				'add_new_item'        => __( 'Add a work unit', 'digirisk' ),
				'add_new'             => __( 'Add a work unit', 'digirisk' ),
				'new_item'            => __( 'New a work unit', 'digirisk' ),
				'edit_item'           => __( 'Edit a work unit', 'digirisk' ),
				'update_item'         => __( 'Update a work unit', 'digirisk' ),
				'view_item'           => __( 'View a work unit', 'digirisk' ),
				'search_items'        => __( 'Search a work unit', 'digirisk' ),
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
				'label'               => __( 'Digirisk work unit', 'digirisk' ),
				'description'         => __( 'Manage societies into digirisk', 'digirisk' ),
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
	 * ROUTES - Récupération des informations principale d'une unité de travail / Get the main information about a workunit
	 *
	 * @param integer $id L'identifiant de l'unité de travail dont on veux récupèrer uniquement l'identité principale / Workunit identifier we want to get main identity for
	 */
	function get_workunit_identity( $id ) {
		global $wpdb;

		$query  = $wpdb->prepare(
				"SELECT P.post_title, P.post_modified, PM.meta_value AS _wpdigi_unique_identifier
				FROM {$wpdb->posts} AS P
				INNER JOIN {$wpdb->postmeta} AS PM ON ( PM.post_id = P.ID )
				WHERE P.ID = %d
				AND PM.meta_key = %s", $id, '_wpdigi_unique_identifier'
		);
		$work_unit = $wpdb->get_row( $query );

		return $work_unit;
	}

	/**
	 * Affiche une fiche d'unité de travail à partir d'un identifiant donné / Display a work unit from given identifier
	 *
	 * @param integer $id L'indentifiant de l'unité de travail à afficher / The workunit identifier to display
	 * @param string $dislay_mode Optionnal Le mode d'affichage de la fiche (simple, complète, publique, ...) / The display mode (simple, complete, public, ... )
	 */
	public function display( $id, $display_mode = 'simple' ) {
		if ( !is_int( $id ) || !is_string( $display_mode ) ) {
			return false;
		}

		/**	Get the work unit to display	*/
		$this->current_workunit = $this->show( $id );
		$element_post_type = $this->get_post_type();

		/**	Set default tab in work unit - Allow modification throught filter	*/
		$workunit_default_tab = apply_filters( 'wpdigi_workunit_default_tab', '' );

		/**	Display the template	*/
		$path = wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $display_mode );

		if ( $path ) {
			require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $display_mode ) );
		}
	}

	public function display_list( $groupment_id, $workunit_selected_id = 0 ) {
		$list_workunit = workunit_class::g()->get( array( 'post_parent' => $groupment_id, 'posts_per_page' => -1 ), array( false ) );

		require ( WORKUNIT_VIEW_DIR . '/list.view.php' );
	}
}
