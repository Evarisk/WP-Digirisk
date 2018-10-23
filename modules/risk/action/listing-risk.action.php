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
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_listing_risk', array( $this, 'callback_generate_listing_risk' ) );
	}

	/**
	 * Appelle la méthode generate de Listing_Risk_Class.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_generate_listing_risk() {
		check_ajax_referer( 'generate_listing_risk' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$type       = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';

		if ( empty( $society_id ) || empty( $type ) ) {
			wp_send_json_error();
		}

		Listing_Risk_Class::g()->generate( $society_id, $type );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'listingRisk',
			'callback_success' => 'generatedListingRiskSuccess',
		) );
	}
}

new Listing_Risk_Action();
