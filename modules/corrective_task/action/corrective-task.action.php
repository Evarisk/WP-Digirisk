<?php
/**
 * Les actions relatives aux tâches correctives.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package corrective-task
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux tâches correctives.
 */
class Corrective_Task_Action {

	/**
	 * Le constructeur
	 *
	 * @since 1.0
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_open_task', array( $this, 'callback_open_task' ) );
	}

	/**
	 * Récupères la tâche liée au risque.
	 * Appelle la vue contenant le formulaire pour ajouter une tâche corrective.
	 *
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function callback_open_task() {
		$parent_id = $_POST['id'];

		if ( class_exists( '\task_manager\Task_Class' ) ) {
			$task = \task_manager\Task_Class::g()->get( array(
				'post_parent' => $parent_id,
			) );
			$risk = Risk_Class::g()->get( array(
				'include' => $parent_id,
			) );

			$risk = $risk[0];

			$society = Society_Class::g()->show_by_type( $risk->parent_id );

			if ( empty( $task ) ) {
				$task = \task_manager\Task_Class::g()->update( array(
					'title' => __( $society->unique_identifier . ' ' . $society->title . ' -> risque ' . $risk->unique_identifier, 'task-manager' ),
					'parent_id' => $parent_id,
					'author_id' => get_current_user_id(),
					'user_info' => array(
						'owner_id' => get_current_user_id(),
					),
				) );
			} else {
				$task = $task[0];
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
