<?php
/**
 * Les shortcodes en relation avec les fiches de groupement.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.0
 * @version 6.4.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les shortcodes en relation avec les fiches de groupement.
 */
class Sheet_Groupement_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode
	 *
	 * @since 6.1.0
	 * @version 6.1.0
	 *
	 * @todo passer le shortcode avec des "_" au lieu de "-"
	 * @see add_shortcode
	 */
	public function __construct() {
		add_shortcode( 'digi-fiche-de-groupement', array( $this, 'callback_digi_fiche_de_groupement' ) );
	}

	/**
	 * Appelle la méthode display de la classe Fiche_De_Groupement_Class
	 *
	 * @since 6.1.0
	 * @version 6.4.0
	 *
	 * @param array $atts Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_fiche_de_groupement( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Sheet_Groupment_Class::g()->display( $element_id );
	}
}

new Sheet_Groupement_Shortcode();
