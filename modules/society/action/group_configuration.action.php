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
		// todo: Doublon avec installer
    check_ajax_referer( 'save_groupment_configuration' );

    $groupment_id = !empty( $_POST['groupment_id'] ) ? (int) $_POST['groupment_id'] : 0;

    // Modifie les valeurs du groupement
    $groupment = group_class::get()->show( $groupment_id );
    $groupment->title = !empty( $_POST['groupement']['title'] ) ? sanitize_text_field( $_POST['groupement']['title'] ) : $groupment->title;
    $groupment->date = !empty( $_POST['groupement']['date'] ) ? sanitize_text_field( $_POST['groupement']['date'] ) : $groupment->date;
    $groupment->content = !empty( $_POST['groupement']['content'] ) ? sanitize_text_field( $_POST['groupement']['content'] ) : $groupment->content;
    $groupment->option['identity']['siren'] = !empty( $_POST['groupement']['option']['identity']['siren'] ) ? sanitize_text_field( $_POST['groupement']['option']['identity']['siren'] ) : $groupment->option['identity']['siren'];
    $groupment->option['identity']['siret'] = !empty( $_POST['groupement']['option']['identity']['siret'] ) ? sanitize_text_field( $_POST['groupement']['option']['identity']['siret'] ) : $groupment->option['identity']['siret'];

    if ( !empty( $_POST['owner_id'] ) ) {
      $owner_id = (int) $_POST['owner_id'];
      $groupment->option['user_info']['owner_id'] = $owner_id;
    }

    if ( !empty( $_POST['groupement']['option']['contact']['phone'] ) ) {
      $groupment->option['contact']['phone'][] = sanitize_text_field( $_POST['groupement']['option']['contact']['phone'] );
    }

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

    $groupment->option['contact']['address'][] = $address->id;
    group_class::get()->update( $groupment );

    wp_send_json_success();
  }
}

new wpdigi_group_configuration_action();
