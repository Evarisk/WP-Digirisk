<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des actions pour l'export des données de Digirisk / File managing actions for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */

/**
 * Classe de gestion des actions pour l'export des données de Digirisk / Class for managing actions for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */
class Export_Action {

	public function __construct() {
		/** Enqueue les javascripts pour l'administration / Enqueue scripts into backend */

		/** Ecoute l'événement ajax d'export des données / Listen ajax event for datas export */
		add_action( 'wp_ajax_digi_export_data', array( $this, 'callback_export_data' ) );

	}

	/**
	 * Fonction de rappel pour l'export des données / Callback function for exporting datas
	 */
	public function callback_export_data() {
		check_ajax_referer( 'digi_export_data' );

		$response = Export_Class::g()->exec();

		wp_send_json_success( $response );
	}

}

new export_action();
