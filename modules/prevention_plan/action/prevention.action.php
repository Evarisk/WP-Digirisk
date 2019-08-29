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
 * Causerie Prevention Action Class.
 */
class Prevention_Action {
	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_prevention_save_former', array( $this, 'callback_prevention_save_former' ) );

		add_action( 'wp_ajax_prevention_save_signature', array( $this, 'callback_prevention_save_signature' ) );

		add_action( 'wp_ajax_prevention_load_tab', array( $this, 'callback_prevention_load_tab' ) );

		add_action( 'wp_ajax_prevention_save_participant', array( $this, 'callback_prevention_save_participant' ) );

		add_action( 'wp_ajax_display_button_odt_unitedetravail', array( $this, 'callback_display_button_odt_unitedetravail' ) );

		add_action( 'wp_ajax_save_user_to_society', array( $this, 'callback_save_user_to_society' ) );

		add_action( 'wp_ajax_add_intervenant_to_prevention', array( $this, 'callback_add_intervenant_to_prevention' ) );

		add_action( 'wp_ajax_edit_intervenant_prevention', array( $this, 'callback_edit_intervenant_prevention' ) );

		add_action( 'wp_ajax_prevention_display_maitre_oeuvre', array( $this, 'callback_prevention_display_maitre_oeuvre' ) );

		add_action( 'wp_ajax_prevention_save_signature_maitre_oeuvre', array( $this, 'callback_prevention_save_signature_maitre_oeuvre' ) );

		add_action( 'wp_ajax_generate_document_prevention', array( $this, 'callback_generate_document_prevention' ) );

