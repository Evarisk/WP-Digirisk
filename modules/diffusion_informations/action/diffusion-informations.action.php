<?php
/**
 * Les actions relatives aux diffusions d'informations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.10
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
	 * @version 6.6.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_diffusion_information', array( $this, 'callback_save_diffusion_information' ), 10, 2 );
		add_action( 'wp_ajax_generate_diffusion_information', array( $this, 'callback_generate_diffusion_information' ), 10, 2 );
	}

	public function callback_save_diffusion_information() {
		check_ajax_referer( 'save_diffusion_information' );

		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		Diffusion_Informations_Class::g()->save_information( $parent_id, $_POST );

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		wp_send_json_success();
	}

	/**
	 * L'action appelant la fonction pour générer la diffusion d'informations.
	 *
	 * @since 6.2.10
	 * @version 6.4.4
	 */
	public function callback_generate_diffusion_information() {
		check_ajax_referer( 'generate_diffusion_information' );

		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$element = Society_Class::g()->show_by_type( $parent_id );

		Diffusion_Informations_Class::g()->save_information( $parent_id, $_POST );
		Diffusion_Informations_Class::g()->generate_sheet( $_POST, $element, 'A3' );
		Diffusion_Informations_Class::g()->generate_sheet( $_POST, $element, 'A4' );

		ob_start();
		Diffusion_Informations_Class::g()->display( $parent_id );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'diffusionInformations',
			'callback_success' => 'generatedDiffusionInformationSuccess',
			'view'             => ob_get_clean(),
		) );
	}
}

new Diffusion_Informations_Action();
