<?php
/**
 * Les actions relatives aux tâches correctives.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.5.0
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
		add_action( 'wp_ajax_create_task_and_point', array( $this, 'callback_create_task_and_point' ) );
	}

	/**
	 * Récupères la tâche liée au risque.
	 * Appelle la vue contenant le formulaire pour ajouter une tâche corrective.
	 *
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.5.0
	 */
	public function callback_open_task() {
		$parent_id = $_POST['id'];

		global $task_controller;

		if ( $task_controller ) {
			$task = $task_controller->index( array( 'post_parent' => $parent_id ) );

			if ( empty( $task ) ) {
				$task = new \StdClass();
				$task->id = 0;
			} else {
				$task = $task[0];
			}

			add_filter( 'action_create_point', function( $action ) {
				$action = 'create_task_and_point';
				return $action;
			} );

			add_filter( 'create_point_additional_option', function() {
				return '<input type="hidden" name="parent_id" value="' . $_POST['id'] . '" />';
			} );

			ob_start();
			View_Util::exec( 'corrective_task', 'form', array( 'task' => $task ) );
			$view = ob_get_clean();
		} else {
			ob_start();
			View_Util::exec( 'corrective_task', 'need-task-manager' );
			$view = ob_get_clean();
		}

		wp_send_json_success( array( 'module' => 'correctiveTask', 'callback_success' => 'openedTaskPopup', 'view' => $view ) );
	}

	public function callback_create_task_and_point() {
		global $task_controller;
		$task = $task_controller->index( array( 'post_parent' => $_POST['parent_id'] ) );
		$risk = risk_class::g()->get( array( 'include' => $_POST['parent_id'] ) );
		$risk = $risk[0];

		if ( empty( $task ) ) {
			$task = $task_controller->create( array(
				'title' => __( 'Risque ' . $risk->unique_identifier, 'task-manager' ),
				'parent_id' => !empty( $_POST['parent_id'] ) ? $_POST['parent_id'] : 0,
				'author_id' => get_current_user_id(),
				'option' => array( 'user_info' => array( 'owner_id' => get_current_user_id() ) ) ) );
		}
		else {
			$task = $task[0];
		}

		global $point_controller;
		$_POST['point']['author_id'] = get_current_user_id();
		$_POST['point']['status'] = '-34070';
		$_POST['point']['date'] = current_time( 'mysql' );
		$_POST['point']['post_id'] = $task->id;
		$point = $point_controller->create( $_POST['point'] );

		/** Add to the order point */
		$task->option['task_info']['order_point_id'][] = (int) $point->id;
		$task_controller->update( $task );

		$object_id = $task->id;
		$disabled_filter = true;

		$custom_class = 'wpeo-task-point-sortable';
		ob_start();
		require( WPEO_POINT_TEMPLATES_MAIN_DIR . '/backend/point.php' );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new Corrective_Task_Action();
