<?php namespace digi;
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package epi
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class epi_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-epi
	* wp_ajax_wpdigi-load-epi
	* wp_ajax_wpdigi-edit-epi
	*/
	public function __construct() {
		add_action( 'wp_ajax_edit_epi', array( $this, 'ajax_edit_epi' ) );
		add_action( 'wp_ajax_wpdigi-delete-epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'ajax_load_epi' ) );
		add_action( 'wp_ajax_wpdigi-edit-epi', array( $this, 'ajax_edit_epi' ) );
	}


	public function ajax_edit_epi() {
		check_ajax_referer( 'edit_epi' );

		if ( !empty( $_POST['epi'] ) ) {
		  foreach ( $_POST['epi'] as $element ) {
				$element['parent_id'] = $_POST['parent_id'];
				epi_class::g()->update( $element );
		  }
		}

		ob_start();
		epi_class::g()->display( $_POST['parent_id'] );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_epi() {
		if ( 0 === (int)$_POST['epi_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$epi_id = (int)$_POST['epi_id'];

		check_ajax_referer( 'ajax_delete_epi_' . $epi_id );

		$epi = epi_class::g()->get( array( 'id' => $epi_id ) );
		$epi = $epi[0];

		if ( empty( $epi ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$epi->status = 'trash';

		epi_class::g()->update( $epi );

		wp_send_json_success();
	}

	/**
	* Charges un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_epi() {
		$epi_id = !empty( $_POST['epi_id'] ) ? (int)$_POST['epi_id'] : 0;

		check_ajax_referer( 'ajax_load_epi_' . $epi_id );
		$epi = epi_class::g()->get( array( 'include' => $epi_id ) );
		$epi = $epi[0];
		$society_id = $epi->parent_id;

		ob_start();
		require( EPI_VIEW_DIR . 'item-edit.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new epi_action();
