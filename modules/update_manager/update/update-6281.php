<?php
/**
 * Mise à jour des données pour la version 6.2.8
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Mise à jour des données pour la version 6.2.8
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

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	/**
	 * AJAX Callback - Change danger categories picto
	 */
	public function callback_digirisk_update_danger_category_picto() {
		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

}

new Update_6281();
