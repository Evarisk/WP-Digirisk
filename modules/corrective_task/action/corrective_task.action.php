<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class corrective_task_action {

	/**
	 * Constructeur de la classe permettant d'appeler les différentes actions / Class constructor for calling diffrent actions
	 */
	public function __construct() {
		add_action( 'wp_ajax_open_task', array( $this, 'callback_open_task' ) );

		add_action( 'wp_ajax_create_task_and_point', array( $this, 'callback_create_task_and_point' ) );
	}

	public function callback_open_task() {

		$parent_id = $_GET['id'];

		$task = new \StdClass();
		$task->id = 0;

		add_filter( 'action_create_point', function( $action ) {
			$action = 'create_task_and_point';
			return $action;
		} );

		add_filter( 'create_point_additional_option', function() {
			return '<input type="hidden" name="parent_id" value="' . $_GET['id'] . '" />';
		} );

		view_util::exec( 'corrective_task', 'form', array( 'parent_id' => $parent_id, 'task' => $task ) );
		wp_die();
	}

	public function callback_create_task_and_point() {
		global $task_controller;
		$task = $task_controller->create( array(
			'title' => __( 'Risque', 'task-manager' ),
			'parent_id' => !empty( $_POST['parent_id'] ) ? $_POST['parent_id'] : 0,
			'author_id' => get_current_user_id(),
			'option' => array( 'user_info' => array( 'owner_id' => get_current_user_id() ) ) ) );

		wp_send_json_success();
	}
}

new corrective_task_action();
