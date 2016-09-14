<?php
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

class group_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-generate-sheet', array( $this, 'callback_generate_sheet' ) );
		add_shortcode( 'digi-sheet', array( $this, 'callback_sheet' ) );
		add_shortcode( 'digi-configuration', array( $this, 'callback_configuration' ) );
	}

	/**
	* Appelle le template pour génerer le DUER
	*
	* @param array $param
	*/
	public function callback_generate_sheet( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		$current_user = wp_get_current_user();

		require ( WPDIGI_STES_TEMPLATES_MAIN_DIR . '/group/sheet-form.php' );
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

	/**
	* Affiches le formulaire pour configurer un groupement
	*
	* @param array $param
	*/
	public function callback_configuration( $param ) {
		$element_id = $param['post_id'];
    $element = society_class::g()->show_by_type( $element_id );

		group_configuration_class::g()->display( $element );
	}
}

new group_shortcode();
