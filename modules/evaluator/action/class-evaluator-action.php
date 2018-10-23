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

		$society_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$users      = ! empty( $_POST['list_user'] ) ? (array) $_POST['list_user'] : array();

		if ( empty( $users ) || empty( $society_id ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->show_by_type( $society_id );

		$affected_evaluators = array();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user_id => $user ) {
				$user['affect'] = ( isset( $user['affect'] ) && $user['affect'] == 'true' ) ? true : false;
				if ( $user['affect'] ) {

					$user['on']       = current_time( 'mysql' );
					$user['duration'] = ! empty( $user['duration'] ) ? (int) $user['duration'] : 0;

					$affected_evaluators[] = Evaluator_Class::g()->affect_user( $society, $user_id, $user );
				}

			}
		}

		if ( 0 < count( $affected_evaluators ) ) {
			$content  = __( 'Mise à jour des évaluateurs', 'digirisk' );
			$content .= '<br />';

			foreach ( $affected_evaluators as $evaluator ) {
				$content .= __( 'Ajout de l\'évaluateur', 'digirisk' ) . ' ' . Evaluator_Class::g()->element_prefix . $evaluator->data['id'] . ' ' . $evaluator->data['lastname'] . ' ' . $evaluator->data['firstname'];
				$content .= '<br />';
			}

			do_action( 'digi_add_historic', array(
				'parent_id' => $society_id,
				'id'        => 'Indisponible',
				'content'   => $content,
			) );
		}

		$society = Society_Class::g()->show_by_type( $society_id );
		$affected_evaluators = Evaluator_Class::g()->get_list_affected_evaluator( $society );

		ob_start();

		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-affected', array(
			'element'                 => $society,
			'element_id'              => $society->data['id'],
			'list_affected_evaluator' => $affected_evaluators,
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'evaluator',
			'callback_success' => 'callback_edit_evaluator_assign_success',
			'template'         => ob_get_clean(),
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
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-affected', array(
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
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-affected', array(
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
