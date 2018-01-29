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
class Risk_Category_Tools_Action {

	/**
	 * Le constructeur fait appel aux actions définies par WordPress.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	function __construct() {
		add_action( 'wp_ajax_digi-fix-categories', array( $this, 'callback_digi_fix_categories' ) );
	}

	/**
	 * Association des nouvelles catégories de danger aux risques n'en possédant pas mais possédant une ancienne catégories de risques.
	 *
	 * @return void
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function callback_digi_fix_categories() {
		check_ajax_referer( 'digi-fix-danger-categories' );
		global $wpdb;

		$digi_danger_category = ! empty( $_POST ) && ! empty( $_POST['old_term_id'] ) && is_int( (int) $_POST['old_term_id'] ) ? (int) $_POST['old_term_id'] : 0;
		$digi_category_risk = ! empty( $_POST ) && ! empty( $_POST['new_term_id'] ) && is_int( (int) $_POST['new_term_id'] ) ? (int) $_POST['new_term_id'] : 0;
		$total_risk_to_do = 0;
		$total_risk_done = 0;

		// Récupération des identifiants des risques affectés à une catégories de risques (ancienne méthode) et non affectés à une catégories de risques (nouvelles méthodes).
		$list_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT GROUP_CONCAT( R.ID ) AS LIST
			FROM {$wpdb->posts} AS R
				INNER JOIN {$wpdb->term_relationships} AS TR1 ON ( TR1.object_id = R.ID )
			WHERE R.post_type LIKE 'digi-risk'
				AND TR1.term_taxonomy_id = %d
				AND R.ID NOT IN (
					SELECT object_id
					FROM {$wpdb->term_relationships} AS TR
						JOIN {$wpdb->term_taxonomy} AS TT ON ( TT.term_taxonomy_id = TR.term_taxonomy_id )
					WHERE TT.taxonomy = %s
				)
			GROUP BY TR1.term_taxonomy_id",
		$digi_danger_category, 'digi-category-risk' ) );

		// Dans le cas où il n'y a pas de risques associés à la catégorie de risques actuellement en traitement.
		if ( null === $list_id ) {
			\eoxia\LOG_Util::log( sprintf( __( 'Il n\'y a aucun risque associé à la catégorie %1$d', 'digirisk' ), $digi_danger_category ), 'digirisk-tools' );

			wp_send_json_success( array(
				'message' => __( 'Aucun risque a traiter', 'digirisk' ),
			) );
		} else {
			\eoxia\LOG_Util::log( sprintf( 'Liste des risques appartenant à la catégorie %1$d: %2$s', $digi_danger_category, $list_id ), 'digirisk-tools' );
			$list = explode( ',', $list_id );
			$total_risk_to_do = count( $list );
			foreach ( $list as $id ) {
				$association = $wpdb->insert( $wpdb->term_relationships, array( 'object_id' => $id, 'term_taxonomy_id' => $digi_category_risk ), array( '%d', '%d' ) );
				if ( false === $association ) {
					\eoxia\LOG_Util::log( sprintf( __( 'Le risque %1$d n\'a pas pu être associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				} else {
					$total_risk_done++;
					\eoxia\LOG_Util::log( sprintf( __( 'Le risque %1$d a bien été associé à la catégorie: %2$s', 'digirisk' ), $id, $digi_category_risk ), 'digirisk-tools' );
				}
			}

			wp_send_json_success( array(
				'message' => sprintf( __( '%1$d/%2$d risque(s) traité(s).', 'digirisk' ), $total_risk_done, $total_risk_to_do ),
			) );
		}
	}

}

new Risk_Category_Tools_Action();
