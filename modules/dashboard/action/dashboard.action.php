<?php
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage action
*/
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage action
*/
class dashboard_action {

	/**
	 * Constructeur de la classe permettant d'appeler les différentes actions / Class constructor for calling diffrent actions
	 */
	public function __construct() {
		/** Appel du menu pour le tableau de bord / Call action for dashboard menu creation */
		add_action( 'admin_menu', array( $this, 'callback_dashboard_menu' ), 11 );
	}

	/**
	 * Fonction de rappel pour la création du menu du tableau de bord / Callback function for dashboard menu creation
	 *
	 * @uses add_menu_page()
	 */
	function callback_dashboard_menu( ) {
		add_menu_page( __( 'Digirisk dashboard', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_digirisk', 'digirisk-dashboard', array( $this, 'callback_dashboard_content' ), WPDIGI_URL . 'core/assets/images/favicon2.png', 4);
	}

	/**
	 * Fonction de rappel pour le contenu du tableau de bord / Callback function for dashboard content definition
	 */
	function callback_dashboard_content() {
		require_once( wpdigi_utils::get_template_part( WPDIGI_DASHBOARD_DIR, WPDIGI_DASHBOARD_VIEW_DIR, '', 'dashboard' ) );
	}

}

new dashboard_action();
