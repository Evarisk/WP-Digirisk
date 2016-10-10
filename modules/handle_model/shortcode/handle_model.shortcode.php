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
		view_util::exec( 'handle_model', 'main', array() );
	}

}

new handle_model_shortcode();
