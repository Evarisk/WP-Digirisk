<?php
/**
 * Gestion des actions lié à la page des outils de DigiRisk.
 *
 * Ajoutes la page outil de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Actions
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Tools Action Class.
 */
class Tools_Action {

	/**
	 * Appel l'action admin_menu
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Ajoutes la page "DigiRisk" dans le menu "Outils" de WordPress.
	 *
	 * @since 6.0.0
	 */
	public function admin_menu() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( ! empty( $digirisk_core['installed'] ) ) {
			add_management_page( 'DigiRisk', 'DigiRisk', 'manage_digirisk', 'digirisk-tools', array( $this, 'add_management_page' ) );
		}
	}

	/**
	 * Appel la vue pour la page Outils de DigiRisk.
	 *
	 * @since 6.0.0
	 */
	public function add_management_page() {
		\eoxia\View_Util::exec( 'digirisk', 'tools', 'main' );
	}
}

new Tools_Action();
