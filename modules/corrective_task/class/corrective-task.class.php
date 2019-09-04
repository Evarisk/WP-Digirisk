<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Corrective_Task_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructeur de la classe permettant d'appeler les différentes classs / Class constructor for calling diffrent classs
	 */
	protected function construct() {}

	public function output_odt( $risk ) {
		$risk->data['output_action_prevention_uncompleted'] = '';
		$risk->data['output_action_prevention_completed']   = '';

		if ( class_exists( '\task_manager\Task_Class' ) ) {
			$task = \task_manager\Task_Class::g()->get( array(
				'post_parent'    => $risk->data['id'],
				'posts_per_page' => 1,
			), true );

			if ( ! empty( $task->data['id'] ) ) {
				$list_point_completed = array();
				$list_point_uncompleted = array();

				$list_point = \task_manager\Point_Class::g()->get( array(
					'post_id'  => $task->data['id'],
					'meta_key' => '_tm_order',
					'orderby'  => 'meta_value_num',
					'order'    => 'ASC',
				) );

				$list_point_completed = array_filter( $list_point, function( $point ) {
					if ( 0 === $point->data['id'] ) {
						return false;
					}

					return true === $point->data['completed'];
				} );

				$list_point_uncompleted = array_filter( $list_point, function( $point ) {
					if ( 0 === $point->data['id'] ) {
						return false;
					}

					return false === $point->data['completed'];
				} );

				$string = '';

				if ( ! empty( $list_point_completed ) ) {
					foreach ( $list_point_completed as $element ) {
						$string .= point_to_string( $element ) . "\n";
					}
				}

				$risk->data['output_action_prevention_completed'] = $string;
				$string = '';

				if ( ! empty( $list_point_uncompleted ) ) {
					foreach ( $list_point_uncompleted as $element ) {
						$string .= point_to_string( $element ) . "\n";
					}
				}

				$risk->data['output_action_prevention_uncompleted'] = $string;
			}
		}

		return $risk;
	}
}

new Corrective_Task_Class();
