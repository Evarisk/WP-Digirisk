<?php
/**
 * Les shortcodes en relation avec les fiches de poste.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les shortcodes en relation avec les fiches de poste.
 */
class Sheet_Workunit_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode
	 *
	 * @since 6.0.0
	 * @version 6.0.0
	 *
	 * @todo passer le shortcode avec des "_" au lieu de "-"
	 * @see add_shortcode
	 */
	public function __construct() {
		add_shortcode( 'digi-fiche-de-poste', array( $this, 'callback_digi_fiche_de_poste' ) );
	}

	/**
	 * Appelle la méthode display de la classe Sheet_Workunit_Class
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 *
	 * @param array $atts Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_fiche_de_poste( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Sheet_Workunit_Class::g()->display( $element_id );
	}
}

new Sheet_Workunit_Shortcode();
