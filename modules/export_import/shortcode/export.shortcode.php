<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des shortcodes pour l'export des données de Digirisk / File managing shortcodes for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */

/**
 * Classe de gestion des shortcodes pour l'export des données de Digirisk / Class for managing shortcodes for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */
class export_shortcode {

	/**
	 * Le constructeur de la classe / Class constructor
	 */
	public function __construct() {
		add_shortcode( 'digi-export', array( $this, 'callback_export_interface' ) );
		add_shortcode( 'digi-import', array( $this, 'callback_import_interface' ) );
	}

	/**
	 * Interface d'export / Export Interface filter callback
	 *
	 * @param array $param Les paramètres du shortcode / Shortcode parameters
	 */
	public function callback_export_interface( $param ) {
		$element_id = $element = null;
		/** On vérifie si il y a un élément défini pour l'affichage du shortcode / Check if there is an element specified for shortcode usage */
		if ( !empty( $param ) && !empty( $param[ 'post_id' ] ) && is_int( (int)$param[ 'post_id' ] ) ) {
			$element_id = $param[ 'post_id' ];
	    $element = society_class::g()->show_by_type( $element_id );
		}

		/** Affichage du formulaire d'export / Display export form */
		view_util::exec( 'export_import', 'export-form', array( 'element_id' => $element_id, 'element' => $element ) );
	}

	/**
	 * Interface d'import d'un modèle / Model import Interface
	 *
	 * @param array $param Les paramètres du shortcode / Shortcode parameters
	 */
	public function callback_import_interface( $param ) {
		$element_id = $element = null;
		/** On vérifie si il y a un élément défini pour l'affichage du shortcode / Check if there is an element specified for shortcode usage */
		if ( !empty( $param ) && !empty( $param[ 'post_id' ] ) && is_int( (int)$param[ 'post_id' ] ) ) {
			$element_id = $param[ 'post_id' ];
			$element = society_class::g()->show_by_type( $element_id );
		}

		/** Affichage du formulaire d'import / Display import form */
		view_util::exec( 'export_import', 'import-form', array( 'element_id' => $element_id, 'element' => $element ) );
	}

}

new export_shortcode();
