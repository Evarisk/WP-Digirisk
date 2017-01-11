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
