<?php
/**
 * @TODO : A détailler
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.9.0
 * @copyright 2015-2017
 * @package accident
 * @subpackage action
 */

if ( ! defined( 'ABSPATH' ) ) { exit;
}

class accident_action {
	/**
	 * Le constructeur appelle une action personnalisée:
	 * Il appelle également les actions ajax suivantes:
	 * wp_ajax_wpdigi-delete-accident
	 * wp_ajax_wpdigi-load-accident
	 * wp_ajax_wpdigi-edit-accident
	 */
	public function __construct() {
		add_action( 'wp_ajax_edit_accident', array( $this, 'ajax_edit_accident' ) );
		add_action( 'wp_ajax_wpdigi-delete-accident', array( $this, 'ajax_delete_accident' ) );
		add_action( 'wp_ajax_load_accident', array( $this, 'ajax_load_accident' ) );
		add_action( 'wp_ajax_wpdigi-edit-accident', array( $this, 'ajax_edit_accident' ) );
	}

	public function ajax_edit_accident() {
		check_ajax_referer( 'edit_accident' );

		if ( ! empty( $_POST['accident'] ) ) {
			foreach ( $_POST['accident'] as $element ) {
				$element['parent_id'] = $_POST['parent_id'];
				$accident = accident_class::g()->update( $element );

				do_action( 'add_compiled_accident_id', $accident );
				do_action( 'add_compiled_stop_day_id', $accident );
			}
		}

		ob_start();
		accident_class::g()->display( $_POST['parent_id'] );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	 * Supprimes un accident
	 *
	 * int $_POST['accident_id'] L'ID du accident
	 *
	 * @param array $_POST Les données envoyées par le formulaire
	 */
	public function ajax_delete_accident() {
		if ( 0 === (int) $_POST['accident_id'] ) {
			wp_send_json_error( array( 'error' => __LINE__ ) );
		} else { 			$accident_id = (int) $_POST['accident_id'];
		}

		check_ajax_referer( 'ajax_delete_accident_' . $accident_id );

		$accident = accident_class::g()->get( array( 'id' => $accident_id ) );
		$accident = $accident[0];

		if ( empty( $accident ) ) {
			wp_send_json_error( array( 'error' => __LINE__ ) );
		}

		$accident->status = 'trash';
		do_action( 'delete_compiled_accident_id', $accident );
		do_action( 'delete_compiled_stop_day_id', $accident );

		accident_class::g()->update( $accident );

		wp_send_json_success();
	}

	/**
	 * Charges un accident
	 *
	 * int $_POST['accident_id'] L'ID du accident
	 *
	 * @param array $_POST Les données envoyées par le formulaire
	 */
	public function ajax_load_accident() {
		$accident_id = ! empty( $_POST['accident_id'] ) ? (int) $_POST['accident_id'] : 0;

		check_ajax_referer( 'ajax_load_accident_' . $accident_id );
		$accident = accident_class::g()->get( array( 'include' => $accident_id ) );
		$accident = $accident[0];
		$society_id = $accident->parent_id;

		ob_start();
		require( ACCIDENT_VIEW_DIR . 'item-edit.php' );
		wp_send_json_success( array(
			'template' => ob_get_clean()
		) );
	}
}

new accident_action();
