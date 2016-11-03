<?php
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package chemical_product
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class chemical_product_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-chemical-product', array( $this, 'callback_digi_chemical_product' ) );
	}

	/**
	* Affiches la liste des risques ainsi que le formulaire pour en ajouter
	*
	* @param array $param
	*/
	public function callback_digi_chemical_product( $param ) {
		$element_id = !empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		chemi_product_class::g()->display( $element_id );
	}
}

new chemical_product_shortcode();
