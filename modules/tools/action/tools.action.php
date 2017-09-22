<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Tools_Action {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_reset_method_evaluation', array( $this, 'callback_reset_method_evaluation' ) );
		add_action( 'wp_ajax_compil_risk_list', array( $this, 'callback_risk_compilation' ) );
		add_action( 'wp_ajax_transfert_doc', array( $this, 'callback_transfert_doc' ) );
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
}

new Tools_Action();
