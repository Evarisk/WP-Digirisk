<?php
/**
 * Les actions relatives aux listing de risques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux listing de risques.
 */
class Listing_Risk_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_listing_risk', array( $this, 'callback_generate_listing_risk' ) );
	}

	/**
	 * Appelle la méthode generate de Listing_Risk_Class.
	 *
	 * @since 6.5.0
	 */
	public function callback_generate_listing_risk() {
		check_ajax_referer( 'generate_listing_risk' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.
		$type       = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : ''; // WPCS: input var ok.

		if ( empty( $society_id ) || empty( $type ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->show_by_type( $society_id );

		switch ( $type ) {
			case 'photos':
				$response = Listing_Risk_Picture_Class::g()->prepare_document( $society, array(
					'type' => $type,
				) );

				Listing_Risk_Picture_Class::g()->create_document( $response['document']->data['id'] );
				break;
			case 'actions':
				$response = Listing_Risk_Corrective_Task_Class::g()->prepare_document( $society, array(
					'type' => $type,
				) );

				Listing_Risk_Corrective_Task_Class::g()->create_document( $response['document']->data['id'] );
				break;
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'listingRisk',
			'callback_success' => 'generatedListingRiskSuccess',
			'type'             => $type,
		) );
	}
}

new Listing_Risk_Action();
