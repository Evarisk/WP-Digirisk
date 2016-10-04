<?php namespace digi;
/**
* Ajoutes deux shortcodes
* digi_evaluation_method permet d'afficher la méthode d'évaluation simple
* digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class digi_comment_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi_comment', array( $this, 'callback_digi_comment' ) );
	}

	public function callback_digi_comment( $param ) {
		digi_comment_class::g()->display( $param );
	}
}

new digi_comment_shortcode();
