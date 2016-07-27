<?php
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
	* callback_display_epi
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-epi
	* wp_ajax_wpdigi-load-epi
	* wp_ajax_wpdigi-edit-epi
	* wp_ajax_delete_comment
	*/
	public function __construct() {
		// Remplacé les - en _
		add_action( 'display_epi', array( $this, 'callback_display_epi' ), 10, 1 );
		add_action( 'wp_ajax_wpdigi-delete-epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_wpdigi-load-epi', array( $this, 'ajax_load_epi' ) );
		add_action( 'wp_ajax_wpdigi-edit-epi', array( $this, 'ajax_edit_epi' ) );
	}

	/**
  * Enregistres un epi.
	* Ce callback est le dernier de l'action "save_epi"
  *
	* int $_POST['element_id'] L'ID de l'élement ou le epi sera affecté
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_display_epi( $society_id ) {
	}

	/**
	* Supprimes un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_epi() {
	}

	/**
	* Charges un epi
	*
	* int $_POST['epi_id'] L'ID du epi
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_epi() {
	}
}

new epi_action();
