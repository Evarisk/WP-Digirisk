<?php
/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package society
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
	 * @since 6.2.2.0
	 * @version 6.2.9.0
	 *
	 * @return void
	 */
	public function callback_save_groupment_configuration() {
		check_ajax_referer( 'save_groupment_configuration' );

		$groupment_data = (array) $_POST['groupment'];

		$address = Address_Class::g()->save( $_POST['address'] );
		$groupment_data['contact']['address_id'][] = $address->id;

		$group = Society_Configuration_Class::g()->save( $groupment_data );

		wp_send_json_success( array(
			'society' => $group,
			'address' => $address,
			'namespace' => 'digirisk',
			'module' => 'society',
			'callback_success' => 'savedSocietyConfiguration',
		) );
	}
}

new Society_Configuration_Action();
