<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package accident
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class accident_action {
	/**
	* Le constructeur appelle une action personnalisée:
	* callback_display_accident
	* Il appelle également les actions ajax suivantes:
	* wp_ajax_wpdigi-delete-accident
	* wp_ajax_wpdigi-load-accident
	* wp_ajax_wpdigi-edit-accident
	* wp_ajax_delete_comment
	*/
	public function __construct() {
		// Remplacé les - en _
		add_action( 'display_accident', array( $this, 'callback_display_accident' ), 10, 1 );
		add_action( 'wp_ajax_wpdigi-delete-accident', array( $this, 'ajax_delete_accident' ) );
		add_action( 'wp_ajax_wpdigi-load-accident', array( $this, 'ajax_load_accident' ) );
		add_action( 'wp_ajax_wpdigi-edit-accident', array( $this, 'ajax_edit_accident' ) );
	}

	/**
  * Enregistres un accident.
	* Ce callback est le dernier de l'action "save_accident"
  *
	* int $_POST['element_id'] L'ID de l'élement ou le accident sera affecté
	*
	* @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_display_accident( $society_id ) {
	}

	/**
	* Supprimes un accident
	*
	* int $_POST['accident_id'] L'ID du accident
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_delete_accident() {
	}

	/**
	* Charges un accident
	*
	* int $_POST['accident_id'] L'ID du accident
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_accident() {
	}
}

new accident_action();
