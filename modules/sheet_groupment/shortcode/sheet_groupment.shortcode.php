<?php
/**
 * Ajoutes le shortcode pour afficher la liste des fiches de groupement
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes le shortcode pour afficher la liste des fiches de groupement
 */
class Sheet_Groupement_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode
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
	 * @param array $atts Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_fiche_de_groupement( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Fiche_De_Groupement_Class::g()->display( $element_id );
	}
}

new Sheet_Groupement_Shortcode();
