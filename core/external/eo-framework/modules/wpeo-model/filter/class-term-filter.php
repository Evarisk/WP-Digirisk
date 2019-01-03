<?php
/**
 * Gestion des filtres globaux concernant les dates dans EO_Framework.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Model\Filter
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres globaux concernant les dates dans EO_Framework.
 */
class Term_Filter {

	/**
	 * Initialisation et appel des différents filtres définis dans EO_Framework.
	 */
	public function __construct() {
		add_filter( 'eo_model_term_after_get', array( $this, 'after_get_term' ), 5, 2 );

		add_filter( 'eo_model_term_after_put', array( $this, 'after_save_term' ), 5, 2 );
		add_filter( 'eo_model_term_after_post', array( $this, 'after_save_term' ), 5, 2 );
	}

	/**
	 * Execute des actions complémentaire après avoir mis à jour un objet de type "Term"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param Term_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return Term_Model L'objet de type Term "modifié" par le helper.
	 */
	function after_save_term( $object, $args ) {
		// Mise à jour des metas.
		Save_Meta_Class::g()->save_meta_data( $object, 'update_term_meta', $args['meta_key'] );

		return $object;
	}

	/**
	 * Execute des actions complémentaire après avoir mis à jour un objet de type "Term"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param Term_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return Term_Model L'objet de type Term "modifié" par le helper.
	 */
	function after_get_term( $object, $args ) {
		if ( ! empty( $args['args']['post_id'] ) ) {
			$object['post_id'] = $args['args']['post_id'];
		}

		return $object;
	}

}

new Term_Filter();
