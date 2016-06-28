<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des utilisateurs / Main controller file for users management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour la gestion des utilisateurs / Main controller class for users management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

if ( !class_exists( 'wpdigi_user_action_01' ) ) {
	class wpdigi_user_action_01 {
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_assets' ) );
			// Quand on affecte un utilisateur
			add_action( 'wp_ajax_edit_user_assign', array( $this, 'callback_edit_user_assign' ) );

			// Quand on désaffecte un utilisateur
			add_action( 'wp_ajax_detach_user', array( $this, 'callback_detach_user' ) );

			add_action( 'wp_ajax_paginate_user', array( $this, 'callback_paginate_user' ) );

			// Recherche d'un utilisateur affecté
			add_action( 'wp_ajax_search_user_affected', array( $this, 'ajax_search_user_affected' ) );
		}

		public function admin_assets() {
			wp_enqueue_script( 'wpdigi-user-backend-js', WPDIGI_USERS_URL . 'assets/js/backend.js', array( 'jquery' ), WPDIGI_VERSION, false );
		}

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

			global $wpdigi_workunit_ctr;
			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );


			if ( empty( $workunit ) )
				wp_send_json_error();

			foreach ( $_POST['list_user'] as $user_id => $list_value ) {
				if ( !empty( $list_value['affect'] ) ) {
					$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
					$workunit->option['user_info']['affected_id']['user'][$user_id][] = array(
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
				}
			}

			// On met à jour si au moins un utilisateur à été affecté
			if( count( $_POST['list_user'] ) > 0 )
				$wpdigi_workunit_ctr->update( $workunit );

			global $wpdigi_user_ctr;
			$list_affected_user = $wpdigi_user_ctr->list_affected_user( $workunit, $list_affected_id );
			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			$template = ob_get_clean();

			$current_page = !empty( $_REQUEST['current_page'] ) ? (int) $_REQUEST['current_page'] : 1;
			$args_where_user = array(
				'offset' => ( $current_page - 1 ) * $this->limit_user,
				'number' => $wpdigi_user_ctr->limit_user,
				'exclude' => array( 1 ),
				'meta_query' => array(
					'relation' => 'OR',
				),
			);
			$list_user_to_assign = $wpdigi_user_ctr->index( $args_where_user );

			// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
			unset( $args_where_user['offset'] );
			unset( $args_where_user['number'] );
			$args_where_user['fields'] = array( 'ID' );
			$count_user = count( $wpdigi_user_ctr->index( $args_where_user ) );
			$number_page = ceil( $count_user / $wpdigi_user_ctr->limit_user );

			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) );
			wp_send_json_success( array( 'template' => $template, 'template_form' => ob_get_clean() ) );
		}

		public function callback_detach_user() {
			$workunit_id = !empty( $_POST['workunit_id'] ) ? (int) $_POST['workunit_id'] : 0;
			$user_id = !empty( $_POST['user_id'] ) ? (int) $_POST['user_id'] : 0;

			global $wpdigi_workunit_ctr;
			global $wpdigi_user_ctr;

			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );
			$index_valid_key = $wpdigi_user_ctr->get_valid_in_workunit_by_user_id( $workunit, $user_id );

			$workunit->option['user_info']['affected_id']['user'][$user_id][$index_valid_key]['status'] = 'delete';
			$workunit->option['user_info']['affected_id']['user'][$user_id][$index_valid_key]['end'] = array(
				'date'  => current_time( 'Y-m-d' ),
				'by'	=> get_current_user_id(),
				'on'	=> current_time( 'Y-m-d' ),
			);


			$wpdigi_workunit_ctr->update( $workunit );

			global $wpdigi_user_ctr;
			$list_affected_user = $wpdigi_user_ctr->list_affected_user( $workunit, $list_affected_id );
			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			$template = ob_get_clean();

			$current_page = !empty( $_REQUEST['current_page'] ) ? (int) $_REQUEST['current_page'] : 1;
			$args_where_user = array(
				'offset' => ( $current_page - 1 ) * $this->limit_user,
				'number' => $wpdigi_user_ctr->limit_user,
				'exclude' => array( 1 ),
				'meta_query' => array(
					'relation' => 'OR',
				),
			);
			$list_user_to_assign = $wpdigi_user_ctr->index( $args_where_user );

			// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
			unset( $args_where_user['offset'] );
			unset( $args_where_user['number'] );
			$args_where_user['fields'] = array( 'ID' );
			$count_user = count( $wpdigi_user_ctr->index( $args_where_user ) );
			$number_page = ceil( $count_user / $wpdigi_user_ctr->limit_user );

			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) );
			wp_send_json_success( array( 'template' => $template, 'template_form' => ob_get_clean() ) );
		}

		public function ajax_search_user_affected() {
			wpdigi_utils::check( 'ajax_search_user_affected' );

			global $wpdb;
			$user_name_affected = sanitize_text_field( $_POST['user_name_affected'] );

			$keyword = '%' . $user_name_affected . '%';

			$query = "SELECT u.ID FROM {$wpdb->users} as u
								WHERE u.user_email LIKE %s";

			$list_user_result = $wpdb->get_results( $wpdb->prepare( $query, array( $keyword ) ), 'ARRAY_N' );
			$list_user_result = array_map( 'current', $list_user_result );


			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			wp_send_json_success( array( 'template' => ob_get_clean() ) );
		}

		public function callback_paginate_user() {
			$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

			if ( $element_id === 0 ) {
				wp_send_json_error();
			}

			global $wpdigi_workunit_ctr;
			global $wpdigi_user_ctr;

			$element = $wpdigi_workunit_ctr->show( $element_id );
			$wpdigi_user_ctr->render_list( $element );
			wp_die();
		}
	}

	global $wpdigi_user_action;
	$wpdigi_user_action = new wpdigi_user_action_01();
}
