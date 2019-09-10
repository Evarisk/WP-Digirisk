<?php
/**
 * Gestion des actions des causeries pour la lecture.
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
 * Gestion des actions des causeries pour la lecture.
 */
class Permis_Feu_Page_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );

		add_action( 'wp_ajax_start_permis_feu', array( $this, 'callback_start_permis_feu' ) );
		add_action( 'admin_post_start_permis_feu', array( $this, 'callback_start_permis_feu' ) );

		add_action( 'wp_ajax_next_step_permis_feu', array( $this, 'ajax_next_step_permis_feu' ) );
		add_action( 'admin_post_next_step_permis_feu', array( $this, 'ajax_next_step_permis_feu' ) );

		add_action( 'admin_post_change_step_permis_feu', array( $this, 'change_step_permis_feu' ) );
	}

	//\\SYNO1512\public\evarisk\illustrations en attente\stand alone\source

	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Permis', 'digirisk' ), __( 'Permis de feu', 'digirisk' ), 'manage_digirisk', 'digirisk-permis-feu', array( Permis_Feu_Page_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	public function callback_start_permis_feu() {
	   $id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;

	   $permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
	   if( ! empty( $permis_feu ) && $permis_feu->data[ 'id' ] != 0 ){
		   echo '<pre>'; print_r( 'DEFINE' ); echo '</pre>'; exit;
	   }else{
		   $data = array(
			   'title' => 'Nouveau Permis de feu',
			   'step'  => 1
		   );
		   $permis_feu = Permis_Feu_Class::g()->create( $data );
	   }
	   wp_redirect( admin_url( 'admin.php?page=digirisk-permis-feu&id=' . $permis_feu->data['id'] ) );
   }

   public function ajax_next_step_permis_feu() {
	   wp_verify_nonce( 'next_step_permis_feu' );

	   $id = ! empty( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;

	   if ( empty( $id ) ) {
		   wp_send_json_error();
	   }

	   $permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
	   $permis_feu = Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu );

	   if ( empty( $permis_feu ) ) {
		   wp_send_json_error();
	   }

	   $society = Society_Class::g()->get( array(
		   'posts_per_page' => 1,
	   ), true );

	   $legal_display = '';
	   if( ! empty( $society ) ){
		   $legal_display = Legal_Display_Class::g()->get( array(
			   'posts_per_page' => 1,
			   'post_parent'    => $society->data[ 'id' ],
		   ), true );
	   }

	   $url_redirect = '';

	   Permis_Feu_Page_Class::g()->register_search( null, null );
	   switch ( $permis_feu->data['step'] ) {
		   case \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_FORMER:
			   $permis_feu = Permis_Feu_Class::g()->step_maitreoeuvre( $permis_feu );
			   ob_start();
			   \eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2', array(
				   'permis_feu' => $permis_feu,
			   ) );
			   break;
		   case \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_INFORMATION:
			   $nextstep = \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_ENTERPRISE;
			   $data = array(
				   'title'=> isset( $_POST[ 'permis_feu-title' ] ) ? sanitize_text_field( $_POST[ 'permis_feu-title' ] ) : '',
				   'date_start'          => isset( $_POST[ 'start_date' ] ) ? sanitize_text_field( $_POST[ 'start_date' ] ) : '',
				   'date_end'            => isset( $_POST[ 'end_date' ] ) ? sanitize_text_field( $_POST[ 'end_date' ] ) : '',
				   'date_end__is_define' => isset( $_POST[ 'date_end__is_define' ] ) ? sanitize_text_field( $_POST[ 'date_end__is_define' ] ) : 'defined'
			   );
			   $permis_feu = Permis_Feu_Class::g()->update_information_permis_feu( $permis_feu, $data );
			   $permis_feu = Permis_Feu_Page_Class::g()->next_step( $permis_feu, $nextstep );

			   ob_start();
			   \eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-3', array(
				   'permis_feu'    => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu ),
				   'society'       => $society,
				   'legal_display' => $legal_display
			   ) );
			   break;
		   case \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_ENTERPRISE:
		   		$permis_feu = Permis_Feu_Class::g()->save_info_maitre_oeuvre();
				$permis_feu = Permis_Feu_Page_Class::g()->save_society_information( $permis_feu, $society, $legal_display );

				$text_info = "";
				if( empty( $permis_feu->data[ 'intervenants' ] ) ){
					$data_return = Permis_Feu_Class::g()->import_list_intervenant( $permis_feu );
					$permis_feu = $data_return[ 'permis_feu' ];
					$text_info = $data_return[ 'text_info' ];
				}
			   ob_start();
			   \eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-4', array(
				   'permis_feu' => $permis_feu,
				   'all_signed' => false,
				   'text_info'       => $text_info
			   ) );
			   break;
		   case \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_PARTICIPANT:
			   Permis_Feu_Page_Class::g()->step_close_permis_feu( $permis_feu, $society, $legal_display );
			   $url_redirect = admin_url( 'admin.php?page=digirisk-permis-feu' );
			   break;
		   default:
			   break;
	   }

	   wp_send_json_success( array(
		   'namespace'        => 'digirisk',
		   'module'           => 'permisFeu',
		   'callback_success' => 'nextStep',
		   'current_step'     => $permis_feu->data['step'],
		   'url'              => $url_redirect,
		   'view'             => ob_get_clean(),
	   ) );
   }

   public function change_step_permis_feu(){
	   $id   = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;
	   $step = ! empty( $_GET['step'] ) ? (int) $_GET['step'] : 0;

	   $permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );

	   if ( $permis_feu->data['step'] >= $step ) {
		   $permis_feu->data['step'] = $step;
		   Permis_Feu_Class::g()->update( $permis_feu->data );
	   }

	   wp_redirect( admin_url( 'admin.php?page=digirisk-permis-feu&id=' . $id ) );
   }
}

new Permis_Feu_Page_Action();
