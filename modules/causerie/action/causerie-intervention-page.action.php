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
class Causerie_Intervention_Page_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'wp_ajax_next_step_causerie', array( $this, 'ajax_next_step_causerie' ) );
		add_action( 'admin_post_next_step_causerie', array( $this, 'ajax_next_step_causerie' ) );
	}

	public function ajax_next_step_causerie() {
		wp_verify_nonce( 'next_step_causerie' );

		$id = ! empty( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		if ( empty( $causerie ) ) {
			wp_send_json_error();
		}

		switch ( $causerie->current_step ) {
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_FORMER:
				$former_id      = ! empty( $_POST['former_id'] ) ? (int) $_POST['former_id'] : 0;
				$signature_data = ! empty( $_POST['signature_data'] ) ? $_POST['signature_data'] : '';

				if ( empty( $former_id ) || empty( $signature_data ) ) {
					wp_send_json_error();
				}

				$causerie = Causerie_Intervention_Page_Class::g()->step_former( $causerie, $former_id, $signature_data );

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-2', array(
					'final_causerie' => $causerie,
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PRESENTATION:
				$causerie = Causerie_Intervention_Page_Class::g()->step_slider( $causerie );

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3', array(
					'final_causerie' => $causerie,
					'all_signed'     => false,
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PARTICIPANT:
				// Cette étape n'est pas une requête ajax, mais un admin_post.
				Causerie_Intervention_Page_Class::g()->step_participants( $causerie );

				wp_redirect( admin_url( 'admin.php?page=digirisk-causerie' ) );
				break;
			default:
				break;
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'nextStep',
			'current_step'     => $causerie->current_step,
			'view'             => ob_get_clean(),
		) );
	}
}

new Causerie_Intervention_Page_Action();
