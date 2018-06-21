<?php
/**
 * Gestion des filtres relatifs aux affichages légaux
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux affichages légaux
 */
class Legal_Display_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since   6.0.0
	 * @version 7.0.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );

		$current_type = Legal_Display_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_legal_display' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet affichage légal dans les groupements.
	 *
	 * @since   6.0.0
	 * @version 7.0.0
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['legal_display'] = array(
			'type'  => 'text',
			'text'  => __( 'Affichage légal', 'digirisk' ),
			'title' => __( 'Les affichages légales', 'digirisk' ),
		);
		return $list_tab;
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement de l'affichage légal
	 * Inspection du travail avec son adresse, Nom du médecin avec son adresse
	 *
	 * @since   6.0.0
	 * @version 7.0.0
	 *
	 * @param  Legal_Display_Model $object L'objet.
	 * @param  array               $args   Les paramètres de la requête.
	 *
	 * @return Legal_Display_Model         L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_legal_display( $object, $args ) {
		$args_detective_work                      = array( 'schema' => true );
		$args_detective_work_address              = array( 'schema' => true );
		$args_occupational_health_service         = array( 'schema' => true );
		$args_occupational_health_service_address = array( 'schema' => true );

		if ( ! empty( $object->data['id'] ) ) {
			$args_detective_work              = array( 'id' => $object->data['detective_work_id'] );
			$args_occupational_health_service = array( 'id' => $object->data['occupational_health_service_id'] );
		}

		$object->data['detective_work'] = Third_Class::g()->get( $args_detective_work, true );

		if ( ! empty( $object->data['detective_work']->data['contact']['address_id'] ) ) {
			$args_detective_work_address = array( 'id' => $object->data['detective_work']->data['contact']['address_id'] );
		}

		$object->data['detective_work']->data['address'] = Address_Class::g()->get( $args_detective_work_address, true );

		$object->data['occupational_health_service'] = Third_Class::g()->get( $args_occupational_health_service, true );

		if ( ! empty( $object->data['occupational_health_service']->data['contact']['address_id'] ) ) {
			$args_occupational_health_service_address = array( 'id' => $object->data['occupational_health_service']->data['contact']['address_id'] );
		}

		$object->data['occupational_health_service']->data['address'] = Address_Class::g()->get( $args_occupational_health_service_address, true );

		return $object;
	}

}

new Legal_Display_Filter();
