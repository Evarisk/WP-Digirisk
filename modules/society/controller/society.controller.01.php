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
class society_controller_01 {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		/*	Création du menu dans l'administration pour le module digirisk / Create the administration menu for digirisk plugin */
		add_action( 'admin_menu', array( &$this, 'admin_menu' ), 12 );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function admin_menu() {
		/**	Création du menu de gestion de la société et de l'évaluation des risques / Create the menu for society strcuture management and risk evaluation	*/
		$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );

		if ( !empty( $digirisk_core['installed'] ) ) {
			add_menu_page( __( 'Digirisk : Risk evaluation', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_options', 'digirisk-simple-risk-evaluation', array( &$this, 'display_dashboard' ), WPDIGI_URL . 'core/assets/images/favicon.png', 4);
		}
	}

	/**
	 * AFFICHAGE/DISPLAY - Affichage de l'écran principal pour la gestion de la structure de la société et l'évaluation des risques / Display main screen for society management and risk evaluation
	 */
	public function display_dashboard() {
		$display_mode = 'simple';

		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, $display_mode, 'dashboard' ) );
	}

}

$wpdigi_society_controller_01 = new society_controller_01();