		add_action( 'wp_ajax_delete_document_prevention', array( $this, 'callback_delete_document_prevention' ) );
		// $this->a();
	}

	public function a(){
		$prevention = Prevention_Class::g()->get( array( 'id' => 474 ), true );
		$prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] = 0;
		$prevention->data[ 'maitre_oeuvre' ][ 'signature_id' ] = 0;
		$prevention->data[ 'intervenant_exterieur' ][ 'signature_id' ] = 0;
		$prevention->data[ 'taxonomy' ] = array();
		$prevention = Prevention_Class::g()->update( $prevention->data );
	}

	public function callback_prevention_save_former(){
		$id        = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$former_id = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		$prevention->data['former']['user_id'] = $former_id;
		Prevention_Class::g()->update( $prevention->data );

		wp_send_json_success();
	}

	/**
	 * Enregistres la signature d'un utilisateur.
	 *
	 * Puis renvoie la nouvelle ligne du tableau (HTML).
	 *
	 * @since   6.6.0
	 */
	public function callback_prevention_save_signature() {
		check_ajax_referer( 'prevention_save_signature' );

		$is_former      = ( isset( $_POST['is_former'] ) && 'true' === $_POST['is_former'] ) ? true : false; // WPCS: input var ok.
		$prevention_id    = ! empty( $_POST['prevention_id'] ) ? (int) $_POST['prevention_id'] : 0; // WPCS: input var ok.
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0; // WPCS: input var ok.
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : ''; // WPCS: input var ok.

		if ( $is_former ) {
			$participant_id = ! empty( $_POST['former_id'] ) ? (int) $_POST['former_id'] : 0;
		}

		if ( empty( $prevention_id ) || empty( $participant_id ) || empty( $signature_data ) ) {
			wp_send_json_error();
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $prevention_id ), true );
		$prevention = Prevention_Class::g()->add_signature( $prevention, $participant_id, $signature_data, $is_former );

		$prevention = Prevention_Class::g()->update( $prevention->data );

		ob_start();
		if ( ! $is_former ) {
			if ( ! empty( $prevention->data['participants'] ) ) {
				foreach ( $prevention->data['participants'] as $participant ) {
					if ( $participant_id === $participant['user_id'] ) {
						$current_participant = $participant;
						break;
					}
				}
			}

		} else {
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature', array(
				'prevention' => $prevention,
				'user_type'  => 'former'
			) );
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => $is_former ? 'savedFormerSignature' : 'savedSignature',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_prevention_load_tab(){
		$tab = isset( $_POST['tab'] ) ? sanitize_text_field( $_POST['tab'] ) : ''; // WPCS: input var ok.

		ob_start();
		switch( $tab ){
			case 'progress':
				Prevention_Page_Class::g()->display_progress();
				break;
			default:
				Prevention_Page_Class::g()->display_dashboard();
				break;
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'preventionLoadTabSuccess',
			'view'             => ob_get_clean()
		) );
	}

	public function callback_prevention_save_participant() {
		check_ajax_referer( 'prevention_save_participant' );

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$participant_id = ! empty( $_POST['participant_id'] ) ? (int) $_POST['participant_id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		$prevention = Prevention_Class::g()->add_participant( $prevention, $participant_id );
		$prevention = Prevention_Class::g()->update( $prevention->data );

		Prevention_Page_Class::g()->register_search( null, null );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-4', array(
			'prevention' => $prevention,
			'all_signed' => Prevention_Class::g()->check_all_signed( $prevention ),
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'savedParticipant',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_display_button_odt_unitedetravail(){
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
			'module'           => 'preventionPlan',
			'callback_success' => 'displayButtonUniteDeTravailSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	public function callback_save_user_to_society(){
		check_ajax_referer( 'add_user_to_society' );

		$id        = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;
		$firstname = isset( $_POST[ 'name' ] ) ? sanitize_text_field( $_POST[ 'name' ] ) : '';
		$lastname  = isset( $_POST[ 'lastname' ] ) ? sanitize_text_field( $_POST[ 'lastname' ] ) : '';
		$email     = isset( $_POST[ 'mail' ] ) ? sanitize_text_field( $_POST[ 'mail' ] ) : '';
		$idprevention = isset( $_POST[ 'idprevention' ] ) ? (int) $_POST[ 'idprevention' ] : 0;

		if( ! $firstname || ! $lastname || ! $email || ! $idprevention ){
			wp_send_json_error( 'Error in save' );
		}

		$user_args = array(
			'id'        => $id,
			'login'     => trim( strtolower( remove_accents( sanitize_user( $firstname . $lastname ) ) ) ),
			'password'  => wp_generate_password(),
			'lastname'  => $lastname,
			'firstname' => $firstname,
			'email'     => $email,
			'prevention_parent' => $idprevention
		);

		User_Class::g()->update( $user_args );

		$users = Prevention_Class::g()->all_user_in_prevention_id( $idprevention );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-3-table-users', array(
			'id'  => $idprevention
		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'saveUserToSociety',
			'view'             => $view
		) );
	}

	public function callback_add_intervenant_to_prevention(){
		check_ajax_referer( 'add_intervenant_to_prevention' );

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

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		if( ! empty( $prevention->data[ 'intervenants' ] ) && $key != -1 && isset( $prevention->data[ 'intervenants' ][ $key ] ) ){
			$prevention->data[ 'intervenants' ][ $key ] = $user;
		}else{
			$prevention->data[ 'intervenants' ][] = $user;
		}

		$prevention = Prevention_Class::g()->update( $prevention->data );

		ob_start();
		Prevention_Class::g()->display_list_intervenant( $id );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'addIntervenantToPrevention',
			'view'             => $view
		) );
	}

	public function callback_edit_intervenant_prevention(){

		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;
		$key = isset( $_POST[ 'key' ] ) ? (int) $_POST[ 'key' ] : -1;

		if( ! $id || $key == "-1" ){
			wp_send_json_error( 'Error in request' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		if( ! isset( $prevention->data[ 'intervenants' ][ $key ] ) ){
			wp_send_json_error( 'Error in prevention' );
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-3-table-users-edit', array(
			'id'   => $id,
			'key'  => $key,
			'user' => $prevention->data[ 'intervenants' ][ $key ]
		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'editIntervenantPrevention',
			'view'             => $view
		) );
	}

	public function callback_prevention_display_maitre_oeuvre(){

		$prevention_id = isset( $_POST[ 'prevention_id' ] ) ? (int) $_POST[ 'prevention_id' ] : 0;
		$user_id = isset( $_POST[ 'user_id' ] ) ? (int) $_POST[ 'user_id' ] : 0;

		if( ! $user_id || ! $prevention_id ){
			wp_send_json_error( 'Error in request' );
		}

		$user_info = get_user_by( 'id', $user_id );
		$prevention = Prevention_Class::g()->update_maitre_oeuvre( $prevention_id, $user_id );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', '/start/step-4-maitre-oeuvre-name', array(
			'prevention' => Prevention_Class::g()->add_information_to_prevention( $prevention )
		) );
		$view_name = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', '/start/step-4-maitre-oeuvre-phone', array(
			'prevention' => $prevention
		) );
		$view_phone = ob_get_clean();

		wp_send_json_success( array(
			'view_name'  => $view_name,
			'view_phone' => $view_phone
		) );
	}
	public function callback_prevention_save_signature_maitre_oeuvre(){
		check_ajax_referer( 'prevention_save_signature_maitre_oeuvre' );

		$prevention_id    = ! empty( $_POST['prevention_id'] ) ? (int) $_POST['prevention_id'] : 0; // WPCS: input var ok.
		$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : ''; // WPCS: input var ok.
		$user_type = ! empty( $_POST['user-type'] ) ? $_POST['user-type'] : ''; // WPCS: input var ok.

		if ( ! $prevention_id || ! $signature_data ) {
			wp_send_json_error( 'Error in request' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $prevention_id ), true );
		$prevention = Prevention_Class::g()->add_signature_maitre_oeuvre( $prevention, $signature_data , $user_type );

		$prevention = Prevention_Class::g()->update( $prevention->data );
		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature', array(
			'prevention' => $prevention,
			'user_type'  => $user_type,
			'user_type_attr' => $user_type == 'maitre_oeuvre' ? 'maitre-oeuvre-signature' : 'intervenant-exterieur-signature',

		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'displaySignatureLastPage',
			'view'             => $view,
			'class_parent'     => $user_type == 'maitre_oeuvre' ? 'information-maitre-oeuvre' : 'information-intervenant-exterieur',
		) );
	}
	public function callback_generate_document_prevention(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error in request' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		$response = Prevention_Class::g()->generate_document_odt_prevention( $prevention );

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

	public function callback_delete_document_prevention(){
		$id = isset( $_POST[ 'id' ] ) ? (int) $_POST[ 'id' ] : 0;

		if( ! $id ){
			wp_send_json_error( 'Error in request' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		$prevention->data[ 'status' ] = "trash";
		Prevention_Class::g()->update( $prevention->data );

		ob_start();
		Prevention_Page_Class::g()->display_dashboard();
		$dashboard_view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'deleteDocumentPreventionSuccess',
			'dashboard_view'   => $dashboard_view
		) );
	}
}

new Prevention_Action();
