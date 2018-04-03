<?php
/**
 * Shortcode principale de l'application.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode principale de l'application.
 */
class Digirisk_Shortcode extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 */
	protected function construct() {
		add_shortcode( 'digi_application', array( $this, 'callback_digi_application' ) );
	}

	/**
	 * La méthode qui permet d'afficher le contenu de l'application
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  array $atts Les paramètres envoyés dans le shortcode.
	 *
	 * @return void
	 */
	public function callback_digi_application( $atts ) {
		$society_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		ob_start();
		Digirisk_Class::g()->display_main_container( $society_id );
		return ob_get_clean();
	}
}

new Digirisk_Shortcode();
