<?php
/**
 * Les filtres relatifs aux catégorie de recommandations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.10
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatifs aux catégorie de recommandations
 */
class Recommendation_Category_Term_Filter extends Identifier_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 6.2.10
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		$current_type = Recommendation_Category_Term_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_recommendation_category' ), 10, 2 );
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'une préconisation
	 *
	 * @since ?
	 * @version 7.0.0
	 *
	 * @param  Recommendation_Model $object L'objet.
	 * @param  array                $args   Les données de la requête.
	 *
	 * @return Recommendation_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_recommendation_category( $object, $args ) {
		$args_recommendation_term = array( 'parent' => $object->data['id'] );

		$object->data['recommendation_term'] = Recommendation_Term_Class::g()->get( $args_recommendation_term );

		return $object;
	}
}

new Recommendation_Category_Term_Filter();
