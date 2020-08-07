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

		if ( 0 === (int) $_POST['user_id'] ) {
			echo ('Veuillez renseigner un nom d\'utilisateur');
			wp_send_json_error();
		} else {
			$element_id = (int) $_POST['user_id'];
		}

		$default_duration     = 15;
		$affectation_date     = ! empty( $_POST['affectation_date'] ) ? (string) $_POST['affectation_date'] : '';
		$affectation_duration = ! empty( $_POST['affectation_duration'] ) ? (int)  $_POST['affectation_duration'] : $default_duration;
		$user_id              = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;
		$parent_id            = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		$users                = ! empty( $_POST['list_user'] ) ? (array) $_POST['list_user'] : array();

		$element = Society_Class::g()->show_by_type( $parent_id );
		$evaluator = User_Class::g()->get( array( 'id' => $user_id ), true );

		$evaluator_infos = array(
			'affectation_date' => $affectation_date,
			'affectation_duration' => $affectation_duration,
			'id' => $user_id,
			'parent_id' => $parent_id,
		);

		$affected_evaluator[] = Evaluator_Class::g()->affect_user( $element, $user_id, $evaluator_infos );
		$affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );

		Society_Class::g()->update($element->data);
		User_Class::g()->update($evaluator->data);
		
		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
			'default_duration' => $default_duration,
      'element'          => $element,
			'evaluator'        => end($affected_evaluator[$affectation_date]),

		) );

		$view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'evaluator',
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

		if ( ! isset( $_POST['affectation_id'] ) ) {
			wp_send_json_error();
		} else {
			$affectation_data_id = (int) $_POST['affectation_id'];

		}

		if ( 0 === (int) $_POST['user_id'] ) {
			wp_send_json_error();
		} else {
			$user_id = (int) $_POST['user_id'];
		}

		$element = Society_Class::g()->show_by_type( $element_id );


		if ( empty( $element ) ) {
			wp_send_json_error();
		}

		$element->data['user_info']['affected_id']['evaluator'][ $user_id ][ $affectation_data_id ]['status'] = 'deleted';

		do_action( 'digi_add_historic', array(
			'parent_id' => $element->data['id'],
			'id'        => 'Indisponible',
			'content'   => 'Mise à jour des évaluateurs',
		) );

		Society_Class::g()->update_by_type( $element );

		$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
			'element'                 => $element,
			'element_id'              => $element->data['id'],
			'list_affected_evaluator' => $list_affected_evaluator,
		) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'evaluator',
			'callback_success' => 'callback_detach_evaluator_success',
			'template'         => ob_get_clean(),
		) );
	}
}

new Evaluator_Action();
