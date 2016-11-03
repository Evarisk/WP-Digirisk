<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package chemical_product
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class chemical_product_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-chemical_product
	* wp_ajax_wpdigi-load-chemical_product
	* wp_ajax_wpdigi-edit-chemical_product
	*/
	public function __construct() {
		add_action( 'wp_ajax_edit_chemical_product', array( $this, 'ajax_edit_chemical_product' ) );
		add_action( 'wp_ajax_wpdigi-delete-chemical_product', array( $this, 'ajax_delete_chemical_product' ) );
		add_action( 'wp_ajax_load_chemical_product', array( $this, 'ajax_load_chemical_product' ) );
		add_action( 'wp_ajax_edit_chemical_product', array( $this, 'ajax_edit_chemical_product' ) );
	}


	public function ajax_edit_chemical_product() {
		check_ajax_referer( 'edit_chemical_product' );

		if ( !empty( $_POST['chemi_product'] ) ) {
		  foreach ( $_POST['chemi_product'] as $element ) {
				$element['parent_id'] = $_POST['parent_id'];
				chemi_product_class::g()->update( $element );
		  }
		}

		ob_start();
		chemi_product_class::g()->display( $_POST['parent_id'] );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Supprimes un chemical_product
	*
	* int $_POST['chemical_product_id'] L'ID du chemical_product
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_chemical_product() {
		if ( 0 === (int)$_POST['chemical_product_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$chemical_product_id = (int)$_POST['chemical_product_id'];

		check_ajax_referer( 'ajax_delete_chemical_product_' . $chemical_product_id );

		$chemical_product = chemi_product_class::g()->get( array( 'id' => $chemical_product_id ) );
		$chemical_product = $chemical_product[0];

		if ( empty( $chemical_product ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$chemical_product->status = 'trash';

		chemi_product_class::g()->update( $chemical_product );

		wp_send_json_success();
	}

	/**
	* Charges un chemical_product
	*
	* int $_POST['chemical_product_id'] L'ID du chemical_product
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_chemical_product() {
		$chemical_product_id = !empty( $_POST['chemical_product_id'] ) ? (int)$_POST['chemical_product_id'] : 0;

		check_ajax_referer( 'ajax_load_chemical_product_' . $chemical_product_id );
		$chemical_product = chemi_product_class::g()->get( array( 'include' => $chemical_product_id ) );
		$chemical_product = $chemical_product[0];
		$society_id = $chemical_product->parent_id;

		ob_start();
		require( CHEMICAL_PRODUCT_VIEW_DIR . 'item-edit.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new chemical_product_action();
