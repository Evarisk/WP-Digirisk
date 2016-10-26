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
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Les risques', 'digirisk' ), __( 'Les risques', 'digirisk' ), 'manage_options', 'digirisk-handle-risk', array( risk_page_class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon.png', 4);
	}
}

new risk_page_action();
