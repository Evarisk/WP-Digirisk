<?php
/**
 * Gestion des filtres relatifs aux causerie de sécurité.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux causerie de sécurité.
 */
class Causerie_Filter extends Identifier_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 6.5.0
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::_construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );

		$current_type = Causerie_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", '\digi\get_full_causerie', 10, 2 );
	}

	/**
	 * Ajoutes l'onglet accident dans les groupements et les unités de travail
	 *
	 * @since 6.5.0
	 * @version 7.0.0
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['causerie'] = array(
			'type'  => 'text',
			'text'  => __( 'Causerie sécurité', 'digirisk' ),
			'title' => __( 'Les causeries sécurité', 'digirisk' ),
		);

		return $list_tab;
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'une causerie
	 * Categories de risque
	 *
	 * @since 6.5.0
	 * @version 7.0.0
	 *
	 * @param  Causerie_Model $object L'objet.
	 * @param  array          $args   Données de la requête.
	 *
	 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_causerie( $object, $args ) {
		$args_category_risk = array(
			'schema' => true,
		);

		if ( ! empty( $object->data['id'] ) ) {
			$args_category_risk = array(
				'include' => $object->data['taxonomy']['digi-category-risk'],
			);
		}

		// Récupères la catégorie du danger.
		$danger_categories             = Risk_Category_Class::g()->get( $args_category_risk );
		$object->data['risk_category'] = $danger_categories[0];

		if ( ! isset( $object->data['modified_unique_identifier'] ) ) {
			$object->data['modified_unique_identifier'] = '';
		}

		return $object;
	}
}

new Causerie_Filter();
