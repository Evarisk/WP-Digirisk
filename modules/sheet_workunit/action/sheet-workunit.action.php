<?php
/**
 * Les actions relatives aux fiches de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package sheet-workunit
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Les actions relatives aux fiches de poste
 */
class Sheet_Workunit_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_workunit
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_fiche_de_poste', array( $this, 'ajax_generate_fiche_de_poste' ) );
	}

	/**
	 * Appelle la méthode generate de Fiche_De_Poste_Class
	 *
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function ajax_generate_fiche_de_poste() {
		check_ajax_referer( 'ajax_generate_fiche_de_poste' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		Fiche_De_Poste_Class::g()->generate( $society_id );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'sheet_workunit',
			'callback_success' => 'generatedFicheDePosteSuccess',
		) );
	}

}

new Sheet_Workunit_Action();
