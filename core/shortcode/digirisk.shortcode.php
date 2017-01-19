<?php
/**
 * Shortcode principale de l'application.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Shortcode principale de l'application.
 */
class Digirisk_Shortcode extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	protected function construct() {
		add_shortcode( 'digi_content', array( $this, 'callback_digi_content' ) );
	}

	/**
	 * La méthode qui permet d'afficher le contenu de l'application
	 *
	 * @param  array $atts Les paramètres envoyés dans le shortcode.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_digi_content( $atts ) {
		$society_id = ! empty( $atts['id'] ) ? (int) $atts['id'] : 0;

		if ( ! empty( $_GET['groupment_id'] ) ) {
			$society_id = (int) $_GET['groupment_id'];
		}

		if ( ! empty( $_POST['groupment_id'] ) ) { // WPCS: CSRF ok.
			$society_id = (int) $_POST['groupment_id'];
		}

		if ( ! empty( $_GET['workunit_id'] ) ) {
			$society_id = (int) $_GET['workunit_id'];
		}

		if ( ! empty( $_POST['workunit_id'] ) ) { // WPCS: CSRF ok.
			$society_id = (int) $_POST['workunit_id'];
		}

		if ( 0 === $society_id ) {
			$society_id = Group_Class::g()->get_first_groupment_id();
		}

		require( PLUGIN_DIGIRISK_PATH . '/core/view/main-content.view.php' );
	}
}

new Digirisk_Shortcode();
