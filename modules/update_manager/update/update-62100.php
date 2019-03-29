<?php
/**
 * Mise Ã  jour des donnÃ©es pour les version Ã  partir de 6.2.10.0
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.2.10.0
 */
class Update_62100 {
	private $limit_update_risk = 10;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_risk_cotation', array( $this, 'callback_digirisk_update_risk_cotation' ) );
		add_action( 'wp_ajax_digirisk_update_doc', array( $this, 'callback_digirisk_update_doc' ) );
	}
	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_risk_cotation() {

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'errors'             => null,
		) );
	}

	/**
	 * TransfÃ¨res des identifiants des documents depuis le module de mise Ã  jour.
	 *
	 * @return void
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function callback_digirisk_update_doc() {
		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'errors'             => null,
		) );
	}
}

new Update_62100();
