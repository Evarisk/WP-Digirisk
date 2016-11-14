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
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Organiser', 'digirisk' ), __( 'Organiser', 'digirisk' ), 'manage_options', 'digirisk-handle-sorter', array( Page_Sorter_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon.png', 5 );
	}
}

new Page_Sorter_Action();
