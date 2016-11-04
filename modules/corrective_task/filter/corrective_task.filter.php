<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class corrective_task_filter {

	/**
	 * Constructeur de la classe permettant d'appeler les différentes classs / Class constructor for calling diffrent classs
	 */
	public function __construct() {
		add_filter( 'risk_duer_additional_data', array( $this, 'callback_risk_duer_additional_data' ), 10, 2 );
	}

	public function callback_risk_duer_additional_data( $data_risk, $risk ) {
		if ( class_exists( "task_controller" ) ) {
			global $task_controller;
			global $point_controller;

			$task = $task_controller->index( array( 'post_parent' => $risk->id ) );

			if ( !empty( $task ) ) {
				$task = $task[0];

				$list_point_completed = array();
				$list_point_uncompleted = array();

				if ( !empty( $task->option['task_info']['order_point_id'] ) ) {
					$list_point = $point_controller->index( $task->id, array( 'orderby' => 'comment__in', 'comment__in' => $task->option['task_info']['order_point_id'], 'status' => -34070 ) );
					$list_point_completed = array_filter( $list_point, function( $point ) { return $point->option['point_info']['completed'] === true; } );
					$list_point_uncompleted = array_filter( $list_point, function( $point ) { return $point->option['point_info']['completed'] === false; } );
				}

				$string = 'Complété' . "
	";

				if ( !empty( $list_point_completed ) ) {
				  foreach ( $list_point_completed as $element ) {
						$string .= "Le " . mysql2date( 'd F Y', $element->date, true ) . ':' . $element->content . "
	";
				  }
				}

				$string .= 'Incomplet' . "
	";

				if ( !empty( $list_point_uncompleted ) ) {
				  foreach ( $list_point_uncompleted as $element ) {
						$string .= "Le " . mysql2date( 'd F Y', $element->date, true ) . ":" . $element->content . "
	";
				  }
				}

				$data_risk['actionPrevention'] = $string;
			}
		}

		return $data_risk;
	}
}

new corrective_task_filter();
