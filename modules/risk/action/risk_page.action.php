<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class risk_page_action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_load_sheet_display
	 * wp_ajax_save_society
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
		add_action( 'can_update', array( $this, 'callback_can_update' ), 10, 0 );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Tous les risques', 'digirisk' ), __( 'Tous les risques', 'digirisk' ), 'manage_options', 'digirisk-handle-risk', array( risk_page_class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon.png', 4);
	}

	/**
	 * Vérifie que la variable $_POST "can_update" existe.
	 * Si celle-ci existe, et qu'elle est à "false", stop l'action AJAX pour ne pas modifier le risque
	 * @return [type] [description]
	 */
	public function callback_can_update() {
		// Met à true si la variable $_POST "can_update" n'existe pas. Permet de continuer l'exécution de l'action AJAX.
		$can_update = isset( $_POST['can_update'] ) ? (bool) $_POST['can_update'] : true;

		echo "<pre>"; print_r($can_update); echo "</pre>";

		// Si la variable est à false, on stop l'action AJAX pour ne pas modifier le risque.
		if ( ! $can_update ) {
			wp_send_json_error();
		}
	}
}

new risk_page_action();
