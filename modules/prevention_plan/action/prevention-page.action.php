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
class Prevention_Page_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );

		add_action( 'wp_ajax_start_prevention', array( $this, 'callback_start_prevention' ) );
		add_action( 'admin_post_start_prevention', array( $this, 'callback_start_prevention' ) );

		add_action( 'wp_ajax_next_step_prevention', array( $this, 'ajax_next_step_prevention' ) );
		add_action( 'admin_post_next_step_prevention', array( $this, 'ajax_next_step_prevention' ) );

		add_action( 'admin_post_change_step_prevention', array( $this, 'change_step_prevention' ) );
	}

	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Prevention', 'digirisk' ), __( 'Plan de prévention', 'digirisk' ), 'manage_digirisk', 'digirisk-prevention', array( Prevention_Page_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	/**
	 * Creation des plans de prévention
	 * @var [type]
	 */
	 public function callback_start_prevention() {
 		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		if( ! empty( $prevention ) && $prevention->data[ 'id' ] != 0 ){
			echo '<pre>'; print_r( 'DEFINE' ); echo '</pre>'; exit;
		}else{
			$data = array(
				'title' => 'Nouveau Plan de prévention',
				'step'  => 1
			);
			$prevention = Prevention_Class::g()->create( $data );
		}
		wp_redirect( admin_url( 'admin.php?page=digirisk-prevention&id=' . $prevention->data['id'] ) );
 	}

	public function ajax_next_step_prevention() {
		wp_verify_nonce( 'next_step_causerie' );

		$id = ! empty( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		if ( empty( $prevention ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		if( ! empty( $society ) ){
			$legal_display = Legal_Display_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $society->data[ 'id' ],
			), true );
		}

		Prevention_Page_Class::g()->register_search( null, null );
		switch ( $prevention->data['step'] ) {
			case \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_FORMER:
				$former_id      = ! empty( $_POST['former_id'] ) ? (int) $_POST['former_id'] : 0;

				if ( empty( $former_id ) ) {
					wp_send_json_error();
				}

				$prevention = Prevention_Class::g()->step_former( $prevention, $former_id );
				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2', array(
					'prevention' => $prevention,
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_INFORMATION:
				$nextstep = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_ENTERPRISE;
				$data = array(
					'title' => isset( $_POST[ 'prevention-title' ] ) ? sanitize_text_field( $_POST[ 'prevention-title' ] ) : '',
					'date_start' => isset( $_POST[ 'start_date' ] ) ? sanitize_text_field( $_POST[ 'start_date' ] ) : '',
					'date_end'   => isset( $_POST[ 'end_date' ] ) ? sanitize_text_field( $_POST[ 'end_date' ] ) : ''
				);
				$prevention = Prevention_Class::g()->update_information_prevention( $prevention, $data );

				$prevention = Prevention_Page_Class::g()->next_step( $prevention, $nextstep );

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-3', array(
					'prevention'    => $prevention,
					'society'       => $society,
					'legal_display' => $legal_display
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_ENTERPRISE:
				Prevention_Page_Class::g()->step_participants( $prevention );

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-4', array(
					'prevention' => $prevention,
					'society'       => $society,
					'all_signed' => false
				) );

				break;
			case \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_PARTICIPANT:
				echo '<pre>'; print_r( 'end' ); echo '</pre>'; exit;
				// wp_redirect( admin_url( 'admin.php?page=digirisk-causerie' ) );
				break;
			default:
				break;
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'preventionPlan',
			'callback_success' => 'nextStep',
			'current_step'     => $prevention->data['step'],
			'view'             => ob_get_clean(),
		) );
	}

	public function change_step_prevention(){
		$id   = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;
		$step = ! empty( $_GET['step'] ) ? (int) $_GET['step'] : 0;

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		if ( $prevention->data['step'] >= $step ) {
			$prevention->data['step'] = $step;
			Prevention_Class::g()->update( $prevention->data );
		}

		wp_redirect( admin_url( 'admin.php?page=digirisk-prevention&id=' . $id ) );
	}
}

new Prevention_Page_Action();
