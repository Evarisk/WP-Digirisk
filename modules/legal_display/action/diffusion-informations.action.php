<?php
/**
 * Les actions relatives aux diffusions d'informations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
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
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_diffusion_information', array( $this, 'callback_generate_diffusion_information' ), 10, 2 );
	}

	/**
	 * L'action appelant la fonction pour générer la diffusion d'informations.
	 *
	 * @since 6.2.10
	 * @version 6.3.0
	 */
	public function callback_generate_diffusion_information() {
		check_ajax_referer( 'generate_diffusion_information' );

		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$element = Society_Class::g()->show_by_type( $parent_id );

		$data = array(
			'parent_id' => $parent_id,
			'document_meta' => array(
				'delegues_du_personnels_date' => ! empty( $_POST['delegues_du_personnels_date'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_date'] ) : '',
				'delegues_du_personnels_titulaires' => ! empty( $_POST['delegues_du_personnels_titulaires'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_titulaires'] ) : '',
				'delegues_du_personnels_suppleants' => ! empty( $_POST['delegues_du_personnels_suppleants'] ) ? sanitize_text_field( $_POST['delegues_du_personnels_suppleants'] ) : '',
				'membres_du_comite_entreprise_date' => ! empty( $_POST['membres_du_comite_entreprise_date'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_date'] ) : '',
				'membres_du_comite_entreprise_titulaires' => ! empty( $_POST['membres_du_comite_entreprise_titulaires'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_titulaires'] ) : '',
				'membres_du_comite_entreprise_suppleants' => ! empty( $_POST['membres_du_comite_entreprise_suppleants'] ) ? sanitize_text_field( $_POST['membres_du_comite_entreprise_suppleants'] ) : '',
			),
		);

		Diffusion_Informations_Class::g()->update( $data );
		Diffusion_Informations_Class::g()->generate_sheet( $_POST, $element,  'A3' );
		Diffusion_Informations_Class::g()->generate_sheet( $_POST, $element,  'A4' );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'legalDisplay',
			'callback_success' => 'generatedDiffusionInformationSuccess',
		) );
	}
}

new Diffusion_Informations_Action();
