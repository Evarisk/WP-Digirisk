<?php
namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class TransferData_task_class extends singleton_util {

	protected function construct() { }

	function transfer( $element, $element_type, $element_id ) {
		/**	Transfert follow up of tasks	*/
		$this->transfer_follow_up( $element->id, $element_type, $element_id );

		/**	Build the array that will be stored into database	*/
		$task_planning = array(
			'estimate_start_date'	=> $element->dateDebut,
			'estimate_end_date' 	=> $element->dateFin,
			'planned_time' 			=> $element->planned_time,
			'real_start_date' 		=> $element->real_start_date,
			'real_end_date' 		=> $element->real_end_date,
			'elapsed_time' 			=> $element->elapsed_time,
		);
		switch ( $element_type ) {
			case TABLE_TACHE:
				$task_planning[ 'estimate_cost' ] = $element->estimate_cost;
				$task_planning[ 'real_cost' ] = $element->real_cost;

				/**	Transfer link between tasks and other elements	*/
				$this->transfer_link_between_tasks_and_element( $element->id, $element_type, $element_id );
				break;
			case TABLE_ACTIVITE:
				$task_planning[ 'estimate_cost' ] = $element->cout;
				$task_planning[ 'real_cost' ] = $element->cout_reel;
				break;
		}
		update_post_meta( $element_id, '_wpeomtm_task_planning', $task_planning );
		/**	When done remove all entries already saved from old element in order to save it later	*/
		foreach ( $task_planning as $field => $value ) {
			unset( $element->$field );
		}

		/**	Set task manager	*/
		update_post_meta( $element_id, '_wpeo_manager_id', $element->idResponsable );

		/**	Set task progression information	*/
		$advancement_status = $element->ProgressionStatus;
		wp_set_object_terms( $element_id, $advancement_status, 'wpeotasks-status-internal' );
		$task_progression = array(
			'advancement'			=> $element->avancement,
			'ended_date'			=> $element->dateSolde,
			'ended_user'			=> $element->idSoldeur,
			'ended_chief_user'		=> $element->idSoldeurChef,
		);
		update_post_meta( $element_id, '_wpeo_task_status', $task_progression );
		/**	When done remove all entries already saved from old element in order to save it later	*/
		foreach ( $task_progression as $field => $value ) {
			unset( $element->$field );
		}
	}

	function transfer_follow_up( $old_element_id, $old_element_type, $new_element_id ) {
		/**	Get existing folow up for given element	*/
		$follow_up_types = array( 'note', 'follow_up' );
		foreach ( $follow_up_types as $follow_up_type ) {
			$follow_up_list = getSuiviActivite( $old_element_type, $old_element_id, $follow_up_type );
			if ( !empty( $follow_up_list ) ) {
				foreach ( $follow_up_list as $follow_up ) {

					$idUser = ( 0 == $follow_up->id_user ) ? 1 : $follow_up->id_user;
					if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idUser ] ) ) {
						$idUser = (int)$_POST[ 'wp_new_user' ][ $idUser ];
					}
					$user_infos = get_userdata( $idUser );

					$data = array(
							'comment_post_ID' => $new_element_id,
							'comment_author' => $user_infos->display_name,
							'comment_author_email' => $user_infos->user_email,
							'comment_author_url' => $user_infos->user_url,
							'comment_content' => $follow_up->commentaire,
							'comment_type' => $follow_up->follow_up_type,
							'comment_parent' => 0,
							'user_id' => $idUser,
							'comment_author_IP' => '',
							'comment_agent' => '',
							'comment_date' => $follow_up->date_ajout,
							'comment_approved' => -1,
					);
					$comment_id = wp_insert_comment( $data );

					/**
					 * Create metadatas for new created comment
					*/
					/**	Store old follow up identifier	*/
					update_comment_meta( $comment_id, "_wpeo_comment_old_id", $follow_up->id );
					/**	Get current export status for the comment	*/
					update_comment_meta( $comment_id, "_wpeo_comment_exportable", $follow_up->export );
					$idUserPerformer = ( 0 == $follow_up->id_user_performer ) ? 1 : $follow_up->id_user_performer;
					if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idUserPerformer ] ) ) {
						$idUserPerformer = (int)$_POST[ 'wp_new_user' ][ $idUserPerformer ];
					}
					/**	Get current informations about tasks performer and task elapsed time	*/
					update_comment_meta( $comment_id, "_wpeo_comment_perform_infos", array(
					"performer_id" => $idUserPerformer,
					"perform_date" => $follow_up->date,
					"elapsed_time" => $follow_up->elapsed_time,
					"cost" => $follow_up->cost,
					) );
				}
			}
		}
	}

	function transfer_link_between_tasks_and_element( $old_element_id, $old_element_type, $new_element_id ) {
		global $wpdb;

		/**	Get lined element with current task	*/
		$query = $wpdb->prepare( "SELECT * FROM " . TABLE_LIAISON_TACHE_ELEMENT . " WHERE id_tache = %d ORDER BY id_tache, date", $old_element_id );
		$existing_links = $wpdb->get_results( $query );

		if ( !empty( $existing_links ) ) {
			$links = array();
			foreach ( $existing_links as $link ) {
				$links[] = array(
					$link->table_element,
					$link->id_element,
					$link->date,
					$link->wasLinked,
				);
			}

			if ( !empty( $links ) ) {
				update_post_meta( $new_element_id, '_wpeo_element_links', $links );
			}
			else {
				log_class::g()->exec( 'digirisk-datas-transfert-' . $old_element_type , '', sprintf( __( 'Element linked to this %s have not been transfered to %d', 'wp-digi-dtrans-i18n' ), $old_element_type, $new_element_id ), array( 'object_id' => $old_element_id, ), 2 );
			}
		}

	}

}

TransferData_task_class::g();
