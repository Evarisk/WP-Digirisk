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
 * Intervention des plans de prévention
 */
class Prevention_Intervention_Action {
	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_add_intervention_line', array( $this, 'callback_add_intervention_line' ) );

		add_action( 'wp_ajax_edit_intervention_line', array( $this, 'callback_edit_intervention_line' ) );

		add_action( 'wp_ajax_delete_intervention_line', array( $this, 'callback_delete_intervention_line' ) );

	}

	public function callback_add_intervention_line(){
		check_ajax_referer( 'add_intervention_line' );

		$unite_id   = isset( $_POST[ 'unite' ] ) ? (int) $_POST[ 'unite' ] : 0;
		$prevention = isset( $_POST[ 'prevention' ] ) ? sanitize_text_field( $_POST[ 'prevention' ] ) : 0;
		$action     = isset( $_POST[ 'descriptionaction' ] ) ? sanitize_text_field( $_POST[ 'descriptionaction' ] ) : 0;
		$risk_id    = isset( $_POST[ 'riskid' ] ) ? (int) $_POST[ 'riskid' ] : 0;
		$parent     = isset( $_POST[ 'parentid' ] ) ? (int) $_POST[ 'parentid' ] : 0;

		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $unite_id || ! $prevention || ! $action || ! $risk_id || ! $parent ){
			wp_send_json_error( 'Erreur dans la requete' );
		}

		$key = array( // Clé unique pour chaque intervention du plan de prévention
			'site_mu' => get_current_blog_id(), // ID du site
			'post_parent' => $parent,// ID du plan de prévention
			'id_inter' => $id // ID de l'intervention actuelle
		);

		$intervention = array(
			'post_parent'            => $parent, // plan de prévention
			'id'                     => $id,
			'key_unique'             => 'undefined',
			'unite_travail'          => $unite_id,
			'action_realise'         => $action,
			'risk'                   => $risk_id,
			'moyen_prevention'       => $prevention
		);

		$intervention = Prevention_Intervention_Class::g()->update( $intervention );

		$key[ 'id_inter' ] = $intervention->data[ 'id' ];
		$intervention->data[ 'key_unique' ] = $key[ 'site_mu' ] . '-' . $key[ 'post_parent' ] . '-' . $key[ 'id_inter' ];

		$intervention = Prevention_Intervention_Class::g()->update( $intervention->data );
		Prevention_Page_Class::g()->register_search( null, null );
		ob_start();
		$view_prevention = Prevention_Intervention_Class::g()->display_table( $parent );
		$table_view = ob_get_clean();


		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'addInterventionLineSuccess',
			'table_view'       => $table_view
		) );
	}

	public function callback_edit_intervention_line(){
		check_ajax_referer( 'edit_intervention_line' );
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error ID not valid' );
		}

		$intervention = Prevention_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$prevention   = Prevention_Class::g()->get( array( 'id' => $intervention->data[ 'parent_id' ] ), true );
		
		Prevention_Page_Class::g()->register_search( null, $prevention, array( 'intervention' => $intervention ) );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-table-intervention-edit', array(
			'intervention' => $intervention,
			'prevention'   => $prevention
		 ) );
		$view = ob_get_clean();

		$workunit_name = Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'editInterventionLineSuccess',
			'view'             => $view,
			'workunitName'    => $workunit_name
		) );
	}

	public function callback_delete_intervention_line(){
		check_ajax_referer( 'delete_intervention_line' );

		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error ID not valid' );
		}

		$intervention = Prevention_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$intervention->data[ 'status' ] = "trash";
		$parent = $intervention->data[ 'parent_id' ];
		Prevention_Intervention_Class::g()->update( $intervention->data );

		Prevention_Page_Class::g()->register_search( null, null );
		ob_start();
		Prevention_Intervention_Class::g()->display_table( $parent );
		$table_view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'addInterventionLineSuccess',
			'table_view'       => $table_view
		) );
	}


}

new Prevention_Intervention_Action();
