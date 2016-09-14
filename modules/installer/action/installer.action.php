<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controller pour installer digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Fichier du controller pour installer digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class installer_action {

	/**
	 * Le constructeur appelle les méthodes admin_post et ajax suivantes:
	 * wp_ajax_wpdigi-installer-step-1 (Créer la societé et les données par défaut de Digirisk)
	 * admin_post_last_step (Renvoie sur la page principale de Digirisk)
	 */
	public function __construct() {
		// todo Renommes avec des underscores
		add_action( 'wp_ajax_wpdigi-installer-step-1', array( $this, 'ajax_installer_step_1' ) );
		add_action( 'admin_post_last_step', array( $this, 'admin_post_last_step' ) );
	}

	/**
	* Créer la societé et les données par défaut de Digirisk (Danger, recommendation, méthode d'évaluation et méthode d'évaluation variable)
	* Passes la clé installed de l'option "_digirisk_core" de WordPress à true
	* Passes la clé db_version de l'option "_digirsk_core" à 1
	* Met les documents par défault.
	*
	* array $_POST['address'] Les données envoyées par le formulaire pour l'adresse
	* string $_POST['address']['address'] L'adresse
	* string $_POST['address']['additional_address'] L'adresse complémentaire
	* string $_POST['address']['postcode'] Le code postal
	* string $_POST['address']['town'] La ville
	*
	* array $_POST['groupement'] Les données envoyées par le formulaire pour la societé
	* string $_POST['groupement']['title'] Le nom de la societé
	* string $_POST['groupement']['content'] La description de la societé
	* string $_POST['groupement']['date'] La date de création de la societé
	* string $_POST['groupement']['option']['identity']['siren'] Le SIREN de la societé
	* string $_POST['groupement']['option']['identity']['siret'] Le SIRET de la societé
	* string $_POST['groupement']['option']['contact']['phone'] Le téléphone de la societé
	*
	* int $_POST['owner_id'] Le responsable de la societé
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_installer_step_1() {
		check_ajax_referer( 'ajax_installer_step_1' );

		$address = address_class::g()->create( $_POST['address'] );
		$groupment = group_class::g()->create( $_POST['groupment'] );
		$groupment->contact['address_id'][] = $address->id;
		group_class::g()->update( $groupment );
		$address->post_id = $groupment->id;
		address_class::g()->update( $address );

		$danger_created = danger_default_data_class::g()->create();
		$recommendation_created = recommendation_default_data_class::g()->create();
		$evaluation_method_created = evaluation_method_default_data_class::g()->create();

		$document_unique_setted = document_class::g()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/document_unique.odt', 'document_unique' );
		$document_workunit_sheet_setted = document_class::g()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/fiche_de_poste.odt', 'fiche_de_poste' );

		// Met à jours l'option pour dire que l'installation est terminée
		update_option( WPDIGI_CORE_OPTION_NAME, array( 'installed' => true, 'db_version' => 1 ) );

		wp_send_json_success();
	}

	/**
	* Rediriges vers la page principale de Digirisk.
	*/
	public function admin_post_last_step() {
		if( empty( $_GET['_wpnonce'] ) ) {
			wp_safe_redirect( wp_get_referer() );
			die();
		}
		$wpnonce = sanitize_text_field( $_GET['_wpnonce'] );

		if ( !wp_verify_nonce( $wpnonce, 'last_step' ) ) {
			wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
		}

		wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
	}
}

new installer_action();
