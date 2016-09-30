<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher la liste de tous les risques d'un établissement.
* Et un formulaire qui permet d'ajouter un risque
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class sheet_groupment_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-sheet-groupment', array( $this, 'callback_sheet_groupment' ) );
	}

	/**
	* Appelle la template pour génerer une fiche de groupement
	*
	* @param array $param
	*/
	public function callback_sheet_groupment( $param ) {
		$element_id = (int)$_POST['element_id'];
    $element = group_class::g()->get( array( 'id' => $element_id ) );
		$element = $element[0];
    $display_mode = "simple";
		require( WPDIGI_DOC_TEMPLATES_MAIN_DIR . 'simple/sheet-generation-form.php' );
    document_class::g()->display_document_list( $element );
	}
}

new sheet_groupment_shortcode();
