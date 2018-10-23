<?php
/**
 * Classe gérant le shortcode principale de DigiRisk.
 *
 * Le shortcode digi_application permet de booter l'application.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Digirisk shortcode class.
 */
class Digirisk_Shortcode extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	protected function construct() {
		add_shortcode( 'digi_application', array( $this, 'callback_digi_application' ) );
	}

	/**
	 * La méthode qui permet d'afficher le contenu de l'application
	 *
	 * @since 6.0.0
	 *
	 * @param array $atts Les paramètres envoyés dans le shortcode.
	 */
	public function callback_digi_application( $atts ) {
		$society_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		ob_start();
		Digirisk::g()->display_main_container( $society_id );
		return ob_get_clean();
	}
}

new Digirisk_Shortcode();
