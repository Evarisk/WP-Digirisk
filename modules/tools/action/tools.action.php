<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Tools_Action {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_reset_method_evaluation', array( $this, 'callback_reset_method_evaluation' ) );
		add_action( 'wp_ajax_compil_risk_list', array( $this, 'callback_risk_compilation' ) );
		add_action( 'wp_ajax_transfert_doc', array( $this, 'callback_transfert_doc' ) );
		add_action( 'wp_ajax_digi-fix-categories', array( $this, 'callback_digi_fix_categories' ) );
	}

	public function admin_menu() {
    add_management_page( 'DigiRisk', 'DigiRisk', 'manage_digirisk', 'digirisk-tools', array( $this, 'add_management_page' ) );
  }

  public function add_management_page() {
		\eoxia\View_Util::exec( 'digirisk', 'tools', 'main' );
  }

  public function callback_reset_method_evaluation() {
    check_ajax_referer( 'reset_method_evaluation' );

    tools_class::g()->reset_method_evaluation();

    wp_send_json_success();
  }

	/**
	 * Callback function for fixing risk list in element when some errors are detected / Fonction de rappel pour la correction de la liste des risques dans les éléments
	 */
	public function callback_risk_compilation() {
		check_ajax_referer( 'risk_list_compil' );

		/**	First let's list all group / Commençons par lister les groupements	*/
		$group_list = group_class::g()->get( array() );
		foreach ( $group_list as $group ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $group->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$group->associated_risk[] = $risk->id;
				}

				group_class::g()->update( $group );
			}
		}

		/**	Let's list all workunit / Listons les unités de travail */
		$workunit_list = workunit_class::g()->get( array() );
		foreach ( $workunit_list as $workunit ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $workunit->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$workunit->associated_risk[] = $risk->id;
				}

				workunit_class::g()->update( $workunit );
			}
		}

		wp_send_json_success();
	}

	/**
	 * Passes les documents de type "DUER" en post type "duer" et met à jour l'unique identifiant.
	 * Passes les documents de type "Fiche_De_Groupement" en post type "fiche_de_groupement" et met à jour l'unique identifiant.
	 * Passes les documents de type "Fiche_De_poste" en post type "fiche_de_psote" et met à jour l'unique identifiant.
	 * Passes les documents de type "Affichage_Legal" en post type "affichage_legal" et met à jour l'unique identifiant.
	 *
	 * @return void
	 *
	 * @since 6.1.x.x
	 * @version 6.2.10.0
	 */
	public function callback_transfert_doc() {
		check_ajax_referer( 'callback_transfert_doc' );

		Tools_Class::g()->transfert_doc();

		wp_send_json_success();
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

new Tools_Action();
