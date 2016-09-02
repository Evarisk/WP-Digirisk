<?php if ( !defined( 'ABSPATH' ) ) exit;

class wpdigi_group_configuration_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_groupment_configuration
	*/
  public function __construct() {
    add_action( 'wp_ajax_save_groupment_configuration', array( $this, 'callback_save_groupment_configuration' ) );
  }

	/**
	* Sauvegardes toutes les données d'un groupement
	*
	* int $_POST['groupment_id'] L'ID du groupement
	*
	* array $_POST['address'] Les données envoyées par le formulaire pour l'adresse
	* string $_POST['address']['address'] L'adresse
	* string $_POST['address']['additional_address'] L'adresse complémentaire
	* string $_POST['address']['postcode'] Le code postal
	* string $_POST['address']['town'] La ville
	*
	* array $_POST['groupment'] Les données du groupement envoyées par le formulaire
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
  public function callback_save_groupment_configuration() {
    check_ajax_referer( 'save_groupment_configuration' );

		group_configuration_class::g()->save( $_POST['groupment'] );
		address_class::g()->save( $_POST['address'] );

    wp_send_json_success();
  }
}

new wpdigi_group_configuration_action();
