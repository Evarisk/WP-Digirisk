<?php
/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 */
class Society_Informations_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_configuration', array( $this, 'callback_save_configuration' ) );
	}

	/**
	 * Appelle les méthodes save de Society_Configuration_Class et Address_Class pour enregister les données.
	 *
	 * @since 6.2.2
	 * @version 6.3.0
	 *
	 * @return void
	 */
	public function callback_save_configuration() {
		check_ajax_referer( 'save_configuration' );

		$data = (array) $_POST['society'];

		$address = Address_Class::g()->save( $_POST['address'] );
		$data['contact']['address_id'][] = $address->id;

		$society = Society_Informations_Class::g()->save( $data );

		wp_send_json_success( array(
			'society' => $society,
			'address' => $address,
			'namespace' => 'digirisk',
			'module' => 'society',
			'callback_success' => 'savedSocietyConfiguration',
		) );
	}
}

new Society_Informations_Action();
