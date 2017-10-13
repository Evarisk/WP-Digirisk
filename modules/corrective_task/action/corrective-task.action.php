<?php
/**
 * Les actions relatives aux tâches correctives.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.1
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux tâches correctives.
 */
class Corrective_Task_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_open_task', array( $this, 'callback_open_task' ) );
	}

	/**
	 * Récupères la tâche liée au risque.
	 * Appelle la vue contenant le formulaire pour ajouter une tâche corrective.
	 *
	 * @since 6.0.0
	 * @version 6.3.1
	 *
	 * @return void
	 */
	public function callback_open_task() {
		$parent_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		if ( class_exists( '\task_manager\Task_Class' ) ) {
			$task = \task_manager\Task_Class::g()->get( array(
				'id' => 0,
			), true );

			$risk = Risk_Class::g()->get( array(
				'id' => $parent_id,
			), true );

			$society = Society_Class::g()->show_by_type( $risk->parent_id );

			if ( empty( $task->id ) ) {
				$task = \task_manager\Task_Class::g()->update( array(
					'title' => __( $society->unique_identifier . ' ' . $society->title . ' -> risque ' . $risk->unique_identifier, 'task-manager' ),
					'parent_id' => $parent_id,
					'author_id' => get_current_user_id(),
					'user_info' => array(
						'owner_id' => get_current_user_id(),
						'affected_id' => array(),
					),
				) );
			}

			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'form', array(
				'task' => $task,
			) );
			$view = ob_get_clean();
		} else {
			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'need-task-manager' );
			$view = ob_get_clean();
		} // End if().

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'correctiveTask',
			'callback_success' => 'openedTaskPopup',
			'view' => $view,
		) );
	}
}

new Corrective_Task_Action();
