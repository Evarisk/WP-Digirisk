<?php
/**
 * Les actions relatives aux utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux utilisateurs
 */
class User_Action extends Singleton_Util {

	/**
	 * Le constructeur appelle les actions suivantes:
	 * wp_ajax_edit_user_assign
	 * wp_ajax_detach_user
	 * wp_ajax_paginate_user
	 * wp_ajax_search_user_affected
	 */
	protected function construct() {
		add_action( 'wp_ajax_edit_user_assign', array( $this, 'callback_edit_user_assign' ) );
		add_action( 'wp_ajax_detach_user', array( $this, 'callback_detach_user' ) );

		add_action( 'wp_ajax_paginate_user', array( $this, 'callback_paginate_user' ) );

		add_action( 'display_user_affected', array( $this, 'callback_display_user_affected' ), 10, 2 );
		add_action( 'display_user_assigned', array( $this, 'callback_display_user_assigned' ), 10, 2 );
	}

	/**
	 * Assignes un utilisateur à element_id dans la base de donnée
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_edit_user_assign() {
		check_ajax_referer( 'edit_user_assign' );

		if ( 0 === (int) $_POST['workunit_id'] ) {
			wp_send_json_error( array( 'error' => __LINE__ ) );
		} else {
			$workunit_id = (int) $_POST['workunit_id'];
		}

		if ( 0 === (int) $_POST['group_id'] ) {
			wp_send_json_error( array( 'error' => __LINE__ ) );
		} else {
			$group_id = (int) $_POST['group_id'];
		}

		if ( ! is_array( $_POST['list_user'] ) ) {
			wp_send_json_error();
		}

		$workunit = Workunit_Class::g()->get( array( 'id' => $workunit_id ) );
		$workunit = $workunit[0];

		if ( empty( $workunit ) ) {
			wp_send_json_error();
		}

		foreach ( $_POST['list_user'] as $user_id => $list_value ) {
			if ( ! empty( $list_value['affect'] ) ) {
				$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
				$workunit->user_info['affected_id']['user'][ $user_id ][] = array(
					'status' => 'valid',
					'start' => array(
						'date' 	=> sanitize_text_field( date( 'Y-m-d', strtotime( $list_value['on'] ) ) ),
						'by'	=> get_current_user_id(),
						'on'	=> current_time( 'Y-m-d' ),
					),
					'end' => array(
						'date' 	=> '0000-00-00 00:00:00',
						'by'	=> get_current_user_id(),
						'on'	=> '0000-00-00 00:00:00',
					),
				);

				// Hook pour enregister l'unité de travail dans les données compilées de l'utilisateur.
				// do_action( 'add_compiled_workunit_id', $user_id, $workunit_id );.
			}
		}

		// On met à jour si au moins un utilisateur à été affecté.
		if ( count( $_POST['list_user'] ) > 0 ) {
			$workunit = Workunit_Class::g()->update( $workunit );
		}

		ob_start();
		User_Digi_Class::g()->render( $workunit );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'user',
			'callback_success' => 'editUserAssignSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Dissocies un utilisateur à element_id dans la base de donnée
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_detach_user() {
		check_ajax_referer( 'detach_user' );
		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$user_id = ! empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		$workunit = Workunit_Class::g()->get( array( 'id' => $id ) );
		$workunit = $workunit[0];
		$index_valid_key = User_Digi_Class::g()->get_valid_in_workunit_by_user_id( $workunit, $user_id );

		$workunit->user_info['affected_id']['user'][ $user_id ][ $index_valid_key ]['status'] = 'delete';
		$workunit->user_info['affected_id']['user'][ $user_id ][ $index_valid_key ]['end'] = array(
			'date'  => current_time( 'Y-m-d' ),
			'by'	=> get_current_user_id(),
			'on'	=> current_time( 'Y-m-d' ),
		);

		// Hook pour enregister l'unité de travail dans les données compilées de l'utilisateur.
		// do_action( 'delete_compiled_workunit_id', $user_id, $id );.

		Workunit_Class::g()->update( $workunit );

		ob_start();
		User_Digi_Class::g()->render( $workunit );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'user',
			'callback_success' => 'detachUserSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Cherches les utilisateurs affectées par rapport à un term.
	 *
	 * @param integer $id L'ID de la société.
	 * @param array   $list_user_id Le tableau d'ID trouvé par la recherche.
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_display_user_affected( $id, $list_user_id ) {
		$workunit = Society_Class::g()->show_by_type( $id );
		$data = User_Digi_Class::g()->list_affected_user( $workunit );
		$list_affected_user = $data['list_affected_user'];

		if ( ! empty( $list_affected_user ) ) {
			foreach ( $list_affected_user as $key => $element ) {
				if ( ! in_array( $element->id, $list_user_id, true ) ) {
					unset( $list_affected_user[ $key ] );
				}
			}
		}

		ob_start();

		View_Util::exec( 'user', 'list-user-affected', array( 'workunit' => $workunit, 'list_affected_user' => $list_affected_user ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	 * Cherches les utilisateurs qui peuvent être affecté par rapport à un term.
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau d'ID trouvé par la recherche.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_display_user_assigned( $id, $list_user_id ) {
		$workunit = Society_Class::g()->show_by_type( $id );
		$data = User_Digi_Class::g()->list_affected_user( $workunit );
		$list_affected_id = $data['list_affected_id'];

		$current_page = 1;
		$args_where_user = array(
			'exclude' => array( 1 ),
		);

		$list_user_to_assign = User_Digi_Class::g()->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( User_Digi_Class::g()->get( $args_where_user ) );
		$number_page = ceil( $count_user / User_Digi_Class::g()->limit_user );

		if ( ! empty( $list_user_to_assign ) ) {
			foreach ( $list_user_to_assign as $key => $element ) {
				if ( ! in_array( $element->id, $list_user_id, true ) ) {
					unset( $list_user_to_assign[ $key ] );
				}
			}
		}

		ob_start();
		View_Util::exec( 'user', 'list-user-to-assign', array( 'workunit' => $workunit, 'current_page' => $current_page, 'number_page' => $number_page, 'users' => $list_user_to_assign, 'list_affected_id' => $list_affected_id ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	 * Fait le rendu de l'utilisateur selon l'élement ID et la page
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_paginate_user() {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( $element_id === 0 ) {
			wp_send_json_error();
		}

		$element = workunit_class::g()->get( array( 'include' => array( $element_id ) ), array( false ) );
		user_digi_class::g()->render_list_user_to_assign( $element[0] );
		wp_die();
	}
}

user_action::g();
