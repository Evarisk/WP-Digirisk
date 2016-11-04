<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
class group_action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_wpdigi-create-group
	 * wp_ajax_wpdigi-load-group
	 * wp_ajax_wpdigi_ajax_group_update
	 * wp_ajax_display_ajax_sheet_display
	 * wp_ajax_wpdigi_generate_duer_digi-group
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'custom_post_type' ), 5 );

		// todo: Remplacer - par _
		add_action( 'wp_ajax_create_group', array( $this, 'ajax_create_group' ) );
		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );
		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );
		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
			'name'                => __( 'Societies', 'digirisk' ),
			'singular_name'       => __( 'Society', 'digirisk' ),
			'menu_name'           => __( 'Societies', 'digirisk' ),
			'name_admin_bar'      => __( 'Societies', 'digirisk' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => __( 'Societies', 'digirisk' ),
			'add_new_item'        => __( 'Add society', 'digirisk' ),
			'add_new'             => __( 'Add society', 'digirisk' ),
			'new_item'            => __( 'New society', 'digirisk' ),
			'edit_item'           => __( 'Edit society', 'digirisk' ),
			'update_item'         => __( 'Update society', 'digirisk' ),
			'view_item'           => __( 'View society', 'digirisk' ),
			'search_items'        => __( 'Search society', 'digirisk' ),
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
			'label'               => __( 'Digirisk society', 'digirisk' ),
			'description'         => __( 'Manage societies into digirisk', 'digirisk' ),
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

		register_post_type( group_class::g()->get_post_type(), $args );
	}

	/**
	* Créer un groupement
	*
	* int $_POST['group_id'] L'ID du parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_create_group() {
		if ( 0 === ( int )$_POST['parent_id'] )
			wp_send_json_error();
		else
			$parent_id = (int) $_POST['parent_id'];

		$group = group_class::g()->create( array(
			'parent_id' => $parent_id,
			'title' => __( 'Undefined', 'digirisk' ),
		) );

		$group_list = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group' ) );


		ob_start();
		$element_id = $group->id;
		$society = $group;
		view_util::exec( 'society', 'screen-left', array( 'society_parent' => $society, 'society' => $society, 'group_list' => $group_list, 'element_id' => $element_id ) );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		do_shortcode( '[digi_dashboard id="' . $group->id . '"]' );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'module' => 'group', 'callback_success' => 'callback_create_group', 'society' => $society, 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	/**
	* Charges les données d'un groupement
	*
	* int $_POST['group_id'] L'ID du groupement
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group_id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $group_id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	/**
	* Sauvegardes les données d'un groupement
	*
	* int $_POST['group_id'] L'ID du groupement
	* string $_POST['title'] Le titre du groupement
	* int $_POST['send_to_group_id'] L'ID du groupement parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_group_update() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$title = sanitize_text_field( $_POST['title'] );

		wpdigi_utils::check( 'ajax_update_group_' . $group_id );

		$group = $this->show( $group_id );
		$group->title = $title;

		if ( !empty( $_POST['send_to_group_id'] ) ) {
			$send_to_group_id = (int) $_POST['send_to_group_id'];
			$group->parent_id = $_POST['send_to_group_id'];
		}

		$this->update( $group );

		$group_parent = group_class::g()->get(
			array(
				'posts_per_page' => 1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
			), array(
				'list_group'
			) );

		ob_start();
		$display_mode = 'simple';
		$this->display_toggle( $group_parent[0], $group );
		wp_send_json_success( array( 'template_left' => ob_get_clean() ) );
	}

}

new group_action();
