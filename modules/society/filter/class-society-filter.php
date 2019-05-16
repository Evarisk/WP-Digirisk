<?php
/**
 * Les filtres pour les sociétés
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.2
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres pour les sociétés
 */
class Society_Filter extends Identifier_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 2, 2 );

		$current_type = Society_Class::g()->get_type();
		add_filter( 'eo_model_{$current_type}_after_get', array( $this, 'get_full_society' ), 10, 2 );
		add_filter( 'eo_model_digi-group_after_get', array( $this, 'get_full_society' ), 10, 2 );
		add_filter( 'eo_model_digi-workunit_after_get', array( $this, 'get_full_society' ), 10, 2 );

		add_filter( 'eo_search_results_accident_post', array( $this, 'callback_search_results' ) );
	}

	/**
	 * Ajoutes l'onglet "Informations" à la société.
	 *
	 * @since 6.3.0
	 * @version 7.0.0
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 * @return array
	 */
	public function callback_tab( $tab_list, $id ) {
		$tab_list['digi-society']['configuration'] = array(
			'type'  => 'text',
			'text'  => __( 'Configuration', 'digirisk' ),
			'title' => __( 'Configuration', 'digirisk' ),
		);

		return $tab_list;
	}

	/**
	 * Récupères le responsable
	 *
	 * @since 6.4.0
	 * @version 7.0.0
	 *
	 * @param  Society_Model $object L'objet.
	 * @param  array         $args   Les paramètres de la requête.
	 *
	 * @return Society_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_society( $object, $args ) {

		if ( ! empty( $object->data['owner_id'] ) ) {
			$object->data['owner'] = User_Class::g()->get( array( 'id' => $object->data['owner_id'] ), true );
		} else {
			$object->data['owner'] = User_Class::g()->get( array( 'schema' => true ), true );
		}

		return $object;
	}

	/**
	 * Ajoutes l'identifiant devant le nom des sociétés.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $results La liste des sociétés.
	 * @return array          La liste des sociétés avec l'identifiant ajouté.
	 */
	public function callback_search_results( $results ) {
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				$result->data['title'] = $result->data['unique_identifier'] . ' - ' . $result->data['title'];
			}
		}
		return $results;
	}
}

new Society_Filter();
