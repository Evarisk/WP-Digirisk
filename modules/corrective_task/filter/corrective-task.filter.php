<?php
/**
 * Les filtres relatifs aux tâches correctives.
 *
 * @author Evarisk <dev@evarisk.com>
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
 * Les filtres relatifs aux tâches correctives.
 */
class Corrective_Task_Filter {

	/**
	 * Constructeur
	 *
	 * @since 0.1
	 * @version 6.2.6.0
	 */
	public function __construct() {
		add_filter( 'risk_duer_additional_data', array( $this, 'callback_risk_duer_additional_data' ), 10, 2 );
		add_filter( 'task_manager_task_header_action_end', array( $this, 'callback_task_manager_task_header_action_end' ), 10, 2 );
		add_filter( 'task_manager_search_parent_query', array( $this, 'task_manager_search_parent_query' ), 10, 2 );
	}

	/**
	 * Récupères dans une chaine de caractère le contenu des tâches correctives.
	 *
	 * @param  array      $data_risk Les données des tâches correctives.
	 * @param  Risk_Model $risk      Les données du risque.
	 * @return string                La chaine de caractère mise au bon format pour le ODT.
	 *
	 * @since 6.0.0
	 * @version 6.3.1
	 */
	public function callback_risk_duer_additional_data( $data_risk, $risk ) {
		$data_risk['actionPreventionCompleted'] = '';
		$data_risk['actionPreventionUncompleted'] = '';

		if ( class_exists( '\task_manager\task_class' ) ) {
			$task = \task_manager\Task_Class::g()->get( array(
				'post_parent' => $risk->id,
			), true );

			if ( ! empty( $task->id ) ) {
				$list_point_completed = array();
				$list_point_uncompleted = array();

				if ( ! empty( $task->task_info['order_point_id'] ) ) {
					$list_point = \task_manager\Point_Class::g()->get( array(
						'post_id' => $task->id,
						'orderby' => 'comment__in',
						'comment__in' => $task->task_info['order_point_id'],
						'status' => -34070,
					) );

					$list_point_completed = array_filter( $list_point, function( $point ) {
						if ( 0 === $point->id ) {
							return false;
						}

						return true === $point->point_info['completed'];
					} );

					$list_point_uncompleted = array_filter( $list_point, function( $point ) {
						if ( 0 === $point->id ) {
							return false;
						}

						return false === $point->point_info['completed'];
					} );
				}

				$string = '';

				if ( ! empty( $list_point_completed ) ) {
					foreach ( $list_point_completed as $element ) {
						$string .= point_to_string( $element );
					}
				}

				$data_risk['actionPreventionCompleted'] = $string;
				$string = '';

				if ( ! empty( $list_point_uncompleted ) ) {
					foreach ( $list_point_uncompleted as $element ) {
						$string .= point_to_string( $element );
					}
				}

				$data_risk['actionPreventionUncompleted'] = $string;

			} // End if().
		} // End if().

		return $data_risk;
	}

	public function callback_task_manager_task_header_action_end( $content, $task_id ) {
		$task = \task_manager\Task_Class::g()->get( array(
			'id' => $task_id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'move-to', array(
			'task' => $task,
		) );

		$content .= ob_get_clean();
		return $content;
	}

	public function task_manager_search_parent_query( $query, $term ) {
		global $wpdb;
		$query = "SELECT P.ID, P.post_title FROM {$wpdb->posts} AS P
								JOIN {$wpdb->postmeta} AS PM ON PM.post_id=P.ID
								WHERE PM.meta_key='_wpdigi_unique_identifier'
									AND PM.meta_value = '" . $term . "' AND P.post_type='digi-risk'";
		return $query;
	}
}

new Corrective_Task_Filter();
