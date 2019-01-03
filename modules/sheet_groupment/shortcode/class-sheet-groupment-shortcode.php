<?php
/**
 * Gestion des shortcode des fiches de groupements.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Les shortcodes en relation avec les fiches de groupement.
 */
class Sheet_Groupment_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode
	 *
	 * @since 6.1.0
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
	 *
	 * @param array $atts Les paramètres du shortcode.
	 */
	public function callback_digi_fiche_de_groupement( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;
		Sheet_Groupment_Class::g()->display( $element_id, array( '\digi\Sheet_Groupment_Class' ) );
	}
}

new Sheet_Groupment_Shortcode();
