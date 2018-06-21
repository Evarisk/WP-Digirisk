<?php
/**
 * Gestion de la requête AJAX pour enregistrer la configuration d'un groupement
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
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
	 * @since   6.2.2
	 * @version 7.0.0
	 *
	 * @return void
	 */
	public function callback_save_configuration() {
		check_ajax_referer( 'save_configuration' );

		$data    = (array) $_POST['society'];
		$address = (array) $_POST['address'];

		$address                       = Address_Class::g()->save( $address );
		$data['contact']['address_id'] = $address->data['id'];

		$society = Society_Informations_Class::g()->save( $data );

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

new Society_Informations_Action();
