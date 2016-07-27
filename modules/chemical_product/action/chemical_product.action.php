<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package chemical_product
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class chemical_product_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* callback_display_chemical_product
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-chemical_product
	* wp_ajax_wpdigi-load-chemical_product
	* wp_ajax_wpdigi-edit-chemical_product
	* wp_ajax_delete_comment
	*/
	public function __construct() {
		// Remplacé les - en _
		add_action( 'display_chemical_product', array( $this, 'callback_display_chemical_product' ), 10, 1 );
		add_action( 'wp_ajax_wpdigi-delete-chemical_product', array( $this, 'ajax_delete_chemical_product' ) );
		add_action( 'wp_ajax_wpdigi-load-chemical_product', array( $this, 'ajax_load_chemical_product' ) );
		add_action( 'wp_ajax_wpdigi-edit-chemical_product', array( $this, 'ajax_edit_chemical_product' ) );
	}

	/**
  * Enregistres un chemical_product.
	* Ce callback est le dernier de l'action "save_chemical_product"
  *
	* int $_POST['element_id'] L'ID de l'élement ou le chemical_product sera affecté
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_display_chemical_product( $society_id ) {
	}

	/**
	* Supprimes un chemical_product
	*
	* int $_POST['chemical_product_id'] L'ID du chemical_product
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_chemical_product() {
	}

	/**
	* Charges un chemical_product
	*
	* int $_POST['chemical_product_id'] L'ID du chemical_product
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_chemical_product() {
	}
}

new chemical_product_action();
