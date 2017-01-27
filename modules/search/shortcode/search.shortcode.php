<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher le champ de recherche
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package search
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class Search_Shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-search', array( $this, 'callback_digi_search' ) );
	}

	/**
	* Appelle la template pour génerer une fiche de groupement
	*
	* @param array $param
	*/
	public function callback_digi_search( $param ) {
		$element_id = ! empty( $param['id'] ) ? (int) $param['id'] : 0;
		$text = ! empty( $param['text'] ) ? sanitize_text_field( $param['text'] ) : __( 'Write your search here...', 'digirisk' );
		$target = ! empty( $param['target'] ) ? sanitize_text_field( $param['target'] ) : '';
		$field = ! empty( $param['field'] ) ? sanitize_text_field( $param['field'] ) : '';
		$type = ! empty( $param['type'] ) ?  $param['type'] : '';
		$class = ! empty( $param['class'] ) ?  $param['class'] : '';
		$icon = ! empty( $param['icon'] ) ?  $param['icon'] : '';
		$next_action = ! empty( $param['next-action'] ) ? sanitize_text_field( $param['next-action'] ) : '';

		View_Util::exec( 'search', 'search', array( 'element_id' => $element_id, 'text' => $text, 'target' => $target, 'field' => $field, 'type' => $type, 'class' => $class, 'icon' => $icon, 'next_action' => $next_action ) );
	}
}

new Search_Shortcode();
