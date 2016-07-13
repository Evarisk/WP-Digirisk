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

		$postcode = '';

		if ( !empty( $_POST['address']['postcode'] ) ) {
			$postcode = (int) $_POST['address']['postcode'];
			if ( strlen( $postcode ) > 5 )
				$postcode = substr( $postcode, 0, 5 );
		}

		$date = date( 'Y-m-d', strtotime( str_replace( '/', '-', sanitize_text_field( $_POST['groupement']['date'] ) ) ) );

		$address = array(
			'date' => $date,
			'option' => array(
				'address' => sanitize_text_field( $_POST['address']['address'] ),
				'additional_address' => sanitize_text_field( $_POST['address']['additional_address'] ),
				'postcode' => $postcode,
				'town' => sanitize_text_field( $_POST['address']['town'] ),
			),
		);
		$address = address_class::get()->create( $address );

		// On récupère le last unique key
		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', group_class::get()->get_post_type() );
		$last_unique_key++;
		if ( empty( $last_unique_key ) ) $last_unique_key = 1;

		$groupment = array(
			'title' => sanitize_text_field( $_POST['groupement']['title'] ),
			'content' => sanitize_text_field( $_POST['groupement']['content'] ),
			'date' => $date,
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => group_class::get()->element_prefix . $last_unique_key,
				'identity' => array(
					'siren' => sanitize_text_field( $_POST['groupement']['option']['identity']['siren'] ),
					'siret' => sanitize_text_field( $_POST['groupement']['option']['identity']['siret'] ),
				),
				'contact' => array(
					'phone' => array( sanitize_text_field( $_POST['groupement']['option']['contact']['phone'] ) ),
				),
			),
		);

		if ( !empty( $address ) && !empty( $address->id ) ) {
			$groupment['option']['contact']['address_id'] = array( $address->id );
		}

		if ( !empty( $_POST['owner_id'] ) ) {
      $owner_id = (int) $_POST['owner_id'];
      $groupment->option['user_info']['owner_id'] = $owner_id;
    }

		$groupement = group_class::get()->create( $groupment );

		/** On crée les dangers */
		$danger_created = danger_class::get()->create_default_data();

		$recommendation_created = recommendation_class::get()->create_default_data();

		$evaluation_method_created = evaluation_method_class::get()->create_default_data();

		/** Définition des modèles de documents / Define document model to use */
		$document_unique_setted = document_class::get()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/document_unique.odt', 'document_unique' );
		$document_workunit_sheet_setted = document_class::get()->set_default_document( WPDIGI_PATH . 'core/assets/document_template/fiche_de_poste.odt', 'fiche_de_poste' );

		// Met à jours l'option pour dire que l'installation est terminée
		update_option( WPDIGI_CORE_OPTION_NAME, array( 'installed' => true, 'db_version' => 1 ) );

		wp_send_json_success(
			array(
				'groupment' => $groupment,
				'address' => $address,
				'danger_created' => $danger_created,
				'recommendation_created' => $recommendation_created,
				'evaluation_method_created' => $evaluation_method_created,
				'document_unique_setted' => $document_unique_setted,
				'document_workunit_sheet_setted' => $document_workunit_sheet_setted,
			)
		);
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
