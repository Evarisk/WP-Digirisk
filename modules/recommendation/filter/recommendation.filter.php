<?php
/**
 * Les filtres relatifs aux recommandations
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
 * Les filtres relatifs aux recommandations
 */
class Recommendation_Filter extends Identifier_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 6.2.10
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 4, 2 );

		$current_type = Recommendation_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_recommendation' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet "Recommendations" dans les unités de travail.
	 *
	 * @param  array   $list_tab  La liste des onglets.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des onglets et ceux ajoutés par cette méthode.
	 *
	 * @since 6.2.10
	 * @version 6.4.4
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['recommendation'] = array(
			'type'  => 'text',
			'text'  => __( 'Signalisations', 'digirisk' ),
			'title' => __( 'Les signalisations', 'digirisk' ),
		);

		$list_tab['digi-group']['recommendation'] = array(
			'type'  => 'text',
			'text'  => __( 'Signalisations', 'digirisk' ),
			'title' => __( 'Les signalisations', 'digirisk' ),
		);

		return $list_tab;
	}


	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'une préconisation
	 *
	 * @since 6.2.1
	 * @version 7.0.0
	 *
	 * @param  Recommendation_Model $object L'objet.
	 * @param  array                $args   Les données de la requête.
	 *
	 * @return Recommendation_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_recommendation( $object, $args ) {
		$args_recommendation_category_term = array( 'schema' => true );
		$args_recommendation_term          = array( 'schema' => true );
		$args_recommendation_comment       = array( 'schema' => true );

		if ( ! empty( $object->data['taxonomy']['digi-recommendation-category'] ) ) {
			$args_recommendation_category_term = array( 'id' => end( $object->data['taxonomy']['digi-recommendation-category'] ) );
		}

		if ( ! empty( $object->data['taxonomy']['digi-recommendation'] ) ) {
			$args_recommendation_term = array( 'id' => end( $object->data['taxonomy']['digi-recommendation'] ) );
		}

		if ( ! empty( $object->data['id'] ) ) {
			$args_recommendation_comment = array( 'post_id' => $object->data['id'] );
		}

		$object->data['recommendation_category_term']                              = Recommendation_Category_Term_Class::g()->get( $args_recommendation_category_term, true );
		// $object->data['recommendation_category_term']->data['recommendation_term'] = Recommendation_Term_Class::g()->get( $args_recommendation_term, true );

		// Récupères les commentaires.
		$object->data['comment'] = Recommendation_Comment_Class::g()->get( $args_recommendation_comment );

		return $object;
	}
}

new Recommendation_Filter();
