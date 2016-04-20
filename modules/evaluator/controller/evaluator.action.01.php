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

if ( !class_exists( 'wpdigi_evaluator_action_01' ) ) {
	class wpdigi_evaluator_action_01 {
		public function __construct() {
			// Quand on affecte un utilisateur
			add_action( 'admin_post_edit_evaluator_assign', array( $this, 'callback_edit_evaluator_assign' ) );

			// Quand on désaffecte un utilisateur
			add_action( 'admin_post_edit_evaluator_detach', array( $this, 'callback_edit_evaluator_detach' ) );
		}

		public function callback_edit_evaluator_assign() {
			// Est ce que list_user est vide ? Ou est ce que workunit_id est vide et est-ce bien un entier ?
			if ( empty( $_POST['list_user'] ) || !is_array( $_POST['list_user'] ) )
				wp_safe_redirect( wp_get_referer() );

			if ( 0 === (int) $_POST['workunit_id'] )
				wp_safe_redirect( wp_get_referer() );
			else {
				$workunit_id = (int) $_POST['workunit_id'];
			}

			if ( 0 === (int) $_POST['group_id'] )
				wp_safe_redirect( wp_get_referer() );
			else {
				$group_id = (int) $_POST['group_id'];
			}

			global $wpdigi_workunit_ctr;
			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_safe_redirect( wp_get_referer() );

			foreach ( $_POST['list_user'] as $user_id => $list_value ) {
				if ( !empty( $list_value['duration'] ) && !empty( $list_value['affect'] ) ) {
					$list_value['on'] = str_replace( '/', '-', $list_value['on'] );
					$list_value['on'] = date( 'y-m-d', strtotime( $list_value['on'] ) );
					$list_value['on'] .= ' ' . current_time( 'H:i:s' );
					$list_value['on'] = sanitize_text_field( $list_value['on'] );

					$end_date = new DateTime( $list_value['on'] );
					$end_date->add( new DateInterval( 'PT' . $list_value['duration'] . 'M' ) );


					$workunit->option['user_info']['affected_id']['evaluator'][$user_id][] = array(
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
				$wpdigi_workunit_ctr->update( $workunit );

			wp_safe_redirect( wp_get_referer() . '&current_tab=evaluator&current_group_id=' . $group_id . '&current_workunit_id=' . $workunit_id );
			exit(0);
		}

		public function callback_edit_evaluator_detach() {
			if ( 0 === (int) $_GET['workunit_id'] )
				wp_safe_redirect( wp_get_referer() );
			else {
				$workunit_id = (int) $_GET['workunit_id'];
			}

			if ( 0 === (int) $_GET['group_id'] )
				wp_safe_redirect( wp_get_referer() );
			else {
				$group_id = (int) $_GET['group_id'];
			}

			if ( !isset( $_GET['affectation_data_id'] ) )
				wp_safe_redirect( wp_get_referer() );
			else {
				$affectation_data_id = (int) $_GET['affectation_data_id'];
			}

			if ( 0 === (int) $_GET['user_id'] )
				wp_safe_redirect( wp_get_referer() );
			else {
				$user_id = (int) $_GET['user_id'];
			}

			global $wpdigi_workunit_ctr;
			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_safe_redirect( wp_get_referer() );

			global $wpdigi_user_ctr;

			$workunit->option['user_info']['affected_id']['evaluator'][$user_id][$affectation_data_id]['status'] = 'deleted';
			$wpdigi_workunit_ctr->update( $workunit );

			wp_safe_redirect( wp_get_referer() . '&current_tab=evaluator&current_group_id=' . $group_id . '&current_workunit_id=' . $workunit_id );
			exit(0);
		}
	}

	global $wpdigi_evaluator_action;
	$wpdigi_evaluator_action = new wpdigi_evaluator_action_01();
}
