<?php
/**
 * Les actions relatives aux évaluateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package evaluator
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux évaluateurs
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

		add_action( 'display_evaluator_affected', array( $this, 'callback_display_evaluator_affected' ), 10, 2 );
		add_action( 'display_evaluator_to_assign', array( $this, 'callback_display_evaluator_to_assign' ), 10, 2 );
	}

	/**
	 * Assignes un évaluateur à element_id dans la base de donnée
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function callback_edit_evaluator_assign() {
		check_ajax_referer( 'edit_evaluator_assign' );

		if ( empty( $_POST['list_user'] ) || ! is_array( $_POST['list_user'] ) ) {
			wp_send_json_error();
		}

		if ( 0 === (int) $_POST['element_id'] ) {
			wp_send_json_error();
		} else {
			$element_id = (int) $_POST['element_id'];
		}

		$element = society_class::g()->show_by_type( $element_id );

		if ( empty( $element ) ) {
			wp_send_json_error();
		}

		foreach ( $_POST['list_user'] as $user_id => $list_value ) {
			if ( ! empty( $list_value['duration'] ) && ! empty( $list_value['affect'] ) ) {
				$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
				$list_value['on'] = date( 'y-m-d', strtotime( $list_value['on'] ) );
				$list_value['on'] .= ' ' . current_time( 'H:i:s' );
				$list_value['on'] = sanitize_text_field( $list_value['on'] );

				$end_date = new \DateTime( $list_value['on'] );
				$end_date->add( new \DateInterval( 'PT' . $list_value['duration'] . 'M' ) );

				$element->user_info['affected_id']['evaluator'][ $user_id ][] = array(
					'status' => 'valid',
					'start' => array(
						'date' 	=> $list_value['on'],
						'by'	=> get_current_user_id(),
						'on'	=> current_time( 'Y-m-d H:i:s' ),
					),
					'end' => array(
						'date' 	=> sanitize_text_field( $end_date->format( 'Y-m-d H:i:s' ) ),
						'by'	=> get_current_user_id(),
						'on'	=> current_time( 'Y-m-d H:i:s' ),
					),
				);

				// do_action( 'add_compiled_evaluation_id', $element_id, $user_id, count( $element->user_info['affected_id']['evaluator'][$user_id] ) - 1 );.
			}
		}

		// On met à jour si au moins un utilisateur à été affecté.
		if ( count( $_POST['list_user'] ) > 0 ) {
			Society_Class::g()->update_by_type( $element );
		}

		$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );
		ob_start();
		View_Util::exec( 'evaluator', 'list-evaluator-affected',  array( 'element' => $element, 'element_id' => $element->id, 'list_affected_evaluator' => $list_affected_evaluator ) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'evaluator',
			'callback_success' => 'callback_edit_evaluator_assign_success',
			'template' => ob_get_clean()
		) );
	}

	/**
	 * Dissocies un evaluateur de id (Passes le status de l'affectation en "deleted")
	 *
	 * @since 1.0
	 * @version 6.2.9.0
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

		$element->user_info['affected_id']['evaluator'][ $user_id ][ $affectation_data_id ]['status'] = 'deleted';
		// do_action( 'delete_compiled_evaluation_id', $element_id, $user_id, $affectation_data_id );.
		Society_Class::g()->update_by_type( $element );

		$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );
		ob_start();
		View_Util::exec( 'evaluator', 'list-evaluator-affected',  array( 'element' => $element, 'element_id' => $element->id, 'list_affected_evaluator' => $list_affected_evaluator ) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'evaluator',
			'callback_success' => 'callback_detach_evaluator_success',
			'template' => ob_get_clean(),
		) );
	}

	/**
	* Fait le rendu de l'utilisateur selon l'élement ID et la page
	*
	* int $_POST['element_id'] L'ID de l'élement affecté par la pagination
	* int $_POST['next_page'] La page de la pagination
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_paginate_evaluator() {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( $element_id === 0 ) {
			wp_send_json_error();
		}

		$element = society_class::g()->show_by_type( $element_id );
		evaluator_class::g()->render( $element );
		wp_die();
	}

	/**
	 * Méthode appelé par le champs de recherche des évaluateurs affectés
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évaluateurs trouvés par la recherche.
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function callback_display_evaluator_affected( $id, $list_user_id ) {
		$element = Society_Class::g()->show_by_type( $id );
		$list_affected_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $element );

		if ( ! empty( $list_affected_evaluator ) ) {
			foreach ( $list_affected_evaluator as $key => $sub_list ) {
				foreach ( $sub_list as $evaluator_key => $evaluator ) {
					if ( is_object( $evaluator['user_info'] ) ) {
						if ( ! in_array( $evaluator['user_info']->id, $list_user_id, true ) ) {
							unset( $list_affected_evaluator[ $key ][ $evaluator_key ] );
						}
					}
				}
			}
		}

		ob_start();
		View_Util::exec( 'evaluator', 'list-evaluator-affected',  array( 'element' => $element, 'element_id' => $element->id, 'list_affected_evaluator' => $list_affected_evaluator ) );
		wp_send_json_success( array(
			'template' => ob_get_clean()
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche des évaluateurs à assigner.
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évalateurs trouvés par la recherche.
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function callback_display_evaluator_to_assign( $id, $list_user_id ) {
		$element = Society_Class::g()->show_by_type( $id );

		$args_where_evaluator = array(
			'exclude' => array( 1 ),
		);

		$current_page = 1;

		$evaluators = Evaluator_Class::g()->get( $args_where_evaluator );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator = count( Evaluator_Class::g()->get( $args_where_evaluator ) );

		$number_page = ceil( $count_evaluator / Evaluator_Class::g()->limit_evaluator );

		if ( ! empty( $evaluators ) ) {
			foreach ( $evaluators as $key => $evaluator ) {
				if ( ! in_array( $evaluator->id, $list_user_id, true ) ) {
					unset( $evaluators[ $key ] );
				}
			}
		}

		ob_start();
		View_Util::exec( 'evaluator', 'list-evaluator-to-assign', array( 'element' => $element, 'element_id' => $element->id, 'current_page' => $current_page, 'number_page' => $number_page, 'evaluators' => $evaluators ) );
		wp_send_json_success( array(
			'template' => ob_get_clean(),
		) );
	}
}

	new Evaluator_Action();
