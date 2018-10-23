<?php
/**
 * Gestion des filtres WordPress des signalisations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.1
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation filter class.
 */
class Recommendation_Filter extends Identifier_Filter {

	/**
	 * Constructeur.
	 *
	 * @since   6.2.10
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 4, 2 );

		$current_type = Recommendation::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_recommendation' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet "Recommendations" dans les unités de travail.
	 *
	 * @param  array   $list_tab  La liste des onglets.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des onglets et ceux ajoutés par cette méthode.
	 *
	 * @since   6.2.10
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
	 * @since   6.2.1
	 * @version 7.0.0
	 *
	 * @param  Recommendation_Model $object L'objet.
	 * @param  array                $args   Les données de la requête.
	 *
	 * @return Recommendation_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_recommendation( $object, $args ) {
		$args_recommendation_term    = array( 'schema' => true );
		$args_recommendation_comment = array( 'schema' => true );

		if ( ! empty( $object->data['taxonomy']['digi-recommendation-category'] ) ) {
			$args_recommendation_term = array( 'id' => end( $object->data['taxonomy']['digi-recommendation-category'] ) );
		}

		if ( ! empty( $object->data['id'] ) ) {
			$args_recommendation_comment = array( 'post_id' => $object->data['id'] );
		}

		$object->data['recommendation_category'] = Recommendation_Category::g()->get( $args_recommendation_term, true );

		// Récupères les commentaires.
		$object->data['comment'] = Recommendation_Comment_Class::g()->get( $args_recommendation_comment );

		return $object;
	}
}

new Recommendation_Filter();
