<?php
/**
 * Gestion des actions des plan de prévention pour la lecture.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Permis_Feu Action Class.
 */
class Permis_Feu_Action {
	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_permis_feu_display_maitre_oeuvre', array( $this, 'callback_permis_feu_display_maitre_oeuvre' ) );

		add_action( 'wp_ajax_permis_feu_save_signature_maitre_oeuvre', array( $this, 'callback_permis_feu_save_signature_maitre_oeuvre' ) );

		add_action( 'wp_ajax_add_prevention_to_permis_feu', array( $this, 'callback_add_prevention_to_permis_feu' ) );
		add_action( 'wp_ajax_delete_prevention_from_permis_feu', array( $this, 'callback_delete_prevention_from_permis_feu' ) );

		add_action( 'wp_ajax_display_button_odt_pointchaud', array( $this, 'callback_display_button_odt_pointchaud' ) );

		add_action( 'wp_ajax_permisfeu_load_tab', array( $this, 'callback_permisfeu_load_tab' ) );

		add_action( 'wp_ajax_add_intervenant_to_permis_feu', array( $this, 'callback_add_intervenant_to_permis_feu' ) );
		add_action( 'wp_ajax_edit_intervenant_permis_feu', array( $this, 'callback_edit_intervenant_permis_feu' ) );

		add_action( 'wp_ajax_edit_this_permis_feu', array( $this, 'callback_edit_this_permis_feu' ) );

		add_action( 'wp_ajax_generate_document_permis_feu', array( $this, 'callback_generate_document_permis_feu' ) );

		add_action( 'wp_ajax_delete_document_permis_feu', array( $this, 'callback_delete_document_permis_feu' ) );

