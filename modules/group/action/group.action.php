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
		// todo: Remplacer - par _
		add_action( 'wp_ajax_wpdigi-create-group', array( $this, 'ajax_create_group' ) );
		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );
		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );
		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );
		add_action( 'wp_ajax_wpdigi_generate_duer_' . group_class::g()->get_post_type(), array( $this, 'ajax_generate_duer' ) );
	}

	/**
	* Créer un groupement
	*
	* int $_POST['group_id'] L'ID du parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_create_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', group_class::g()->get_post_type() );
		$last_unique_key++;

		$group = group_class::g()->create( array(
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => group_class::g()->element_prefix . $last_unique_key,
			),
			'parent_id' => $group_id,
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
		require( SOCIETY_VIEW_DIR . '/screen-left.view.php' );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		echo do_shortcode( '[digi_dashboard id="' . $group->id . '"]' );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'society' => $society, 'template_left' => $template_left, 'template_right' => $template_right ) );
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

	/**
	* Appelle la méthode generate de l'objet group_duer_class
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_generate_duer() {
		check_ajax_referer( 'digi_ajax_generate_element_duer' );
		group_duer_class::g()->generate( $_POST );
		wp_send_json_success();
	}


}

new group_action();
