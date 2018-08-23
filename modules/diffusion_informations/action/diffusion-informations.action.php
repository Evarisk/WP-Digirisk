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
		add_action( 'wp_ajax_generate_diffusion_information', array( $this, 'callback_generate_diffusion_information' ), 10, 2 );
	}

	/**
	 * L'action appelant la fonction pour générer la diffusion d'informations.
	 *
	 * @since 6.2.10
	 */
	public function callback_generate_diffusion_information() {
		check_ajax_referer( 'generate_diffusion_information' );

		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0; // WPCS: input var ok.

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$element = Society_Class::g()->show_by_type( $parent_id );

		$data = array(
			'parent_id'                               => $parent_id,
			'status'                                  => 'inherit',
			'delegues_du_personnels_date'             => ! empty( $_POST['delegues_du_personnels_date'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_date'] ) : '',
			'delegues_du_personnels_titulaires'       => ! empty( $_POST['delegues_du_personnels_titulaires'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_titulaires'] ) : '',
			'delegues_du_personnels_suppleants'       => ! empty( $_POST['delegues_du_personnels_suppleants'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_suppleants'] ) : '',
			'membres_du_comite_entreprise_date'       => ! empty( $_POST['membres_du_comite_entreprise_date'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_date'] ) : '',
			'membres_du_comite_entreprise_titulaires' => ! empty( $_POST['membres_du_comite_entreprise_titulaires'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_titulaires'] ) : '',
			'membres_du_comite_entreprise_suppleants' => ! empty( $_POST['membres_du_comite_entreprise_suppleants'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_suppleants'] ) : '',
		);

		$diffusion_information = Diffusion_Informations_Class::g()->update( $data );

		$response = Diffusion_Informations_A3_Class::g()->prepare_document( $parent_id, array(
			'diffusion_information' => $diffusion_information,
		) );

		$response = Diffusion_Informations_A4_Class::g()->prepare_document( $parent_id, array(
			'diffusion_information' => $diffusion_information,
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'diffusionInformations',
			'callback_success' => 'generatedDiffusionInformationSuccess',
		) );
	}
}

new Diffusion_Informations_Action();
