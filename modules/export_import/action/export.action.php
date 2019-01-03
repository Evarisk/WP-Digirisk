<?php
/**
 * Gestion de l'export des données de DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 6.4.1
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de l'export des données de DigiRisk.
 */
class Export_Action {

	/**
	 * Initialise l'action 'wp_ajax_digi_export_data'
	 *
	 * @since 6.1.9
	 * @version 6.4.1
	 */
	public function __construct() {
		add_action( 'wp_ajax_digi_export_data', array( $this, 'callback_export_data' ) );

	}

	/**
	 * Fonction de rappel pour l'export des données
	 *
	 * @since 6.1.9
	 * @version 6.1.9
	 */
	public function callback_export_data() {
		check_ajax_referer( 'digi_export_data' );

		$response = Export_Class::g()->exec();

		wp_send_json_success( $response );
	}

}

new export_action();
