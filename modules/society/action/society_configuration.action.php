<?php
/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package group
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 */
class Society_Configuration_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_groupment_configuration', array( $this, 'callback_save_groupment_configuration' ) );
	}

	/**
	 * Appelle les méthodes save de Society_Configuration_Class et Address_Class pour enregister les données.
	 *
	 * @return void
	 */
	public function callback_save_groupment_configuration() {
		check_ajax_referer( 'save_groupment_configuration' );

		$groupment_data = (array) $_POST['groupment'];

		$address = Address_Class::g()->save( $_POST['address'] );
		$groupment_data['contact']['address_id'][] = $address->id;

		$group = Society_Configuration_Class::g()->save( $groupment_data );

		wp_send_json_success( array( 'group' => $group, 'address' => $address ) );
	}
}

new Society_Configuration_Action();
