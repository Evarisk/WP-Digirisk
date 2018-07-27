<?php
/**
 * Les actions relatives aux outils pour les categories de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.5
 * @version 6.4.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Les actions relatives aux outils pour les categories de risque.
 */
class Risk_Category_Tools_Class extends \eoxia001\Singleton_Util {

	/**
	 * Le constructeur fait appel aux actions définies par WordPress.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	protected function construct() { }

	/**
	 * Correction des différences de catégories de danger et catégories de risques.
	 * Gestion du cas n°2 - Le risque possède une categorie de danger MAIS ne possède pas de catégorie de risque : on ajoute la catégorie de risque INRS correspondante à la catégorie de danger.
	 *
	 * @param integer $digi_danger_category L'identifiant de la catégorie de danger (ancienne catégorie).
	 * @param integer $digi_category_risk   L'identifiant de la catégorie de risque (nouvelle catégorie INRS).
	 *
	 * @return string Le texte correspondant à la requête venant d'être effectuée
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function associate_missing_category( $digi_danger_category, $digi_category_risk ) {
		global $wpdb;

		$response = array(
			'total' => 0,
			'done'  => 0,
		);

		// Récupération des identifiants des risques affectés à une catégories de risques (ancienne méthode) et non affectés à une catégories de risques (nouvelles méthodes).
		$list_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT GROUP_CONCAT( R.ID ) AS LIST
			FROM {$wpdb->posts} AS R
				INNER JOIN {$wpdb->term_relationships} AS TR1 ON ( TR1.object_id = R.ID )
			WHERE R.post_type LIKE %s
				AND TR1.term_taxonomy_id = %d
				AND R.ID NOT IN (
					SELECT object_id
					FROM {$wpdb->term_relationships} AS TR
						JOIN {$wpdb->term_taxonomy} AS TT ON ( TT.term_taxonomy_id = TR.term_taxonomy_id )
					WHERE TT.taxonomy = %s
				)
			GROUP BY TR1.term_taxonomy_id",
		'digi-risk', $digi_danger_category, 'digi-category-risk' ) );

		// Dans le cas où il n'y a pas de risques associés à la catégorie de risques actuellement en traitement.
		if ( null === $list_id ) {
			\eoxia001\LOG_Util::log( sprintf( __( 'Il n\'y a aucun risque associé à la catégorie %1$d', 'digirisk' ), $digi_danger_category ), 'digirisk-tools' );
		} else {
			\eoxia001\LOG_Util::log( sprintf( 'Liste des risques appartenant à la catégorie %1$d: %2$s', $digi_danger_category, $list_id ), 'digirisk-tools' );
			$list = explode( ',', $list_id );
			$total_risk_to_do = count( $list );
			foreach ( $list as $id ) {
				$association = $wpdb->insert( $wpdb->term_relationships, array( 'object_id' => $id, 'term_taxonomy_id' => $digi_category_risk ), array( '%d', '%d' ) );
				if ( false === $association ) {
					\eoxia001\LOG_Util::log( sprintf( __( 'Le risque %1$d n\'a pas pu être associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				} else {
					$total_risk_done++;
					\eoxia001\LOG_Util::log( sprintf( __( 'Le risque %1$d a bien été associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				}
			}

			$response = array(
				'total' => $total_risk_done,
				'done'  => $total_risk_to_do,
			);
		}

		return $response;
	}

	/**
	 * Correction des différences de catégories de danger et catégories de risques.
	 * Gestion du cas n°3 - Le risque possède une categorie de danger ET une catégorie de risque MAIS la correspondance de l'INRS est incorrecte:  on supprime la catégorie de risque associée et on associe celle définie par l'INRS.
	 *
	 * @param integer $digi_danger_category L'identifiant de la catégorie de danger (ancienne catégorie).
	 * @param integer $digi_category_risk   L'identifiant de la catégorie de risque (nouvelle catégorie INRS).
	 *
	 * @return string Le texte correspondant à la requête venant d'être effectuée
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function fix_categories_matching( $digi_danger_category, $digi_category_risk ) {
		global $wpdb;

		$response = array(
			'total' => 0,
			'done'  => 0,
		);

		// Récupération des identifiants des risques affectés à une catégories de risques (ancienne méthode) et non affectés à une catégories de risques (nouvelles méthodes).
		$list_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT GROUP_CONCAT( R.ID ) AS LIST
			FROM {$wpdb->posts} AS R
				INNER JOIN {$wpdb->term_relationships} AS TR1 ON ( TR1.object_id = R.ID )
			WHERE R.post_type LIKE %s
				AND TR1.term_taxonomy_id = %d
				AND R.ID NOT IN (
					SELECT object_id
					FROM {$wpdb->term_relationships} AS TR
						JOIN {$wpdb->term_taxonomy} AS TT ON ( TT.term_taxonomy_id = TR.term_taxonomy_id )
					WHERE TT.taxonomy = %s
						AND TT.term_id = %d
				)
			GROUP BY TR1.term_taxonomy_id",
		'digi-risk', $digi_danger_category, 'digi-category-risk', $digi_category_risk ) );

		// Dans le cas où il n'y a pas de risques associés à la catégorie de risques actuellement en traitement.
		if ( null === $list_id ) {
			\eoxia001\LOG_Util::log( sprintf( __( 'Il n\'y a aucun risque associé à la catégorie %1$d', 'digirisk' ), $digi_danger_category ), 'digirisk-tools' );
		} else {
			\eoxia001\LOG_Util::log( sprintf( 'Liste des risques appartenant à la catégorie %1$d: %2$s', $digi_danger_category, $list_id ), 'digirisk-tools' );
			$list = explode( ',', $list_id );
			$total_risk_to_do = count( $list );
			foreach ( $list as $id ) {
				$associated = wp_get_object_terms( $id, 'digi-category-risk', array( 'fields' => 'ids' ) );
				$wpdb->delete( $wpdb->term_relationships, array( 'object_id' => $id, 'term_taxonomy_id' => $associated[0] ), array( '%d', '%d' ) );
				\eoxia001\LOG_Util::log( sprintf( __( 'La catégorie %2$s a été supprimée du risque %1$d', 'digirisk' ), $id, wp_json_encode( $associated ) ), 'digirisk-tools' );

				$association = $wpdb->insert( $wpdb->term_relationships, array( 'object_id' => $id, 'term_taxonomy_id' => $digi_category_risk ), array( '%d', '%d' ) );
				if ( false === $association ) {
					\eoxia001\LOG_Util::log( sprintf( __( 'Le risque %1$d n\'a pas pu être associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				} else {
					$total_risk_done++;
					\eoxia001\LOG_Util::log( sprintf( __( 'Le risque %1$d a bien été associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				}
			}

			$response = array(
				'total' => $total_risk_done,
				'done'  => $total_risk_to_do,
			);
		}

		return $response;
	}

}

new Risk_Category_Tools_Class();
