<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de la classe du controlleur de l'installateur de l'extension Digirisk / Main controller class file for digirisk installer
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur de l'installateur de l'extension Digirisk / Main controller class for digirisk installer
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class installer_class {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'installer_redirect' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Ajout d'un menu non visile dans la zone du tableau de bord de wordpress pour la page d'installation de l'extension / Add a menu to wordpress dashboard part for installation page menu
	 */
	public function admin_menu() {
		$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );

		$old_eva_option = '';

		if ( function_exists( '\digi\transfert\getDbOption' ) ) {
			$old_eva_option = \digi\transfert\getDbOption( 'base_evarisk' );
		}

		if ( empty( $digirisk_core['installed'] ) && ( empty( $old_eva_option ) || ( $old_eva_option < 0 ) ) ) {
			add_menu_page( __( 'Digirisk installer', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_options', 'digi-setup', array( $this, 'setup_page' ), WPDIGI_URL . 'core/assets/images/favicon.png', 4 );
		}
	}

	/**
	 * On vérifie si l'installateur de l'extension a déjà été affiché etou si il peut encore l'être / Check if installer could be displayed or if it has already been displayed
	 */
	public function installer_redirect() {
		if ( !get_transient( '_wpdigi_installer' ) ) {
			return;
		}

		$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );

		if ( !empty( $digirisk_core['installed'] ) ) {
			$url_for_first_launch =  admin_url( 'index.php?page=digirisk-simple-risk-evaluation' );
		}

		if ( empty( $url_for_first_launch ) ) {
			$url_for_first_launch =  admin_url( 'admin.php?page=digi-setup' );
			if ( getDbOption( 'base_evarisk' ) > 1 ) {
				$url_for_first_launch =  admin_url( 'admin.php?page=digi-transfert' );
			}
		}

		delete_transient( '_wpdigi_installer' );

		wp_safe_redirect( $url_for_first_launch );
		exit;
	}

	/**
	 * Définition de la page d'installation de l'extension Digirisk / Define Digirisk installation page
	 */
	public function setup_page() {
		global $wpdigi_user_ctr;

		require( INSTALLER_VIEW . '/installer.php' );
	}

}

new installer_class();
