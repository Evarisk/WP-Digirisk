<?php
/**
 * Les actions relatives aux fiches de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Les actions relatives aux fiches de groupement
 */
class Sheet_Groupment_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_groupment
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_fiche_de_groupement', array( $this, 'ajax_generate_fiche_de_groupement' ) );
	}

	/**
	 * Appel la méthode "generate" de "Fiche_De_Groupement_Class" afin de générer la fiche de groupement.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	function ajax_generate_fiche_de_groupement() {
		check_ajax_referer( 'ajax_generate_fiche_de_groupement' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		Fiche_De_Groupement_Class::g()->generate( $society_id );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'sheet_groupment',
			'callback_success' => 'generatedSheetGroupment'
		) );
	}

}

new sheet_groupment_action();
