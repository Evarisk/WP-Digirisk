<?php
/**
 * Classe gérant la page installeur
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package installer
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant la page installeur
 */
class Installer_Class {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.7.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Ajoutes la page "Installeur" dans le menu "DigiRisk"
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.7.0
	 */
	public function admin_menu() {
		$digirisk_core = get_option( Config_Util::$init['digirisk']->core_option );

		$old_eva_option = '';
		if ( function_exists( '\digi\getDbOption' ) ) {
			$old_eva_option = \digi\getDbOption( 'base_evarisk' );
		}

		if ( empty( $digirisk_core['installed'] ) && ( empty( $old_eva_option ) || ( $old_eva_option < 0 ) ) ) {
			add_menu_page( __( 'Digirisk installer', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_digirisk', 'digi-setup', array( $this, 'setup_page' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
		}
	}

	/**
	 * Appelle la vue pour la page installeur
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.7.0
	 */
	public function setup_page() {
		View_Util::exec( 'installer', 'installer' );
	}

}

new Installer_Class();
