<?php
/**
 * Mise à jour des données pour les version à partir de 6.2.8.1
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class managing updates for version 6.2.8.1
 */
class Update_6281 {

	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_roles', array( $this, 'callback_digirisk_update_roles' ) );
		add_action( 'wp_ajax_digirisk_update_danger_category_picto', array( $this, 'callback_digirisk_update_danger_category_picto' ) );
	}

	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_roles() {
		$done = true;

		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}

		wp_send_json_success( array(
			'done' => $done,
		) );
	}

	/**
	 * AJAX Callback - Change danger categories picto
	 */
	public function callback_digirisk_update_danger_category_picto() {
		$done = true;

		Danger_Default_Data_Class::g()->create();

		wp_send_json_success( array(
			'done' => $done,
		) );
	}

}

new Update_6281();
