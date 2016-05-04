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
class wpdigi_group_ctr_01 extends post_ctr_01 {

	protected $model_name   = 'wpdigi_group_mdl_01';
	protected $post_type    = WPDIGI_STES_POSTTYPE_MAIN;
	protected $meta_key    	= '_wpdigi_society';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to society from WP Rest API	*/
	protected $base = 'digirisk/groupement';
	protected $version = '0.1';

	public $element_prefix = 'GP';

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		parent::__construct();

		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( WPDIGI_STES_PATH . '/model/group.model.01.php' );

		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
		add_shortcode( 'wpdigi-group-dropdown', array( &$this, 'shortcode_group_dropdown' ) );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 6, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_generate_document_unique_in_element' ), 10, 3 );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
			'name'                => __( 'Societies', 'wpdigi-i18n' ),
			'singular_name'       => __( 'Society', 'wpdigi-i18n' ),
			'menu_name'           => __( 'Societies', 'wpdigi-i18n' ),
			'name_admin_bar'      => __( 'Societies', 'wpdigi-i18n' ),
			'parent_item_colon'   => __( 'Parent Item:', 'wpdigi-i18n' ),
			'all_items'           => __( 'Societies', 'wpdigi-i18n' ),
			'add_new_item'        => __( 'Add society', 'wpdigi-i18n' ),
			'add_new'             => __( 'Add society', 'wpdigi-i18n' ),
			'new_item'            => __( 'New society', 'wpdigi-i18n' ),
			'edit_item'           => __( 'Edit society', 'wpdigi-i18n' ),
			'update_item'         => __( 'Update society', 'wpdigi-i18n' ),
			'view_item'           => __( 'View society', 'wpdigi-i18n' ),
			'search_items'        => __( 'Search society', 'wpdigi-i18n' ),
			'not_found'           => __( 'Not found', 'wpdigi-i18n' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'wpdigi-i18n' ),
		);
		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'Digirisk society', 'wpdigi-i18n' ),
			'description'         => __( 'Manage societies into digirisk', 'wpdigi-i18n' ),
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
	 * AFFICHAGE/DISPLAY - Affichage de l'arboresence d'une société / Display the main tree of a given society
	 *
	 * @param string $mode Optionnal. Default: simple. Le mode d'affichage pour l'arborescence de la société / The mode of display for society tree
	 */
	public function display_society_tree( $mode = 'simple', $default_selected_group_id = null ) {
		/**	Get existing groups for main selector display	*/
		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );
		$default_selected_group_id = ( $default_selected_group_id == null ) && ( !empty( $group_list ) ) ? $group_list[0]->id : $default_selected_group_id;
		// //global $default_selected_group_id;
		// global $wpdigi_workunit_ctr;

		//
		// $workunit_id = 0;
		// global $wpdb;
		// $workunit_id = $wpdb->get_var( $wpdb->prepare( "SELECT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} as PM ON P.ID=PM.post_id WHERE P.post_type=%s AND PM.meta_key=%s AND PM.meta_value=%s", array( $wpdigi_workunit_ctr->get_post_type(), '_wpdigi_unique_identifier', 'UT1' ) ) );
		//
		// if ( !empty( $_REQUEST['current_workunit_id'] ) ) {
		// 	$workunit_id = $_REQUEST['current_workunit_id'];
		// }
		//
		// if ( !empty( $_REQUEST['current_group_id'] ) ) {
		// 	$default_selected_group_id = $_REQUEST['current_group_id'];
		// }

		add_filter( 'wpdigi_default_dashboard_content', function( $default ){
			$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );
			$default_selected_group_id = ( $default_selected_group_id == null ) && ( !empty( $group_list ) ) ? $group_list[0]->id : $default_selected_group_id;
			// global $wpdigi_workunit_ctr;
			//
			// global $wpdb;
			// $workunit_id = $wpdb->get_var( $wpdb->prepare( "SELECT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} as PM ON P.ID=PM.post_id WHERE P.post_type=%s AND PM.meta_key=%s AND PM.meta_value=%s", array( $wpdigi_workunit_ctr->get_post_type(), '_wpdigi_unique_identifier', 'UT1' ) ) );
			//
			// if ( !empty( $_REQUEST['current_workunit_id'] ) ) {
			// 	$workunit_id = $_REQUEST['current_workunit_id'];
			// }

			ob_start();
			$this->display( $default_selected_group_id );
			$default = ob_get_clean();

			return $default;
		}, 12);

		/**	Affichage du bloc société (groupement principal + unité de travail) / Display a society bloc (main group + work unit) 	*/
		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, ( !empty( $mode ) && in_array( $mode, array( 'simple', 'full',  ) ) ? $mode : 'simple' ), 'society/society', 'tree' ) );
	}

	public function display_all_group( $default_selected_group_id = null ) {
		/**	Get existing groups for main selector display	*/
		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );

		//global $default_selected_group_id;
		global $wpdigi_workunit_ctr;
		$default_selected_group_id = ( $default_selected_group_id == null ) && ( !empty( $group_list ) ) ? $group_list[0]->id : $default_selected_group_id;

		$workunit_id = 0;
		global $wpdb;
		$workunit_id = $wpdb->get_var( $wpdb->prepare( "SELECT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} as PM ON P.ID=PM.post_id WHERE P.post_type=%s AND PM.meta_key=%s AND PM.meta_value=%s", array( $wpdigi_workunit_ctr->get_post_type(), '_wpdigi_unique_identifier', 'UT1' ) ) );

		if ( !empty( $_REQUEST['current_workunit_id'] ) ) {
			$workunit_id = $_REQUEST['current_workunit_id'];
		}

		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'list' ) );
	}

	public function display( $group_id ) {
		$group = $this->show( $group_id );

		$group_default_tab = apply_filters( 'wpdigi_group_default_tab', '' );

		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'sheet', 'simple' ) );
	}

	public function get_unique_identifier_in_list_by_id( $group_id, $group_list ) {
		$group = $this->show( $group_id );
		return $group->option['unique_identifier'];
	}

	public function get_title_in_list_by_id( $group_id, $group_list ) {
		$group = $this->show( $group_id );
		return $group->title;
	}

	public function render_list_item( $default_selected_group_id, $group_id = 0, $class = '' ) {
		$group_list = $this->index( array( 'posts_per_page' => -1, 'post_parent' => $group_id, 'post_status' => array( 'publish', 'draft', ), ), false );
		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'list-item' ) );
	}

	/**
	 * Construit l'affichage des onglets existant dans une unité de travail / Build the existing tab for workunit
	 *
	 * @param Object $workunit L'unité de travail actuellement en cours d'édition / The current work unit
	 * @param string $default_tab L'onglet a sélectionner automatiquement : The default tab to select
	 */
	 public function display_group_tab( $group, $default_tab ) {
	 	/**	Définition de la liste des onglets pour les unités de travail - modifiable avec un filtre / Define a tab list for work unit - editable list through filter	*/
	 	$tab_list = apply_filters( 'wpdigi_group_sheet_tab', array(), $group );

	 	/**	Affichage des onglets définis pour les unités de travail / Display defined tabs for work unit	*/
	 	require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/tab', 'list' ) );
	 }

	 /**
	  * Gestion de l'affichage du contenu des onglets pour une unité de travail / Manage content display into workunit
	  *
	  * @param Object $workunit La définition complète de l'unité de travail sur laquelle on se trouve / The complete definition for the current workunit we are on
	  * @param string $tab_to_display Permet de sélectionner les données a afficher ( par défaut affiche un shortcode basé sur cet valeur ) / Allows to display tab content to display ( Display a shortcode composed with this value by default )
	  */
	 public function display_group_tab_content( $group, $tab_to_display ) {
	 	/**	Application d'un filtre d'affichage selon la partie a afficher demandée par l'utilisateur / Apply filter for display user's requested part	*/
	 	$output = apply_filters( 'wpdigi_group_sheet_content', '', $group, $tab_to_display );
	 	/**	Par défaut on va afficher un shortcode ayant pour clé la valeur de $tab_to_display / By default display a shortcode composed with $tab_to_display	*/
	 	if ( empty( $output ) ) {
	 		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/tab', 'default' ) );
	 	}
	 	else {
	 		echo $output;
	 	}
	 }

	 function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
		/** Définition de l'onglet permettant l'affichage des utilisateurs pour le type d'élément actuel / Define the tab allowing to display evaluators' tab for current element type	*/
		$tab_list = array_merge( $tab_list, array(
			'generate-sheet' => array(
				'text'	=> __( 'DUER Generation', 'wpdigi-i18n' ),
				'count' => 0,
			),
			'sheet' => array(
				'text'	=> __( 'Document list', 'wpdigi-i18n' ),
				'count' => 0,
			),
		) );

		return $tab_list;
	}

	function filter_display_generate_document_unique_in_element( $output, $element, $tab_to_display ) {
		if ( 'generate-sheet' == $tab_to_display ) {
			$current_user = wp_get_current_user();

			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'sheet', 'form' ) );
			$output .= ob_get_contents();
			ob_end_clean();
		}

		if ( 'sheet' == $tab_to_display ) {
			$document_controller = new document_controller_01();
			ob_start();
			$document_controller->display_document_list( $element );
			$output .= ob_get_contents();
			ob_end_clean();
		}

		return $output;
	}

}

global $wpdigi_group_ctr;
$wpdigi_group_ctr = new wpdigi_group_ctr_01();
