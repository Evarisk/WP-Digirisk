<?php
/**
 * Gères toutes les actions des EPI.
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des EPI.
 */
class EPI_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_epi', array( $this, 'ajax_save_epi' ) );
		add_action( 'wp_ajax_delete_epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'ajax_load_epi' ) );
	}

	public function ajax_save_epi() {
		// check_ajax_referer( 'edit_epi' );

		$_POST['parent_id'] = $_POST['parent_id'];
		epi_class::g()->update( $_POST );

		ob_start();
		epi_class::g()->display( $_POST['parent_id'] );
		wp_send_json_success( array( 'module' => 'epi', 'callback_success' => 'save_epi_success', 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_epi() {
		if ( 0 === (int)$_POST['id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$id = (int)$_POST['id'];

		check_ajax_referer( 'ajax_delete_epi_' . $id );

		$epi = epi_class::g()->get( array( 'id' => $id ) );
		$epi = $epi[0];

		if ( empty( $epi ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$epi->status = 'trash';

		epi_class::g()->update( $epi );

		wp_send_json_success( array( 'module' => 'epi', 'callback_success' => 'delete_epi_success', 'template' => ob_get_clean() ) );
	}

	/**
	* Charges un epi
	*
	* int $_POST['id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_epi() {
		$id = !empty( $_POST['id'] ) ? (int)$_POST['id'] : 0;

		check_ajax_referer( 'ajax_load_epi_' . $id );
		$epi = epi_class::g()->get( array( 'include' => $id ) );
		$epi = $epi[0];
		$society_id = $epi->parent_id;

		ob_start();
		view_util::exec( 'epi', 'item-edit', array( 'society_id' => $society_id, 'epi' => $epi, 'epi_id' => $id ) );
		wp_send_json_success( array( 'module' => 'epi', 'callback_success' => 'load_epi_success', 'template' => ob_get_clean() ) );
	}
}

new EPI_Action();
