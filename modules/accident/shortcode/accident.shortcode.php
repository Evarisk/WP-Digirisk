<?php
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package accident
* @subpackage shortcode
*/

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class accident_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-accident', array( $this, 'callback_digi_accident' ) );
	}

	/**
	* Affiches la liste des risques ainsi que le formulaire pour en ajouter
	*
	* @param array $param
	*/
	public function callback_digi_accident( $param ) {
		$element_id = !empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		accident_class::g()->display( $element_id );
	}
}

new accident_shortcode();
