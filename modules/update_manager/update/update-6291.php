<?php
/**
 * Mise à jour des données pour les version à partir de 6.2.9.1
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.2.9.1
 */
class Update_6291 {
	private $limit_update_risk = 10;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_recreate_category_danger', array( $this, 'callback_digirisk_update_recreate_category_danger' ) );
		add_action( 'wp_ajax_digirisk_update_associate_danger_to_risk', array( $this, 'callback_digirisk_update_associate_danger_to_risk' ) );
		add_action( 'wp_ajax_digirisk_update_roles_2', array( $this, 'callback_digirisk_update_roles_2' ) );
	}

	/**
	 * AJAX Callback - Change danger categories picto
	 */
	public function callback_digirisk_update_recreate_category_danger() {
		wp_send_json_success( array(
			'done' => true,
		) );
	}

	public function callback_digirisk_update_associate_danger_to_risk() {
		wp_send_json_success( array(
			'done' => true,
		) );
	}

	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_roles_2() {
		wp_send_json_success( array(
			'done' => true,
		) );
	}
}

new Update_6291();
