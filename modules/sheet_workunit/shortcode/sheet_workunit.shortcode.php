<?php
/**
 * Ajoutes le shortcode pour afficher la liste des fiches d'unité de travail
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes le shortcode pour afficher la liste des fiches d'unité de travail
 */
class Sheet_Workunit_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode
	 *
	 * @todo passer le shortcode avec des "_" au lieu de "-"
	 * @see add_shortcode
	 */
	public function __construct() {
		add_shortcode( 'digi-fiche-de-poste', array( $this, 'callback_digi_fiche_de_poste' ) );
	}

	/**
	 * Appelle la méthode display de la classe Fiche_De_Poste_Class
	 *
	 * @param array $atts Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_fiche_de_poste( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Fiche_De_Poste_Class::g()->display( $element_id );
	}
}

new Sheet_Workunit_Shortcode();
