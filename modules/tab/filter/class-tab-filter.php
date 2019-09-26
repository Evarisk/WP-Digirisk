<?php
/**
 * Gestion des filtres relatifs aux onglets
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.4
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux onglets
 */
class Tab_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		add_filter( 'tab_content', array( $this, 'callback_tab_content' ), 10, 4 );
		add_filter( 'digi_tab_get', array( $this, 'callback_digi_tab_get' ), 10, 4 );
	}

	/**
	 * Appelles le contenu d'une société
	 *
	 * @param string  $content Le contenu du filtre.
	 * @param integer $element_id L'ID du la société.
	 * @param string  $tab_to_display L'onglet à afficher.
	 * @param string  $title Le titre.
	 *
	 * @since 6.2.4
	 */
	public function callback_tab_content( $content, $element_id, $tab_to_display, $title ) {
		\eoxia\View_Util::exec( 'digirisk', 'tab', 'content', array(
			'title'          => $title,
			'content'        => $content,
			'element_id'     => $element_id,
			'tab_to_display' => $tab_to_display,
		), false );
	}

	public function callback_digi_tab_get( $tab_slug = "", $list_tab = array() ){
		$tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field( $_GET[ 'tab' ] ) : '';
		if( ! $tab ){
			return $tab_slug;
		}

		$tab_is_valid = false;
		foreach( $list_tab[ 'digi-society' ] as $name => $family ){
			if( $name == $tab ){
				$tab = "digi-" . $name;
				$tab_is_valid = true;
				break;
			}
		}

		if( ! $tab_is_valid ){
			$tab = $tab_slug;
		}

		return $tab;
	}
}

new Tab_Filter();
