<?php if ( !defined( 'ABSPATH' ) ) exit;

class evaluator_action {
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
	* array $_POST['list_user'] La liste des evaluateurs à assigner
	* string $_POST['list_user']['duration'] La durée de l'assignation
	* string $_POST['list_user']['on'] La date d'assignation
	* bool $_POST['list_user']['affect'] Si l'évaluateur doit être assigné
	* int $_POST['element_id'] L'élement ou les evaluateurs doivent être assignés
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_edit_evaluator_assign() {
		// Todo : A déplacer dans la class
		// Est ce que list_user est vide ? Ou est ce que workunit_id est vide et est-ce bien un entier ?
		if ( empty( $_POST['list_user'] ) || !is_array( $_POST['list_user'] ) )
			wp_send_json_error();

		if ( 0 === (int) $_POST['element_id'] )
			wp_send_json_error();
		else {
			$element_id = (int) $_POST['element_id'];
		}

		$element = society_class::g()->show_by_type( $element_id );

		if ( empty( $element ) )
			wp_send_json_error();

		foreach ( $_POST['list_user'] as $user_id => $list_value ) {
			if ( !empty( $list_value['duration'] ) && !empty( $list_value['affect'] ) ) {
				$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
				$list_value['on'] = date( 'y-m-d', strtotime( $list_value['on'] ) );
				$list_value['on'] .= ' ' . current_time( 'H:i:s' );
				$list_value['on'] = sanitize_text_field( $list_value['on'] );

				$end_date = new DateTime( $list_value['on'] );
				$end_date->add( new DateInterval( 'PT' . $list_value['duration'] . 'M' ) );


				$element->user_info['affected_id']['evaluator'][$user_id][] = array(
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
			}
		}

		//On met à jour si au moins un utilisateur à été affecté
		if( count( $_POST['list_user'] ) > 0 )
			society_class::g()->update_by_type( $element );

		$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $element );
		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	/**
	* Dissocies un evaluateur de id (Passes le status de l'affectation en "deleted")
	*
	* int $_POST['id'] L'ID de l'élement ou l'évaluateur sera dissocié
	* int $_POST['affectation_id'] L'index de l'évaluateur
	* int $_POST['user_id'] L'ID de l'évaluateur
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function callback_detach_evaluator() {
		if ( 0 === (int) $_POST['id'] )
			wp_send_json_error();
		else {
			$element_id = (int) $_POST['id'];
		}

		if ( !isset( $_POST['affectation_id'] ) )
			wp_send_json_error();
		else {
			$affectation_data_id = (int) $_POST['affectation_id'];
		}

		if ( 0 === (int) $_POST['user_id'] )
			wp_send_json_error();
		else {
			$user_id = (int) $_POST['user_id'];
		}

		$element = society_class::g()->show_by_type( $element_id );

		if ( empty( $element ) )
			wp_send_json_error();

		$element->user_info['affected_id']['evaluator'][$user_id][$affectation_data_id]['status'] = 'deleted';
		society_class::g()->update_by_type( $element );

		$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $element );
		ob_start();
		require( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
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
	public function callback_paginate_evaluator() {
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		if ( $element_id === 0 ) {
			wp_send_json_error();
		}

		$element = society_class::g()->show_by_type( $element_id );
		evaluator_class::g()->render_list_evaluator_to_assign( $element );
		wp_die();
	}

	public function callback_display_evaluator_affected( $id, $list_user_id ) {
		$element = \society_class::g()->show_by_type( $id );
		$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $element );

		if ( !empty( $list_affected_evaluator ) ) {
		  foreach ( $list_affected_evaluator as $key => $sub_list ) {
				foreach( $sub_list as $evaluator_key => $evaluator ) {
					if ( is_object( $evaluator['user_info'] ) ) {
						if ( !in_array( $evaluator['user_info']->id, $list_user_id ) ) {
							unset( $list_affected_evaluator[$key][$evaluator_key] );
						}
					}
				}
		  }
		}

		ob_start();
		require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function callback_display_evaluator_to_assign( $id, $list_user_id ) {
		$element = \society_class::g()->show_by_type( $id );

		$current_page = !empty( $_REQUEST['next_page'] ) ? (int)$_REQUEST['next_page'] : 1;
		$args_where_evaluator = array(
			'exclude' => array( 1 )
		);

		$list_evaluator_to_assign = evaluator_class::g()->get( $args_where_evaluator );
		//
		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator = count( evaluator_class::g()->get( $args_where_evaluator ) );

		$number_page = ceil( $count_evaluator / evaluator_class::g()->limit_evaluator );

			if ( !empty( $list_evaluator_to_assign ) ) {
				foreach ( $list_evaluator_to_assign as $key => $evaluator ) {
					if ( !in_array( $evaluator->id, $list_user_id ) ) {
						unset( $list_evaluator_to_assign[$key] );
					}
				}
			}

		ob_start();
		require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

	new evaluator_action();
