<?php if ( !defined( 'ABSPATH' ) ) exit;

class society_action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_load_sheet_display
	 * wp_ajax_save_society
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_sheet_display', array( $this, 'callback_load_sheet_display' ) );
		add_action( 'wp_ajax_save_society', array( $this, 'callback_save_society' ) );
		add_action( 'wp_ajax_delete_society', array( $this, 'callback_delete_society' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ) );
	}

	public function callback_admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'toplevel_page_digirisk-simple-risk-evaluation' == $screen->id ) {
			wp_enqueue_script( 'eo-no-back-page', WPDIGI_STES_URL . 'asset/js/no-back-page.backend.js', array(), WPDIGI_VERSION, false );
		}
	}

	/**
	 * Affiche la fiche d'une unité de travail / Display a work unit sheet
	 */
	public function callback_load_sheet_display() {
		// todo: Doublon ?
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$tab_to_display = !empty( $_POST['tab_to_display'] ) ? sanitize_text_field( $_POST['tab_to_display'] ) : '';

		ob_start();
		do_shortcode( '[digi_dashboard id="' . $element_id . '" tab_to_display="' . $tab_to_display . '"]' );
		$template = ob_get_clean();

		$group_list = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group', 'list_workunit' ) );

		$society = society_class::g()->show_by_type( $element_id );

		if ( $society->type == 'digi-group' ) {
			ob_start();
			require( SOCIETY_VIEW_DIR . '/screen-left.view.php' );
			wp_send_json_success( array( 'template' => $template, 'template_left' => ob_get_clean() ) );

		}

		wp_send_json_success( array( 'template' => $template ) );
	}

	/**
	* Sauvegardes les données d'une societé
	*
	* int $_POST['element_id'] L'ID de la societé
	* string $_POST['title'] Le titre de la societé
	* int $_POST['send_to_group_id'] L'ID du groupement parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_save_society() {
		// todo: Doublon ?
		if ( 0 === ( int )$_POST['id'] )
			wp_send_json_error();
		else
			$id = (int) $_POST['id'];

		$group_id = $id;
		$workunit_id_selected = 0;

		$society = society_class::g()->show_by_type( $_POST['id'] );
		$society->title = $_POST['title'];

		if ( !empty( $_POST['parent_id'] ) ) {
			$parent_id = (int) $_POST['parent_id'];
			$society->parent_id = $_POST['parent_id'];
		}

		society_class::g()->update_by_type( $society );

		if ( $society->type !== 'digi-group' ) {
			$workunit_id_selected = $society->id;
			$group_id = $society->parent_id;

			$society = society_class::g()->show_by_type( $society->parent_id );
		}

		$group_list = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group', 'list_workunit' ) );

		ob_start();
		$element_id = $society->id;
		require( SOCIETY_VIEW_DIR . '/screen-left.view.php' );
		wp_send_json_success( array( 'society' => $society, 'template_left' => ob_get_clean() ) );
	}

	/**
	* todo: Commenter
	*/
	public function callback_delete_society() {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		$society = society_class::g()->show_by_type( $element_id );
		$society->status = 'trash';
		society_class::g()->update_by_type( $society );

		ob_start();
		society_class::g()->display_dashboard();
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new society_action();
