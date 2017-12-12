<?php
/**
 * Classe gérant les onglets de DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.4
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les onglets de DigiRisk.
 */
class Tab_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 */
	protected function construct() {}

	/**
	 * Charges le contenu d'un onglet
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 *
	 * @param integer $element_id     L'ID de la société, du groupement ou de l'unité de travail.
	 * @param string  $tab_to_display L'onglet à afficher.
	 * @param string  $title          Le nom de l'onglet.
	 *
	 * @return string                 La vue.
	 */
	public function load_tab_content( $element_id, $tab_to_display, $title ) {
		$element = Society_Class::g()->show_by_type( $element_id );

		// Si ce n'est pas une société, ajoutes l'identifiant unique: GP ou UT.
		if ( Society_Class::g()->get_post_type() !== $element->type ) {
			$title .= ' ' . $element->unique_identifier . ' -';
		}

		$title .= ' ' . $element->title;

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'tab', 'content', array(
			'title'          => $title,
			'element_id'     => $element_id,
			'tab_to_display' => $tab_to_display,
		), false );
		return ob_get_clean();
	}
}

Tab_Class::g();
