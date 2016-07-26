<?php

namespace digi\transfert;

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
class menu_action {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	public function __construct() {
		/*	Création du menu dans l'administration pour le module digirisk / Create the administration menu for digirisk plugin */
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );
		if ( empty( $digirisk_core['installed'] ) && getDbOption( 'base_evarisk' ) > 0 ) {
			add_menu_page( __( 'Digirisk : Manage datas transfert from digirisk V5.X', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_options', 'digi-transfert', array( &$this, 'transfer_page' ), WPDIGI_URL . 'core/assets/images/favicon.png', 4 );
		}
	}

	public function transfer_page() {
		require( \wpdigi_utils::get_template_part( DIGI_DTRANS_DIR, DIGI_DTRANS_TEMPLATES_MAIN_DIR, "backend", "transfert" ) );
	}
}

new menu_action();
