<?php
/**
 * Ajoutes la page pour trier les sociétées
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes la page pour trier les sociétées
 */
class Page_Sorter_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 15 );
		add_action( 'wp_ajax_sorter_parent', array( $this, 'callback_sorter_parent' ) );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Organiseur', 'digirisk' ), __( 'Organiseur', 'digirisk' ), 'manage_options', 'digirisk-handle-sorter', array( Page_Sorter_Class::g(), 'display' ) );
	}

	/**
	 * Met le parent_id à l'élément.
	 *
	 * @return void
	 */
	public function callback_sorter_parent() {
		check_ajax_referer( 'callback_sorter_parent' );

		$parent_id 	= ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		$id 				= ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$society = society_class::g()->show_by_type( $id );
		$society->parent_id = $parent_id;
		society_class::g()->update_by_type( $society );

		wp_send_json_success();
	}
}

new Page_Sorter_Action();
