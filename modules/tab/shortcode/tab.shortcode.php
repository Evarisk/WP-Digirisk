<?php
/**
 * Gestion du shortcode pour afficher les onglets et les contenu des onglets.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion du shortcode pour afficher les onglets et les contenu des onglets.
 */
class Tab_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_tab', array( $this, 'callback_digi_tab' ) );
	}

	/**
	 * Appelle la méthode display_tab de Tab_Class.
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * Array['fields']      array   Définition des champs du tableau.
	 *        ['id']        integer L'ID de la société.
	 *        ['type']      string  Le type de la société. Peut etre 'digi-society', 'digi-group' ou 'digi-workunit'.
	 *        ['tab_slug']  string  Le slug de l'onglet.
	 *        ['tag_title'] string  Le titre du contenu de l'onglet.
	 *
	 * @param array $atts Les paramètres du shortcode (See above).
	 *
	 * @return string
	 */
	public function callback_digi_tab( $atts ) {
		$id       = $atts['id'];
		$tab_slug = $atts['tab_slug'];
		$type     = $atts['type'];

		ob_start();
		Tab_Class::g()->display( $id, $tab_slug, $type );
		return ob_get_clean();
	}
}

new Tab_Shortcode();
