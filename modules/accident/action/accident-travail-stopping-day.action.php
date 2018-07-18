<?php
/**
 * Gestion des actions des accidents "stopping day"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des accidents
 */
class Accident_Travail_Stopping_Day_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_stopping_day', array( $this, 'callback_save_stopping_day' ) );
		add_action( 'wp_ajax_delete_stopping_day', array( $this, 'callback_delete_stopping_day' ) );
	}

	/**
	 * Sauvegardes un "stopping day".
	 *
	 * @since 6.4.0
	 * @version 6.4.4
	 *
	 * @return void
	 */
	public function callback_save_stopping_day() {
		$accident_stopping_days = ! empty( $_POST['accident_stopping_day'] ) ? (array) $_POST['accident_stopping_day'] : array();
		$accident_id            = ! empty( $_POST['accident_id'] ) ? (int) $_POST['accident_id'] : 0;

		if ( empty( $accident_id ) ) {
			wp_send_json_error();
		}

		Accident_Travail_Stopping_Day_Class::g()->save_stopping_day( $accident_stopping_days );

		$accident = Accident_Class::g()->get( array(
			'id' => $accident_id,
		), true );

		$accident->data['compiled_stopping_days'] = 0;

		if ( ! empty( $accident->data['stopping_days'] ) ) {
			foreach ( $accident->data['stopping_days'] as $stopping_days ) {
				$accident->data['compiled_stopping_days'] += (int) $stopping_days->data['content'];
			}
		}

		$accident = Accident_Class::g()->update( $accident->data );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-stopping-day', array(
			'accident' => $accident,
		) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'accident',
			'callback_success' => 'editedStoppingDaySuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Passes le post en status 'trash'.
	 *
	 * @since 6.4.0
	 */
	public function callback_delete_stopping_day() {
		check_ajax_referer( 'delete_stopping_day' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		Accident_Travail_Stopping_Day_Class::g()->update( array(
			'id'     => $id,
			'status' => 'trash',
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'accident',
			'callback_success' => 'deletedStoppingDay',
		) );
	}
}

new Accident_Travail_Stopping_Day_Action();
