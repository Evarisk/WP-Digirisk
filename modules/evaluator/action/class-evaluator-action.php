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
		add_action( 'wp_ajax_paginate_evaluator', array( $this, 'callback_paginate_evaluator' ) );

		add_action( 'display_evaluator_affected', array( $this, 'callback_display_evaluator_affected' ), 10, 1 );
		add_action( 'display_evaluator_to_assign', array( $this, 'callback_display_evaluator_to_assign' ), 10, 1 );
	}

	/**
	 * Assignes un évaluateur à element_id dans la base de donnée
	 *
	 * @since   6.0.0
	 */
	public function callback_edit_evaluator_assign() {
		check_ajax_referer( 'edit_evaluator_assign' );

	

		$affectation_date     = ! empty( $_POST['affectation_date'] ) ? (string) $_POST['affectation_date'] : '';
		$affectation_duration = ! empty( $_POST['affectation_duration'] ) ? (int)  $_POST['affectation_duration'] : 0;
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
			'evaluator' => $evaluator->data,
			'callback_success' => 'callback_edit_evaluator_assign_success',
			'template'         => $view,
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
/*
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
*/
		/*$element = Society_Class::g()->show_by_type( $element_id );

		if ( empty( $element ) ) {
			wp_send_json_error();
		}*/

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

	/**
	 * Fait le rendu de l'utilisateur selon l'élement ID et la page
	 *
	 * int $_POST['element_id'] L'ID de l'élement affecté par la pagination
	 * int $_POST['next_page'] La page de la pagination
	 *
	 * @since 6.0.0
	 *
	 * @param array $_POST Les données envoyées par le formulaire
	 */
	public function callback_paginate_evaluator() {
		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( $element_id === 0 ) {
			wp_send_json_error();
		}

		$element = Society_Class::g()->show_by_type( $element_id );
		Evaluator_Class::g()->render( $element );
		wp_die();
	}

	/**
	 * Méthode appelé par le champs de recherche des évaluateurs affectés
	 *
	 * @since 6.0.0
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évaluateurs trouvés par la recherche.
	 */
	public function callback_display_evaluator_affected( $data ) {
		$list_user_id = array();

		if ( ! empty( $data['users'] ) ) {
			foreach ( $data['users'] as $user ) {
				$list_user_id[] = $user->data['id'];
			}
		}

		$element                 = Society_Class::g()->show_by_type( $data['args']['post_id'] );
		$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );

		if ( ! empty( $list_affected_evaluator ) ) {
			foreach ( $list_affected_evaluator as $key => $sub_list ) {
				foreach ( $sub_list as $evaluator_key => $evaluator ) {
					if ( is_object( $evaluator['user_info'] ) ) {
						if ( ! in_array( $evaluator['user_info']->data['id'], $list_user_id, true ) ) {
							unset( $list_affected_evaluator[ $key ][ $evaluator_key ] );
						}
					}
				}
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
			'element'                 => $element,
			'element_id'              => $element->data['id'],
			'list_affected_evaluator' => $list_affected_evaluator,
		) );

		wp_send_json_success( array(
			'view'   => ob_get_clean(),
			'output' => '.affected-evaluator',
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche des évaluateurs à assigner.
	 *
	 * @since 6.0.0
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évalateurs trouvés par la recherche.
	 */

	public function callback_display_evaluator_to_assign( $data ) {
		$list_user_id = array();

		if ( ! empty( $data['users'] ) ) {
			foreach ( $data['users'] as $user ) {
				$list_user_id[] = $user->data['id'];
			}
		}

		$element = Society_Class::g()->show_by_type( $data['args']['post_id'] );

		$args_where_evaluator = array(
			'exclude' => array( 1 ),
		);

		$current_page = 1;

		$evaluators = Evaluator_Class::g()->get( $args_where_evaluator );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator                = count( Evaluator_Class::g()->get( $args_where_evaluator ) );
		$number_page                    = ceil( $count_evaluator / Evaluator_Class::g()->limit_evaluator );

		if ( ! empty( $evaluators ) ) {
			foreach ( $evaluators as $key => $evaluator ) {
				if ( ! in_array( $evaluator->data['id'], $list_user_id, true ) ) {
					unset( $evaluators[ $key ] );
				}
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-to-assign', array(
			'element'      => $element,
			'element_id'   => $element->data['id'],
			'current_page' => $current_page,
			'number_page'  => $number_page,
			'evaluators'   => $evaluators,
		) );
		wp_send_json_success( array(
			'view'   => ob_get_clean(),
			'output' => '.form-edit-evaluator-assign',
		) );
	}
}


	new Evaluator_Action();
