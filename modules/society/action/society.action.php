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

		$society = society_class::get()->show_by_type( $element_id );
		if ( $society->type == 'digi-group' ) {
			ob_start();
			$display_mode = 'simple';
			group_class::get()->display_society_tree( $display_mode, $society->id );
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
		if ( 0 === ( int )$_POST['element_id'] )
			wp_send_json_error();
		else
			$element_id = (int) $_POST['element_id'];

		$title = sanitize_text_field( $_POST['title'] );

		$society = society_class::get()->show_by_type( $element_id );
		$society->title = $title;

		if ( !empty( $_POST['send_to_group_id'] ) ) {
			$send_to_group_id = (int) $_POST['send_to_group_id'];
			$society->parent_id = $_POST['send_to_group_id'];
		}

		society_class::get()->update_by_type( $society );

		ob_start();
		$display_mode = 'simple';
		group_class::get()->display_society_tree( $display_mode, $society->id );
		wp_send_json_success( array( 'template_left' => ob_get_clean() ) );
	}
}

new society_action();
