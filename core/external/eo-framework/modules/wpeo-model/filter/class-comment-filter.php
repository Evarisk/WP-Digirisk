<?php
/**
 * Gestion des filtres globaux concernant les Commentaires dans EO_Framework.
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
class Comment_Filter {

	/**
	 * Initialisation et appel des différents filtres définis dans EO_Framework.
	 */
	public function __construct() {
		add_filter( 'comments_clauses', array( $this, 'exclude_custom_comments_in_dashboard' ), 10, 2 );

		add_filter( 'eo_model_comment_after_put', array( $this, 'after_save_comment' ), 5, 2 );
		add_filter( 'eo_model_comment_after_post', array( $this, 'after_save_comment' ), 5, 2 );
	}

	/**
	 * Exclus les custom comments de la métabox "Activité" du tableau de bord de WordPress.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array            $clauses Les paramètres de la requête pour récupérer les Commentaires.
	 * @param  WP_Comment_Query $query   La query.
	 *
	 * @return array                     Les paramètres de la requête avec le comment_type en plus.
	 */
	function exclude_custom_comments_in_dashboard( $clauses, $query ) {
		global $pagenow;
		if ( ( 'index.php' == $pagenow && is_admin() ) || is_home() ) {
			$clauses['where'] .= ' AND comment_type IN("' . implode( \eoxia\Config_Util::$init['eo-framework']->not__in_display_comment, '","' ) . '")';
		}

		return $clauses;
	}

	/**
	 * Execute des actions complémentaire après avoir mis à jour un objet de type "Comment"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param Comment_Model $object L'objet qu'il faut "modifier".
	 * @param array         $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return Comment_Model L'objet de type Comment "modifié" par le helper.
	 */
	function after_save_comment( $object, $args ) {
		// Mise à jour des metas.
		Save_Meta_Class::g()->save_meta_data( $object, 'update_comment_meta', $args['meta_key'] );

		return $object;
	}

}

new Comment_Filter();