		// $this->a();
	}

	public function a(){
		$a = \eoxia\Config_Util::$init['digirisk'];
		echo '<pre>'; print_r( $b ); echo '</pre>'; exit;
		$prevention = Permis_Feu_Class::g()->get( array( 'id' => 174 ), true );
		// $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] = 0;
		$prevention->data[ 'maitre_oeuvre' ][ 'signature_id' ] = 0;
		// $prevention->data[ 'intervenant_exterieur' ][ 'signature_id' ] = 0;
		$prevention->data[ 'taxonomy' ] = array();
		$prevention = Permis_Feu_Class::g()->update( $prevention->data );
	}

	public function callback_permis_feu_display_maitre_oeuvre(){

		$permis_feu_id = isset( $_POST[ 'permis_feu_id' ] ) ? (int) $_POST[ 'permis_feu_id' ] : 0;
		$user_id = isset( $_POST[ 'user_id' ] ) ? (int) $_POST[ 'user_id' ] : 0;

		if( ! $user_id || ! $permis_feu_id ){
			wp_send_json_error( 'Error in request' );
		}

		$user_info = get_user_by( 'id', $user_id );
		$permis_feu = Permis_Feu_Class::g()->update_maitre_oeuvre( $permis_feu_id, $user_info );

		Permis_Feu_Page_Class::g()->register_search( null, null );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', '/start/step-4-maitre-oeuvre-name', array(
			'permis_feu' => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu )
		) );
		$view_name = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', '/start/step-4-maitre-oeuvre-phone', array(
			'permis_feu' => $permis_feu
		) );
		$view_phone = ob_get_clean();

		wp_send_json_success( array(
			'view_name'  => $view_name,
			'view_phone' => $view_phone
		) );
	}

	public function callback_permis_feu_save_signature_maitre_oeuvre(){
		check_ajax_referer( 'permis_feu_save_signature_maitre_oeuvre' );

		$permis_feu_id    = ! empty( $_POST['permis_feu_id'] ) ? (int) $_POST['permis_feu_id'] : 0; // WPCS: input var ok.
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : ''; // WPCS: input var ok.
		$user_type = ! empty( $_POST['user-type'] ) ? $_POST['user-type'] : ''; // WPCS: input var ok.

		if ( ! $permis_feu_id || ! $signature_data ) {
			wp_send_json_error( 'Error in request' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $permis_feu_id ), true );
		$permis_feu = Permis_Feu_Class::g()->add_signature_maitre_oeuvre( $permis_feu, $signature_data , $user_type );

		$permis_feu = Permis_Feu_Class::g()->update( $permis_feu->data );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-1-signature', array(
			'permis_feu' => $permis_feu,
			'user_type'  => $user_type,
			'user_type_attr' => $user_type == 'maitre_oeuvre' ? 'maitre-oeuvre-signature' : 'intervenant-exterieur-signature',

		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'displaySignatureLastPage',
			'view'             => $view,
			'class_parent'     => $user_type == 'maitre_oeuvre' ? 'information-maitre-oeuvre' : 'information-intervenant-exterieur',
		) );
	}

	public function callback_add_prevention_to_permis_feu(){
		check_ajax_referer( 'add_prevention_to_permis_feu' );
		$prevention_id = isset( $_POST[ 'prevention_id' ] ) ? (int) $_POST[ 'prevention_id' ] : 0;
		$permis_feu_id = isset( $_POST[ 'permis_feu_id' ] ) ? (int) $_POST[ 'permis_feu_id' ] : 0;

		if( ! $prevention_id || ! $permis_feu_id ){
			wp_send_json_error( 'Erreur dans l\'id' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $prevention_id ), true );
		if( $prevention->data[ 'id' ] == 0 ){
			wp_send_json_error( 'Prevention_id non-valide' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $permis_feu_id ), true );
		$permis_feu->data[ 'prevention_id' ] = $prevention_id;
		Permis_Feu_Class::g()->update( $permis_feu->data );

		$permis_feu = Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu );

		ob_start();
		Permis_Feu_Class::g()->display_prevention( $permis_feu );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'addPreventionToPermisFeuSuccess',
			'view'             => $view,
		) );
	}

	public function callback_delete_prevention_from_permis_feu(){
		check_ajax_referer( 'delete_prevention_from_permis_feu' );
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;
		if( ! $id ){
			wp_send_json_error( 'Id invalide' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		$permis_feu->data[ 'prevention_id' ] = 0;
		Permis_Feu_Class::g()->update( $permis_feu->data );

		Permis_Feu_Page_Class::g()->register_search( null, null );
		ob_start();
		Permis_Feu_Class::g()->display_prevention( $permis_feu );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'deletePreventionFromPermisFeuSuccess',
			'view'             => $view,
		) );
	}

	public function callback_display_button_odt_pointchaud(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Erreur ID' );
		}

		$element_id = $id;
		$target     = "digi-fiche-de-poste";
		$title      = esc_html__( 'Les fiches de poste', 'digirisk' );

		$tab        = new \stdClass();
		$tab->title = $title;
		$tab->slug  = $target;

		ob_start();
		$element = Society_Class::g()->show_by_type( $id );
		$tab = Tab_Class::g()->build_tab_to_display( $element, $tab );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-unite-de-travail', array(
			'id'  => $id,
			'tab' => $tab
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'displayButtonUniteDeTravailSuccess',
			'view'             => ob_get_clean(),
		) );
	}


	public function callback_permisfeu_load_tab(){
		check_ajax_referer( 'permisfeu_load_tab' );
		$tab = isset( $_POST['tab'] ) ? sanitize_text_field( $_POST['tab'] ) : ''; // WPCS: input var ok.

		ob_start();
		switch( $tab ){
			case 'progress':
				Permis_Feu_Page_Class::g()->display_progress();
				break;
			default:
				Permis_Feu_Page_Class::g()->display_dashboard();
				break;
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'preventionLoadTabSuccess',
			'view'             => ob_get_clean()
		) );
	}

	public function callback_add_intervenant_to_permis_feu(){
		check_ajax_referer( 'add_intervenant_to_permis_feu' );

		$id       = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;
		$name     = isset( $_POST[ 'name' ] ) ? sanitize_text_field( $_POST[ 'name' ] ) : '';
		$lastname = isset( $_POST[ 'lastname' ] ) ? sanitize_text_field( $_POST[ 'lastname' ] ) : '';
		$mail     = isset( $_POST[ 'mail' ] ) ? sanitize_text_field( $_POST[ 'mail' ] ) : '';

		$key = isset( $_POST[ 'key' ] ) ? (int) $_POST[ 'key' ] : -1;

		if( ! $id || ! $name || ! $lastname || ! $mail ){
			wp_send_json_error( 'Erreur in request' );
		}

		$user = array(
			'name'     => $name,
			'lastname' => $lastname,
			'mail'     => $mail
		);

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		if( ! empty( $permis_feu->data[ 'intervenants' ] ) && $key != -1 && isset( $permis_feu->data[ 'intervenants' ][ $key ] ) ){
			$permis_feu->data[ 'intervenants' ][ $key ] = $user;
		}else{
			$permis_feu->data[ 'intervenants' ][] = $user;
		}

		$permis_feu = Permis_Feu_Class::g()->update( $permis_feu->data );

		ob_start();
		Permis_Feu_Class::g()->display_list_intervenant( $id );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'addIntervenantToPrevention',
			'view'             => $view
		) );
	}

	public function callback_edit_intervenant_permis_feu(){

		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;
		$key = isset( $_POST[ 'key' ] ) ? (int) $_POST[ 'key' ] : -1;

		if( ! $id || $key == "-1" ){
			wp_send_json_error( 'Error in request' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		if( ! isset( $permis_feu->data[ 'intervenants' ][ $key ] ) ){
			wp_send_json_error( 'Error in permis feu' );
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-3-table-users-edit', array(
			'id'   => $id,
			'key'  => $key,
			'user' => $permis_feu->data[ 'intervenants' ][ $key ]
		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'editIntervenantPrevention',
			'view'             => $view
		) );
	}

	public function callback_edit_this_permis_feu(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error in request' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		$permis_feu->data[ 'step' ] = 1;
		Permis_Feu_Class::g()->update( $permis_feu->data );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'editThisPreventionSuccess',
			'url'              => admin_url( 'admin.php?page=digirisk-permis-feu&id=' . $permis_feu->data['id'] )
		) );
	}

	public function callback_generate_document_permis_feu(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error in request' );
		}

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		$response = Permis_Feu_Class::g()->generate_document_odt_prevention( $permis_feu );

		$link = isset( $response[ 'document' ]->data[ 'link' ] ) ? $response[ 'document' ]->data[ 'link' ] : '';
		$title = isset( $response[ 'document' ]->data[ 'title' ] ) ? $response[ 'document' ]->data[ 'title' ] : '';
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'generateDocumentPreventionSuccess',
			'link'             => $link,
			'filename'         => $title
		) );
	}

	public function callback_delete_document_permis_feu(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error in request' );
		}

		$prevention = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		$prevention->data[ 'status' ] = "trash";
		Permis_Feu_Class::g()->update( $prevention->data );

		ob_start();
		Permis_Feu_Page_Class::g()->display_dashboard();
		$dashboard_view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'permisFeu',
			'callback_success' => 'deleteDocumentPermisFeuSuccess',
			'dashboard_view'   => $dashboard_view
		) );
	}
}

new Permis_Feu_Action();
