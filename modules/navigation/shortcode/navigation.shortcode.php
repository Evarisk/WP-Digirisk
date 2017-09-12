<?php
/**
 * Ajoutes le shortcode digi_navigation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le shortcode digi_navigation
 */
class Navigation_Shortcode extends \eoxia\Singleton_Util {

	/**
	 * Initialise le shortcode digi_navigation
	 *
	 * @since 0.1.0
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
	 * @param  array $atts Les paramètres envoyés dans le shortcode.
	 * @return void
	 */
	public function callback_digi_navigation( $atts ) {
		$groupment_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		if ( ! empty( $_GET['groupment_id'] ) ) {
			$groupment_id = (int) $_GET['groupment_id'];
		}

		if ( ! empty( $_POST['groupment_id'] ) ) {
			$groupment_id = (int) $_POST['groupment_id'];
		}

		if ( 0 === $groupment_id ) {
			// @todo: A voir avec laurent, car cette méthode ne retournera rien.
			$society = Society_Class::g()->get( array(), true );
			$groupment_id = $society->id;
		}

		Navigation_Class::g()->display( $groupment_id );
	}
}

new Navigation_Shortcode();
