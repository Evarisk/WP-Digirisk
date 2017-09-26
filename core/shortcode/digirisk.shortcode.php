<?php
/**
 * Shortcode principale de l'application.
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
 * Shortcode principale de l'application.
 */
class Digirisk_Shortcode extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 6.3.0
	 */
	protected function construct() {
		add_shortcode( 'digi_content', array( $this, 'callback_digi_content' ) );
	}

	/**
	 * La méthode qui permet d'afficher le contenu de l'application
	 *
	 * @since 0.1.0
	 * @version 6.3.0
	 *
	 * @param  array $atts Les paramètres envoyés dans le shortcode.
	 * @return void
	 *
	 * @todo: Doublon avec nagigation.shortcode L44
	 */
	public function callback_digi_content( $atts ) {
		$establishment_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		if ( ! empty( $_REQUEST['establishment_id'] ) ) { // WPCS: CRSF ok.
			$establishment_id = (int) $_REQUEST['establishment_id'];
		}

		if ( 0 === $establishment_id ) {
			$society = Society_Class::g()->get( array(
				'posts_per_page' => 1,
			), true );
			$establishment_id = $society->id;
		}

		require( PLUGIN_DIGIRISK_PATH . '/core/view/main-content.view.php' );
	}
}

new Digirisk_Shortcode();
