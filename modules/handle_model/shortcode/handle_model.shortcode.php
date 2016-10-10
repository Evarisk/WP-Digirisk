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
class handle_model_shortcode {
	private $list_type_document = array(
		'document_unique' => 'Document unique',
		'fiche_de_groupement' => 'fiche_de_groupement',
		'fiche_de_travail' => 'Fiche de travail',
		'affichage_legal_A3' => 'Affichage légal A3',
		'affichage_legal_A4' => 'Affichage légal A4'
	);
	/**
	 * Le constructeur de la classe / Class constructor
	 */
	public function __construct() {
		add_shortcode( 'digi-handle-model', array( $this, 'callback_handle_model_interface' ) );
	}

	/**
	 * Interface d'export / Export Interface filter callback
	 *
	 * @param array $param Les paramètres du shortcode / Shortcode parameters
	 */
	public function callback_handle_model_interface( $param ) {
		$list_document_default = array();

		if ( !empty( $this->list_type_document ) ) {
		  foreach ( $this->list_type_document as $key => $element ) {
				$list_document_default[$key] = document_class::g()->get_model_for_element( array( $key, 'model', 'default_model' ) );
		  }
		}


		view_util::exec( 'handle_model', 'main', array( 'list_type_document' => $this->list_type_document, 'list_document_default' => $list_document_default ) );
	}

}

new handle_model_shortcode();
