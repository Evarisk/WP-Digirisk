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
		add_action( 'admin_post_change_step_causerie', array( $this, 'change_step_causerie' ) );
	}

	/**
	 * Gestion des étapes lors de l'intervention.
	 *
	 * Passes à la vue suivante (étape suivante) selon l'étape actuel.
	 *
	 * Si c'est l'étape du formateur, la causerie passe à l'étape de la présentation.
	 * Si l'étape est la présentation, la causerie passe à l'étape des participants.
	 * Si l'étape est les participants, la causerie passe à l'étape finalisée.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
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

		Causerie_Intervention_Page_Class::g()->register_search( null, null );
		switch ( $causerie->data['current_step'] ) {
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_FORMER:
				$former_id      = ! empty( $_POST['former_id'] ) ? (int) $_POST['former_id'] : 0;

				if ( empty( $former_id ) ) {
					wp_send_json_error();
				}

				$causerie = Causerie_Intervention_Page_Class::g()->step_former( $causerie, $former_id );
				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-2', array(
					'final_causerie' => $causerie,
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PRESENTATION:
				$nextstep = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_TASK;
				$causerie = Causerie_Intervention_Page_Class::g()->step_slider( $causerie, $nextstep );

				if( class_exists( 'task_manager\Task_Class' ) ){
					$task = \task_manager\Task_Class::g()->get( array( 'post_parent' => $id ), true );

					if ( empty( $task ) ) {
						$task = Causerie_Intervention_Page_Class::g()->create_task_link_to_causerie( $causerie );
					}
				}

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3', array(
					'final_causerie' => $causerie,
					'all_signed'     => false,
					'task'           => isset( $task ) ? $task : array()
				) );
				break;
			case \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_TASK: // ------
				$nextstep = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PARTICIPANT;
				$causerie = Causerie_Intervention_Page_Class::g()->step_slider( $causerie, $nextstep );

				ob_start();
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4', array(
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
			'current_step'     => $causerie->data['current_step'],
			'view'             => ob_get_clean(),
		) );
	}

	public function change_step_causerie() {
		$id   = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;
		$step = ! empty( $_GET['step'] ) ? (int) $_GET['step'] : 0;

		$causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		$causerie->data['current_step'] = $step;

		Causerie_Intervention_Class::g()->update( $causerie->data );

		wp_redirect( admin_url( 'admin.php?page=digirisk-causerie&id=' . $id ) );
	}
}

new Causerie_Intervention_Page_Action();
