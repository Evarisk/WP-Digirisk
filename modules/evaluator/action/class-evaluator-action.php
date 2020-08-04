<?php
/**
 * Les actions relatives aux évaluateurs
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Evaluator Action class.
 */
class Evaluator_Action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_edit_eveluator_assign (Permet d'assigner un évaluateur à un élément)
	 * wp_ajax_detach_evaluator (Permet de dissocier un évaluateur d'un élément)
	 * wp_ajax_paginate_evaluator (Permet de gérer la pagination des évaluateurs)
	 */
	public function __construct() {
		add_action( 'wp_ajax_edit_evaluator_assign', array( $this, 'callback_edit_evaluator_assign' ) );
		add_action( 'wp_ajax_detach_evaluator', array( $this, 'callback_detach_evaluator' ) );

	}

	/**
	 * Assignes un évaluateur à element_id dans la base de donnée
	 *
	 * @since   6.0.0
	 */
	public function callback_edit_evaluator_assign() {
		check_ajax_referer( 'edit_evaluator_assign' );
		
		$affectation_date     = ! empty( $_POST['affectation_date'] ) ? (string) $_POST['affectation_date'] : '';
		$affectation_duration = ! empty( $_POST['affectation_duration'] ) ? (int)  $_POST['affectation_duration'] : 15;
		$user_id              = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;
		$parent_id            = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		
		$element = Society_Class::g()->show_by_type( $parent_id );
		$evaluator = User_Class::g()->get( array( 'id' => $user_id ), true );

		$evaluator->data['affectation_date'] = $affectation_date;
		$evaluator->data['affectation_duration'] = $affectation_duration;
		$evaluator->data['id'] = $user_id;
		$evaluator->data['parent_id'] = $parent_id;

		$evaluator = User_Class::g()->update($evaluator->data);

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
			'evaluator' 			  => $evaluator,
			'element'                 => $element,
		) );

		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'evaluator',
			'evaluator'        => $evaluator->data,
			'callback_success' => 'callback_edit_evaluator_assign_success',
			'view'         => $view,
		) );
	}

	/**
	 * Dissocies un evaluateur de id (Passes le status de l'affectation en "deleted")
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function callback_detach_evaluator() {
		check_ajax_referer( 'detach_evaluator' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$element_id = (int) $_POST['id'];
		}

		$evaluator = Evaluator_Class::g()->get( array( 'id' => $element_id ), true );
		$evaluator->data[ 'parent_id' ] = 0;
		User_Class::g()->update($evaluator->data);

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
			'evaluator' 			  => $evaluator,
		) );

		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'evaluator',
			'callback_success' => 'callback_detach_evaluator_success',
			'template'             => $view,
		) );
	}
}
	new Evaluator_Action();
