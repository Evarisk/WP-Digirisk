<?php
/**
 * Gères l'action pour appeler la méthode generate de Fiche_De_Poste_Class
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action pour appeler la méthode generate de Fiche_De_Poste_Class
 */
class Sheet_Workunit_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_workunit
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_fiche_de_poste', array( $this, 'ajax_generate_fiche_de_poste' ) );
	}

	/**
	 * Appelle la méthode generate de Fiche_De_Poste_Class
	 *
	 * @return void
	 */
	public function ajax_generate_fiche_de_poste() {
		check_ajax_referer( 'ajax_generate_fiche_de_poste' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		Fiche_De_Poste_Class::g()->generate( $society_id );

		wp_send_json_success();
	}

}

new Sheet_Workunit_Action();
