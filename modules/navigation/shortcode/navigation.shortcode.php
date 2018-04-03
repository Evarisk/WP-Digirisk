<?php
/**
 * Ajoutes le shortcode "digi_navigation"
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le shortcode "digi_navigation"
 */
class Navigation_Shortcode extends \eoxia\Singleton_Util {

	/**
	 * Initialise le shortcode "digi_navigation"
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	protected function construct() {
		add_shortcode( 'digi_navigation', array( $this, 'callback_digi_navigation' ) );
	}

	/**
	 * Récupères le groupment_id soit:
	 * -Par le paramètres du shortcode groupment_id
	 * -Par le paramètres $_GET de l'url: groupment_id
	 * -Par la méthode get_first_groupment_id
	 *
	 * La méthode qui permet d'appeller la méthode display de Navigation_Class
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  array $atts Les paramètres envoyés dans le shortcode.
	 *
	 * @return string
	 */
	public function callback_digi_navigation( $atts ) {
		$society_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		if ( 0 === $society_id ) {
			$society    = Society_Class::g()->get_current_society();
			$society_id = $society->data['id'];
		}

		ob_start();
		Navigation_Class::g()->display( $society_id );
		return ob_get_clean();
	}
}

new Navigation_Shortcode();
