<?php
/**
 * Gestion de l'action pour enregistrer les informations d'une société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.2
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Society informations action.
 */
class Society_Configuration_Action {

	/**
	 * Constructeur.
	 *
	 * @since 6.2.2
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_configuration', array( $this, 'callback_save_configuration' ) );
	}

	/**
	 * Appelle les méthodes save de Society_Configuration_Class et Address_Class pour enregister les données.
	 *
	 * @since   6.2.2
	 */
	public function callback_save_configuration() {
		check_ajax_referer( 'save_configuration' );

		$society_data                        = array( 'contact' => array() );
		$society_data['id']                  = ! empty( $_POST['society']['id'] ) ? (int) $_POST['society']['id'] : 0; // WPCS: input var ok.
		$society_data['type']                = ! empty( $_POST['society']['type'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['type'] ) ) : ''; // WPCS: input var ok.
		$society_data['title']               = ! empty( $_POST['society']['title'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['title'] ) ) : ''; // WPCS: input var ok.
		$society_data['siret_id']            = ! empty( $_POST['society']['siret_id'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['siret_id'] ) ) : ''; // WPCS: input var ok.
		$society_data['number_of_employees'] = ! empty( $_POST['society']['number_of_employees'] ) ? (int) $_POST['society']['number_of_employees'] : 0; // WPCS: input var ok.
		$society_data['owner_id']            = ! empty( $_POST['society']['owner_id'] ) ? (int) $_POST['society']['owner_id'] : 0; // WPCS: input var ok.
		$society_data['date']                = ! empty( $_POST['society']['date'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['date'] ) ) : ''; // WPCS: input var ok.
		$society_data['contact']['phone']    = ! empty( $_POST['society']['contact']['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['contact']['phone'] ) ) : ''; // WPCS: input var ok.
		$society_data['contact']['email']    = ! empty( $_POST['society']['contact']['email'] ) ? sanitize_text_field( wp_unslash( $_POST['society']['contact']['email'] ) ) : ''; // WPCS: input var ok.
		$society_data['content']             = ! empty( $_POST['society']['content'] ) ? wp_unslash( $_POST['society']['content'] ) : ''; // WPCS: input var ok.

		$address_data                       = array();
		$address_data['post_id']            = $society_data['id'];
		$address_data['address']            = ! empty( $_POST['address']['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['address'] ) ) : ''; // WPCS: input var ok.
		$address_data['additional_address'] = ! empty( $_POST['address']['additional_address'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['additional_address'] ) ) : ''; // WPCS: input var ok.
		$address_data['postcode']           = ! empty( $_POST['address']['postcode'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['postcode'] ) ) : ''; // WPCS: input var ok.
		$address_data['town']               = ! empty( $_POST['address']['town'] ) ? sanitize_text_field( wp_unslash( $_POST['address']['town'] ) ) : ''; // WPCS: input var ok.

		$address                               = Address_Class::g()->save( $address_data );
		$society_data['contact']['address_id'] = $address->data['id'];

		$society = Society_Configuration_Class::g()->save( $society_data );

		ob_start();
		Tab_Class::g()->load_tab_content( $society->data['id'], array(
			'slug'  => 'digi-informations',
			'title' => 'Informations',
		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'society'          => $society,
			'address'          => $address,
			'namespace'        => 'digirisk',
			'module'           => 'society',
			'callback_success' => 'savedSocietyConfigurationSuccess',
			'view'             => $view,
		) );
	}
}

new Society_Configuration_Action();
