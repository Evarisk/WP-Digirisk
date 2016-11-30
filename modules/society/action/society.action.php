<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class society_action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_load_sheet_display
	 * wp_ajax_save_society
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_society', array( $this, 'callback_load_society' ) );
		add_action( 'wp_ajax_save_society', array( $this, 'callback_save_society' ) );
		add_action( 'wp_ajax_delete_society', array( $this, 'callback_delete_society' ) );
	}

	/**
	 * Affiche la fiche d'une unité de travail / Display a work unit sheet
	 */
	public function callback_load_society() {
		$template = '';

		ob_start();
		Digirisk_Class::g()->display();
		$template .= ob_get_clean();
		wp_send_json_success( array( 'module' => 'society', 'callback_success' => 'callback_load_society', 'template' => $template ) );
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

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array( 'society' => $society, 'template' => ob_get_clean() ) );
	}

	/**
	* todo: Commenter
	*/
	public function callback_delete_society() {
		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$society = society_class::g()->show_by_type( $id );
		$society->status = 'trash';
		society_class::g()->update_by_type( $society );

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array( 'template' => ob_get_clean(), 'module' => 'society', 'callback_success' => 'delete_success' ) );
	}
}

new society_action();
