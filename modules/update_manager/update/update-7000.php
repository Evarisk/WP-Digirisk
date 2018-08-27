<?php
/**
 * Mise à jour des données pour la 7.0.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mise à jour des données pour la version 1.4.0
 */
class Update_7000 {

	/**
	 * Le constructeur
	 *
	 * @since 1.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_700_update_society', array( $this, 'callback_digirisk_update_700_update_society' ) );
	}

	public function callback_digirisk_update_700_update_society() {
		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => false,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

}

new Update_7000();
