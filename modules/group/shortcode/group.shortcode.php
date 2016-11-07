<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class group_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-configuration', array( $this, 'callback_configuration' ) );
		add_shortcode( 'digi-sheet', array( $this, 'callback_sheet' ) );
	}

	/**
	* Affiches le formulaire pour configurer un groupement
	*
	* @param array $param
	*/
	public function callback_configuration( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id, array( 'address' ) );

		group_configuration_class::g()->display( $element );
	}

	/**
	* Affiches la liste des documents d'un groupement
	*
	* @param array $param
	*/
	public function callback_sheet( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id, array() );
		document_class::g()->display_document_list( $element );
	}
}

new group_shortcode();
