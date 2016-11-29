<?php
/**
 * Appelle la vue du contenu de l'application
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class Digirisk_Shortcode extends Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {
		add_shortcode( 'digi_content', array( $this, 'callback_digi_content' ) );
	}

	/**
	 * La méthode qui permet d'afficher le contenu de l'application
	 *
	 * @return void
	 */
	public function callback_digi_content() {
		require( PLUGIN_DIGIRISK_PATH . '/core/view/main-content.view.php' );
	}
}

new Digirisk_Shortcode();
