<?php
/**
 * Gestion des filtres relatifs aux onglets
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des filtres relatifs aux onglets
 */
class Tab_Filter {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_filter( 'wpdigi_establishment_tab_content', array( $this, 'callback_tab_content' ), 10, 3 );
	}

	/**
	 * Appelles le contenu d'une société
	 *
	 * @param string  $content Le contenu du filtre.
	 * @param integer $element_id L'ID du la société.
	 * @param string  $tab_to_display L'onglet à afficher.
	 *
	 * @since 6.0.0.0
	 * @version 6.2.3.0
	 */
	public function callback_tab_content( $content, $element_id, $tab_to_display ) {
		$title = 'test';
		View_Util::exec( 'tab', 'content', array( 'title' => $title, 'content' => $content, 'element_id' => $element_id, 'tab_to_display' => $tab_to_display ) );
	}
}

new Tab_Filter();
