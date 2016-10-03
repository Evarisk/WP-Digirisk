<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_action extends singleton_util {
	/**
	* Le constructeur appelle les actions suivantes:
	* admin_menu (Pour déclarer le sous menu dans le menu utilisateur de WordPress)
	* wp_ajax_edit_user_assign
	* wp_ajax_detach_user
	* wp_ajax_paginate_user
	* wp_ajax_search_user_affected
	*/
	protected function construct() {
			// Quand on affecte un utilisateur
		add_action( 'wp_ajax_edit_user_assign', array( $this, 'callback_edit_user_assign' ) );

		// Quand on désaffecte un utilisateur
		add_action( 'wp_ajax_detach_user', array( $this, 'callback_detach_user' ) );

		add_action( 'wp_ajax_paginate_user', array( $this, 'callback_paginate_user' ) );

		// Recherche d'un utilisateur affecté
		add_action( 'display_user_affected', array( $this, 'callback_display_user_affected' ), 10, 2 );
		add_action( 'display_user_assigned', array( $this, 'callback_display_user_assigned' ), 10, 2 );
	}

	/**
	* Assignes un utilisateur à element_id dans la base de donnée
	*
	* array $_POST['list_user'] La liste des utilisateurs à assigner
	* string $_POST['list_user']['duration'] La durée de l'assignation
	* string $_POST['list_user']['on'] La date d'assignation
	* bool $_POST['list_user']['affect'] Si l'utilisateur doit être assigné
	* int $_POST['workunit_id'] L'élement ou les utilisateurs doivent être assignés
	* int $_POST['group_id'] L'ID du groupement
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_edit_user_assign() {
		if ( 0 === (int)$_POST['workunit_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$workunit_id = (int)$_POST['workunit_id'];

		if ( 0 === (int)$_POST['group_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$group_id = (int)$_POST['group_id'];

		if( !is_array( $_POST['list_user'] ) )
			wp_send_json_error();

		$workunit = workunit_class::g()->get( array( 'id' => $workunit_id ) );
		$workunit = $workunit[0];

		if ( empty( $workunit ) )
			wp_send_json_error();

		foreach ( $_POST['list_user'] as $user_id => $list_value ) {
			if ( !empty( $list_value['affect'] ) ) {
				$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
				$workunit->user_info['affected_id']['user'][$user_id][] = array(
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

				// Hook pour enregister l'unité de travail dans les données compilées de l'utilisateur
				// do_action( 'add_compiled_workunit_id', $user_id, $workunit_id );
			}
		}

		// On met à jour si au moins un utilisateur à été affecté
		if( count( $_POST['list_user'] ) > 0 ) {
			$workunit = workunit_class::g()->update( $workunit );
		}

		ob_start();
		user_digi_class::g()->render( $workunit );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Dissocies un utilisateur à element_id dans la base de donnée
	*
	* int $_POST['id'] L'ID de l'élément parent
	* int $_POST['user_id'] L'ID de l'utilisateur a dissocier
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_detach_user() {
		$id = !empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$user_id = !empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

		$workunit = workunit_class::g()->get( array( 'id' => $id ) );
		$workunit = $workunit[0];
		$index_valid_key = user_digi_class::g()->get_valid_in_workunit_by_user_id( $workunit, $user_id );

		$workunit->user_info['affected_id']['user'][$user_id][$index_valid_key]['status'] = 'delete';
		$workunit->user_info['affected_id']['user'][$user_id][$index_valid_key]['end'] = array(
			'date'  => current_time( 'Y-m-d' ),
			'by'	=> get_current_user_id(),
			'on'	=> current_time( 'Y-m-d' ),
		);

		// Hook pour enregister l'unité de travail dans les données compilées de l'utilisateur
		// do_action( 'delete_compiled_workunit_id', $user_id, $id );

		workunit_class::g()->update( $workunit );

		ob_start();
		user_digi_class::g()->render( $workunit );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Cherches les utilisateurs affectées par rapport à un term
	*
	* string $_POSt['user_name_affected'] La recherche fait par l'utilisateur
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_display_user_affected( $id, $list_user_id ) {
		$workunit = society_class::g()->show_by_type( $id );
		$data = user_digi_class::g()->list_affected_user( $workunit );
		$list_affected_user = $data['list_affected_user'];

		if ( !empty( $list_affected_user ) ) {
		  foreach ( $list_affected_user as $key => $element ) {
				if ( !in_array( $element->id, $list_user_id ) ) {
					unset( $list_affected_user[$key] );
				}
		  }
		}

		ob_start();

		view_util::exec( 'user', 'list-affected-user', array( 'workunit' => $workunit, 'list_affected_user' => $list_affected_user, ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function callback_display_user_assigned( $id, $list_user_id ) {
		$workunit = society_class::g()->show_by_type( $id );
		$data = user_digi_class::g()->list_affected_user( $workunit );
		$list_affected_id = $data['list_affected_id'];

		$current_page = !empty( $_REQUEST['next_page'] ) ? (int) $_REQUEST['next_page'] : 1;
		$args_where_user = array(
			'exclude' => array( 1 )
		);

		$list_user_to_assign = user_digi_class::g()->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( user_digi_class::g()->get( $args_where_user ) );
		$number_page = ceil( $count_user / user_digi_class::g()->limit_user );

		if ( !empty( $list_user_to_assign ) ) {
			foreach ( $list_user_to_assign as $key => $element ) {
				if ( !in_array( $element->id, $list_user_id ) ) {
					unset( $list_user_to_assign[$key] );
				}
			}
		}

		ob_start();
		view_util::exec( 'user', 'list-user-to-assign', array( 'workunit' => $workunit, 'current_page' => $current_page, 'number_page' => $number_page, 'list_user_to_assign' => $list_user_to_assign, 'list_affected_id' => $list_affected_id ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Fait le rendu de l'utilisateur selon l'élement ID et la page
	*
	* int $_POST['element_id'] L'ID de l'élement affecté par la pagination
	* int $_POST['next_page'] La page de la pagination
	*
	* @param array $_POST Les données envoyées par le formulaire
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
