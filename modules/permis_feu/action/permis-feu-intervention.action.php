<?php
/**
 * Gestion des actions des interventions de plan de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Intervention des permis de feu
 */
class Permis_Feu_Intervention_Action {
	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_add_intervention_line_permisfeu', array( $this, 'callback_add_intervention_line_permisfeu' ) );

		add_action( 'wp_ajax_edit_intervention_line_permisfeu', array( $this, 'callback_edit_intervention_line_permisfeu' ) );


	}

	public function callback_add_intervention_line_permisfeu(){
		check_ajax_referer( 'add_intervention_line_permisfeu' );

		$unite_id      = isset( $_POST[ 'unitedetravail' ] ) ? (int) $_POST[ 'unitedetravail' ] : 0;
		$worktype_id   = isset( $_POST[ 'worktype_category_id' ] ) ? (int) $_POST[ 'worktype_category_id' ] : 0;
		$action = isset( $_POST[ 'description-des-actions' ] ) ? sanitize_text_field( $_POST[ 'description-des-actions' ] ) : 0;
		$moyen_prevention = isset( $_POST[ 'moyen-de-prevention' ] ) ? sanitize_text_field( $_POST[ 'moyen-de-prevention' ] ) : 0;

		$permis_feu_id = isset( $_POST[ 'parentid' ] ) ? (int) $_POST[ 'parentid' ] : 0;
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $unite_id || ! $worktype_id || ! $action || ! $moyen_prevention || ! $permis_feu_id ){
			wp_send_json_error( 'Erreur dans la requete' );
		}

		$key = array( // Clé unique pour chaque intervention du plan de prévention
			'site_mu' => get_current_blog_id(), // ID du site
			'post_parent' => $permis_feu_id,// ID du plan de prévention
			'id_inter' => $id // ID de l'intervention actuelle
		);

		$intervention = array(
			'post_parent'            => (int) $permis_feu_id, // plan de prévention
			'id'                     => $id,
			'key_unique'             => 'undefined',
			'unite_travail'          => $unite_id,
			'action_realise'         => $action,
			'worktype'               => $worktype_id,
			'moyen_prevention'       => $moyen_prevention
		);

		$intervention = Permis_Feu_Intervention_Class::g()->update( $intervention );


		$key[ 'id_inter' ] = $intervention->data[ 'id' ];
		$intervention->data[ 'key_unique' ] = $key[ 'site_mu' ] . '-' . $key[ 'post_parent' ] . '-' . $key[ 'id_inter' ];

		$intervention = Permis_Feu_Intervention_Class::g()->update( $intervention->data );
		Permis_Feu_Page_Class::g()->register_search( null, null );
		ob_start();
		$view_prevention = Permis_Feu_Intervention_Class::g()->display_intervention_table( $permis_feu_id );
		$table_view = ob_get_clean();


		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'addInterventionLinePermisFeuSuccess',
			'table_view'       => $table_view
		) );
	}

	public function callback_edit_intervention_line_permisfeu(){
		check_ajax_referer( 'edit_intervention_line_permisfeu' );
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error ID not valid' );
		}

		$intervention = Permis_Feu_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $intervention->data[ 'parent_id' ] ), true );

		Permis_Feu_Page_Class::g()->register_search( null, null );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-edit', array(
			'intervention' => $intervention,
			'permis_feu' => $permis_feu
		 ) );
		$view = ob_get_clean();

		$workunit_name = Permis_Feu_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'editInterventionLineSuccess',
			'view'             => $view,
			'workunitName'     => $workunit_name
		) );
	}
}

new Permis_Feu_Intervention_Action();
