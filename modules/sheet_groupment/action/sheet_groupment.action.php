<?php
/**
 * Gères l'action pour appeler la méthode generate de Fiche_De_Groupement_Class
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action pour appeler la méthode generate de Fiche_De_Groupement_Class
 */
class Sheet_Groupment_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_groupment
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_fiche_de_groupement', array( $this, 'ajax_generate_fiche_de_groupement' ) );
	}

	/**
	 *	Callback function for group sheet generation / Fonction de rappel pour la génération des fiches de groupements
	 */
	function ajax_generate_fiche_de_groupement() {
		check_ajax_referer( 'ajax_generate_fiche_de_groupement' );

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( ! $society_id ) {
			wp_send_json_error();
		}

		Fiche_De_Groupement_Class::g()->generate( $society_id );

		wp_send_json_success();
	}

}

new sheet_groupment_action();
