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
			add_action( 'wp_ajax_edit_evaluator_assign', array( $this, 'callback_edit_evaluator_assign' ) );

			// Quand on désaffecte un utilisateur
			add_action( 'wp_ajax_detach_evaluator', array( $this, 'callback_detach_evaluator' ) );
		}

		public function callback_edit_evaluator_assign() {
			// Est ce que list_user est vide ? Ou est ce que workunit_id est vide et est-ce bien un entier ?
			if ( empty( $_POST['list_user'] ) || !is_array( $_POST['list_user'] ) )
				wp_send_json_error();

			if ( 0 === (int) $_POST['element_id'] )
				wp_send_json_error();
			else {
				$element_id = (int) $_POST['element_id'];
			}

			$global = sanitize_text_field( $_POST['global'] );
			global ${$global};
			$element = ${$global}->show( $element_id );

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


					$element->option['user_info']['affected_id']['evaluator'][$user_id][] = array(
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
				${$global}->update( $element );

			global $wpdigi_evaluator_ctr;
			$list_affected_evaluator = $wpdigi_evaluator_ctr->get_list_affected_evaluator( $element );
			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			wp_send_json_success( array( 'template' => ob_get_clean() ) );
		}

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

			$global = sanitize_text_field( $_POST['global'] );
			global ${$global};
			$element = ${$global}->show( $element_id );

			if ( empty( $element ) )
				wp_send_json_error();

			global $wpdigi_user_ctr;

			$element->option['user_info']['affected_id']['evaluator'][$user_id][$affectation_data_id]['status'] = 'deleted';
			${$global}->update( $element );

			global $wpdigi_evaluator_ctr;
			$list_affected_evaluator = $wpdigi_evaluator_ctr->get_list_affected_evaluator( $element );
			ob_start();
			require( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			wp_send_json_success( array( 'template' => ob_get_clean() ) );
		}
	}

	global $wpdigi_evaluator_action;
	$wpdigi_evaluator_action = new wpdigi_evaluator_action_01();
}
