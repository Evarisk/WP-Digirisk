<?php
/**
 * Les actions relatives aux diffusions d'informations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.10
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux diffusions d'informations
 */
class Diffusion_Informations_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.10
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_diffusion_information', array( $this, 'callback_save_diffusion_information' ), 10, 2 );
		add_action( 'wp_ajax_generate_diffusion_information', array( $this, 'callback_generate_diffusion_information' ), 10, 2 );
	}

	public function callback_save_diffusion_information() {
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0; // WPCS: input var ok.

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$element = Society_Class::g()->show_by_type( $parent_id );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'diffusionInformations',
			'callback_success' => 'generatedDiffusionInformationSuccess',
		) );
	}

	/**
	 * L'action appelant la fonction pour générer la diffusion d'informations.
	 *
	 * @since 6.2.10
	 *
	 * @todo: nonce
	 */
	public function callback_generate_diffusion_information() {
		// check_ajax_referer( 'generate_diffusion_information' );

		$element               = Society_Class::g()->get( array( 'posts_per_page' => 1 ), true );
		$diffusion_information = Legal_Display_Class::g()->get_diffusion_information( $element->data[ 'id' ] );

		$response = Diffusion_Informations_A3_Class::g()->prepare_document( $element, array(
			'diffusion_information' => $diffusion_information,
		) );

		Diffusion_Informations_A3_Class::g()->create_document( $response['document']->data['id'] );

		$response = Diffusion_Informations_A4_Class::g()->prepare_document( $element, array(
			'diffusion_information' => $diffusion_information,
		) );

		Diffusion_Informations_A4_Class::g()->create_document( $response['document']->data['id'] );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'diffusionInformations',
			'callback_success' => 'generatedDiffusionInformationSuccess',
		) );
	}
}

new Diffusion_Informations_Action();
