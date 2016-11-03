<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher le page des evaluateurs
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluator
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class evaluator_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-evaluator', array( $this, 'callback_digi_evaluator' ) );
	}

	/**
	* Affiches la page des evaluateurs
	*
	* @param array $param
	*/
	public function callback_digi_evaluator( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		evaluator_class::g()->render( $element );
	}
}

new evaluator_shortcode();
