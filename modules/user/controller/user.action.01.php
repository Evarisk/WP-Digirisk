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
			// Quand on affecte un utilisateur
			add_action( 'admin_post_edit_user_assign', array( $this, 'callback_edit_user_assign' ) );

			// Quand on désaffecte un utilisateur
			add_action( 'admin_post_edit_user_detach', array( $this, 'callback_edit_user_detach' ) );

			// Recherche d'un utilisateur affecté
			add_action( 'wp_ajax_search_user_affected', array( $this, 'ajax_search_user_affected' ) );
		}

		public function callback_edit_user_assign() {
			// Est ce que list_user est vide ? Ou est ce que workunit_id est vide et est-ce bien un entier ?
			if ( empty( $_POST['list_user'] ) || ( empty( $_POST['workunit_id'] ) && ctype_digit( strval( $_POST['workunit_id'] ) ) )  )
				wp_safe_redirect( wp_get_referer() );

			if ( 0 === (int)$_POST['workunit_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$workunit_id = (int)$_POST['workunit_id'];

			if ( 0 === (int)$_POST['group_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$group_id = (int)$_POST['group_id'];

			if( !is_array( $_POST['list_user'] ) )
				wp_safe_redirect( wp_get_referer() );

			global $wpdigi_workunit_ctr;
			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_safe_redirect( wp_get_referer() . '&current_workunit_id=' . $workunit_id );

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

			wp_safe_redirect( wp_get_referer() . '&current_tab=user&current_group_id=' . $group_id . '&current_workunit_id=' . $workunit_id );
			exit(0);
		}

		public function callback_edit_user_detach() {
			if ( ( empty( $_GET['user_id'] ) && ctype_digit( strval( $_GET['user_id'] ) ) ) && ( empty( $_GET['workunit_id'] ) && ctype_digit( strval( $_GET['workunit_id'] ) ) ) )
				wp_safe_redirect( wp_get_referer() );

			if ( 0 === (int)$_GET['workunit_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$workunit_id = (int)$_GET['workunit_id'];

			if ( 0 === (int)$_GET['group_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$group_id = (int)$_GET['group_id'];

			if ( 0 === (int)$_GET['user_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$user_id = (int)$_GET['user_id'];

			global $wpdigi_workunit_ctr;
			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_safe_redirect( wp_get_referer() . '&current_workunit_id=' . $workunit_id );

			global $wpdigi_user_ctr;

			$index_valid_key = $wpdigi_user_ctr->get_valid_in_workunit_by_user_id( $workunit, $user_id );

			$workunit->option['user_info']['affected_id']['user'][$user_id][$index_valid_key]['status'] = 'delete';
			$workunit->option['user_info']['affected_id']['user'][$user_id][$index_valid_key]['end'] = array(
				'date'  => current_time( 'Y-m-d' ),
				'by'	=> get_current_user_id(),
				'on'	=> current_time( 'Y-m-d' ),
			);


			$wpdigi_workunit_ctr->update( $workunit );

			wp_safe_redirect( wp_get_referer() . '&current_tab=user&current_group_id=' . $group_id . '&current_workunit_id=' . $workunit_id );
			exit(0);
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
	}

	global $wpdigi_user_action;
	$wpdigi_user_action = new wpdigi_user_action_01();
}
