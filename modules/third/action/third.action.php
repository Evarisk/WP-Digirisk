<?php
/**
 * Les actions des tiers.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions des tiers.
 */
class Third_Action {

	/**
	 * Le constructeur appelle l'action ajax: wp_ajax_save_legal_display
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_legal_display', array( $this, 'callback_save_legal_display' ), 1 );
	}

	/**
	 * Sauvegardes les données de tier pour l'affichage légal
	 *
	 * @since 6.1.3
	 * @version 6.5.0
	 */
	public function callback_save_legal_display() {
		check_ajax_referer( 'save_legal_display' );

		// Récupère les tableaux.
		$detective_work              = ! empty( $_POST['detective_work'] ) ? (array) $_POST['detective_work'] : array();
		$occupational_health_service = ! empty( $_POST['occupational_health_service'] ) ? (array) $_POST['occupational_health_service'] : array();

		// On enregistre les adresses.
		$detective_work_address              = Address_Class::g()->save( $detective_work['address'] );
		$occupational_health_service_address = Address_Class::g()->save( $occupational_health_service['address'] );

		$detective_work['contact']['address_id']              = $detective_work_address->id;
		$occupational_health_service['contact']['address_id'] = $occupational_health_service_address->id;

		$detective_work['opening_time']              = $detective_work['opening_time'];
		$occupational_health_service['opening_time'] = $occupational_health_service['opening_time'];

		$detective_work_third              = Third_Class::g()->save_data( $detective_work );
		$occupational_health_service_third = Third_Class::g()->save_data( $occupational_health_service );

		do_action( 'save_legal_display', $detective_work_third, $occupational_health_service_third );
	}
}

new Third_Action();
