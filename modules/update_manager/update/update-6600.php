<?php
/**
 * Mise à jour des données pour la version 6.6.0
 *
 * @author Evarisk
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.6.0
 */
class Update_660 {
	private $limit_update = 50;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_get_societies_status', array( $this, 'callback_digirisk_get_societies_status' ) );
		add_action( 'wp_ajax_digirisk_update_societies_status', array( $this, 'callback_digirisk_update_societies_status' ) );
	}

	/**
	 * Récupères tous les GP et UT avec un status erronnées.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function callback_digirisk_get_societies_status() {
		$done = false;

		// Remet à 0 l'entrée.
		update_option( 'digirisk_update_6600_list_societies', array() );

		$main_society_id = get_posts( array(
			'post_parent'    => 0,
			'posts_per_page' => 1,
			'post_type'      => 'digi-society',
			'post_status'    => array( 'publish', 'draft', 'trash', 'inherit' ),
			'fields'         => 'ids',
		) );

		$list_to_recompile = Society_Tools_Class::g()->prepare_list_to_recompile( $main_society_id[0] );

		update_option( 'digirisk_update_6600_list_societies', $list_to_recompile );

		$done = true;

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
	 * Synchronise les "post_status" des sociétés de DigiRisk.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 */
	public function callback_digirisk_update_societies_status() {
		$done = false;

		$count = ! empty( $_POST['args']['count'] ) ? (int) $_POST['args']['count'] : 0;
		$index = ! empty( $_POST['args']['index'] ) ? (int) $_POST['args']['index'] : 0;

		$list_to_recompile = get_option( 'digirisk_update_6600_list_societies', array() );

		$current_list_to_compile = array_splice( $list_to_recompile, 0, $this->limit_update );

		Society_Tools_Class::g()->compile_list( $current_list_to_compile );
		$index += count( $current_list_to_compile );

		update_option( 'digirisk_update_6600_list_societies', $list_to_recompile );

		if ( count( $list_to_recompile ) === 0 ) {
			$done = true;
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => $done,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => $index,
			'errors'            => null,
		) );
	}
}

new Update_660();
