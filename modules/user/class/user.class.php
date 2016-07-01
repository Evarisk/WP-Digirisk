<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_class extends \user_class {
	protected $model_name 	= '\wpdigi_user_mdl_01';
	protected $meta_key		= '_wpeo_user_info';

	protected $base 	= 'digirisk/user';
	protected $version 	= '0.1';
	public $limit_user = 5;

	protected function construct() {
		/** Pour la recherche */
		add_filter( 'wpdigi_search_user_affected', array( $this, 'callback_wpdigi_search_user_affected' ), 10, 3 );
		add_filter( 'wpdigi_search_user_to_assign', array( $this, 'callback_wpdigi_search_user_to_assign' ), 10, 4 );

		// Ajout de 4 actions pour ajouter des champs dans la partie utilisateur de WordPres
		add_action( 'show_user_profile', array( $this, 'callback_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'callback_user_profile' ) );
		add_action( 'personal_options_update', array( $this, 'callback_options_update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'callback_options_update' ) );

	}

	public function callback_user_profile( $user ) {
		$user_information = get_the_author_meta( 'digirisk_user_information_meta', $user->ID );
		$hiring_date = !empty( $user_information['digi_hiring_date'] ) ? $user_information['digi_hiring_date'] : '';

		require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'user-profile' ) );
	}

	public function callback_options_update( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		update_usermeta( $user_id, 'digirisk_user_information_meta', $_POST['digirisk_user_information_meta'] );
	}

	public function render( $workunit ) {
		$list_affected_user = $this->list_affected_user( $workunit, $list_affected_id );

		$current_page = !empty( $_GET['current_page'] ) ? (int) $_GET['current_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$list_user_to_assign = $this->index( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->index( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		require( USERS_VIEW . '/main.php' );
	}

	public function render_list( $workunit ) {
		$list_affected_user = $this->list_affected_user( $workunit, $list_affected_id );

		$current_page = !empty( $_REQUEST['next_page'] ) ? (int) $_REQUEST['next_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$list_user_to_assign = $this->index( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->index( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		require( USERS_VIEW . '/list-user-to-assign.php' );
	}

	/**
	 * Récupère la liste des utilisateurs affectés avec ses informations d'affectations à cette unité de travail
	 * Get the list of affected users with assignement information for this workunit
	 *
	 * @param int $id The workunit ID
	 * @return JSON list users affected
	 */
	public function list_affected_user( $workunit, &$list_affected_id ) {
		if ( $workunit->id === 0 || empty( $workunit->option['user_info'] ) || empty( $workunit->option['user_info']['affected_id'] ) )
			return false;

		$list_user = array();
		if ( !empty( $workunit->option['user_info']['affected_id']['user'] ) ) {
			foreach ( $workunit->option['user_info']['affected_id']['user'] as $user_id => $sub_value ) {
				if ( !empty( $sub_value ) ) {
					foreach( $sub_value as $array_value ) {
						if ( !empty( $array_value['status'] ) && $array_value['status'] == 'valid' ) {
							$list_user[$user_id] = $this->show( $user_id );
							$list_user[$user_id]->option['date_info'] = $array_value;
							$list_user[$user_id]->option['date_info']['last_entry'] = count( $array_value ) - 1;
							$list_affected_id[] = $user_id;
						}
					}
				}
			}
		}

		return $list_user;
	}

	public function callback_wpdigi_search_user_affected( $string, $workunit_id, $list_id ) {
		global $wpdigi_user_ctr;
		global $wpdigi_workunit_ctr;

		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		if ( empty( $workunit ) )
			wp_send_json_error();

		$list_affected_user = array();
		if ( !empty( $workunit->option['user_info']['affected_id']['user'] ) ) {
			foreach ( $workunit->option['user_info']['affected_id']['user'] as $user_id => $sub_value ) {
				if ( !empty( $sub_value ) && in_array( $user_id, $list_id ) ) {
					foreach( $sub_value as $array_value ) {
						if ( !empty( $array_value['status'] ) && $array_value['status'] == 'valid' ) {
							$list_affected_user[$user_id] = $wpdigi_user_ctr->show( $user_id );
							$list_affected_user[$user_id]->option['date_info'] = $array_value;
							$list_affected_user[$user_id]->option['date_info']['last_entry'] = count( $array_value ) - 1;
						}
					}
				}
			}
		}

		ob_start();
		require( USERS_VIEW . '/list-affected-user.php' );
		$string .= ob_get_clean();
		return $string;
	}

	public function callback_wpdigi_search_user_to_assign( $string, $workunit_id, $list_id, $term ) {
		global $wpdigi_user_ctr;
		global $wpdigi_workunit_ctr;

		$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

		if ( empty( $workunit ) )
			wp_send_json_error();

		if ( !empty( $term ) ) {
			$list_user_to_assign = array();

			if ( !empty( $list_id ) ) {
				foreach ( $list_id as $user_id ) {
					if ( $user_id != 1 )
						$list_user_to_assign[] = $wpdigi_user_ctr->show( $user_id );
				}
			}
		}
		else {
			$current_page = 1;
			$args_where_user = array(
				'offset' => 0,
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
		}

		ob_start();
		require( USERS_VIEW . '/list-user-to-assign.php' );
		$string .= ob_get_clean();
		return $string;
	}

	public function get_valid_in_workunit_by_user_id( $workunit, $user_id ) {
		global $wpdigi_user_ctr;

		// Si $workunit->id est égale à 0 ou si $workunit->option['user_info'] est vide ou si $workunit->option['user_info']['affected_id'] est vide ou si $user_id est vide et n'est pas un entier ou si $workunit->option['user_info']['affected_id'][$user_id] est vide
		if ( $workunit->id === 0 || empty( $workunit->option['user_info'] ) || empty( $workunit->option['user_info']['affected_id'] ) || empty( $workunit->option['user_info']['affected_id']['user'] ) || ( empty( $user_id ) && ctype_digit( strval( $user_id ) ) ) || empty( $workunit->option['user_info']['affected_id']['user'][$user_id] ) )
			return false;

		$index_valid_key = -1;

		foreach ( $workunit->option['user_info']['affected_id']['user'][$user_id] as $key => $affected_user ) {
			if( $affected_user['status'] == 'valid' ) {
				$index_valid_key = $key;

				break;
			}
		}

		if ( $index_valid_key == -1 )
			return false;

		return $index_valid_key;
	}

	public function get_user_is_assigned_in_workunit_by_user_id( $workunit, $user_id ) {
		// Si cette méthode retourne false, c'est que aucune affectation à été déclaré, donc cette utilisateur n'est pas assigné.
// 			$index_last_entry = $this->get_index_of_last_date_user_in_workunit_by_user_id( $workunit, $user_id );

// 			if ( $index_last_entry === false )
// 				return false;

// 			if ( empty ( $workunit->option['user_info']['affected_id']['user'][$user_id][$index_last_entry]['end'] ) || empty( $workunit->option['user_info']['affected_id']['user'][$user_id][$index_last_entry]['end']['date'] ) )
// 				return true;

// 			if ( $workunit->option['user_info']['affected_id']['user'][$user_id][$index_last_entry]['end']['date'] != '0000-00-00 00:00:00' )
// 				return false;

		return true;
	}

	/**
	 * Construction de la liste des utilisateurs avec leurs informations d'affectation pour l'export d'un document / Build a user list with their informations about affectation for document export
	 *
	 * @param array $users La liste des utilisateurs que l'on doit lire et ordonner pour l'impression dans les documents / Users' list to read and format for export into document
	 *
	 * @return null|array null si aucun utilisateur n'a été spécifié | Un tableau contenant les utilisateurs actuellement affectés ou ayant été affectés auparavant / null if no user have been specified | An array with affected users or users who have been affected
	 */
	public function build_list_for_document_export( $users ) {
		$affected_users = $unaffected_users = null;
		if ( !empty( $users ) ) {
			foreach ( $users as $user_id => $user_affectations ) {
				$the_user = $this->show( $user_id );
				foreach ( $user_affectations as $user ) {
					if ( !empty( $user[ 'status' ] ) && ( 'valid' == $user[ 'status' ] ) )  {
						$affected_users[] = array(
								'idUtilisateur'								=> $this->element_prefix . $user_id,
								'nomUtilisateur'							=> $the_user->option[ 'user_info' ][ 'lastname' ],
								'prenomUtilisateur'						=> $the_user->option[ 'user_info' ][ 'firstname' ],
								'dateAffectationUtilisateur'	=> mysql2date( 'd/m/Y H:i', $user[ 'start' ][ 'date' ], true ),
						);
					}
					else {
						$unaffected_users[] = array(
								'idUtilisateur'									=> $this->element_prefix . $user_id,
								'nomUtilisateur'								=> $the_user->option[ 'user_info' ][ 'lastname' ],
								'prenomUtilisateur'							=> $the_user->option[ 'user_info' ][ 'firstname' ],
								'dateAffectationUtilisateur'		=> mysql2date( 'd/m/Y H:i', $user[ 'start' ][ 'date' ], true ),
								'dateDesaffectationUtilisateur' => mysql2date( 'd/m/Y H:i', $user[ 'end' ][ 'date' ], true ),
						);
					}
				}
			}

			return array(
				'affected'		=> $affected_users,
				'unaffected'	=> $unaffected_users,
			);
		}

		return null;
	}

	public function open_csv( $path ) {
		$file_handle = fopen( $path, 'r' );
		$csv_content = array();

		while ( !feof( $file_handle ) ) {
			$tmp_content = fgetcsv( $file_handle, 1024, ";", '"' );
			unset( $tmp_content[19] );
			$csv_content[] = $tmp_content;
		}

		array_shift( $csv_content );

		if ( !empty( $csv_content ) ) {
			foreach( $csv_content as $line ) {
				$this->add_user( $line );
			}
		}



		fclose( $file_handle );
	}

	public function add_user( $data ) {
		if ( empty( $data[0] ) && empty( $data[3] ) )
			return false;

		$user = array(
			'login' => sanitize_text_field( $data[2] ),
			'email' => sanitize_email( $data[3] ),
			'option' => array(),
		);

		$user['option']['user_info']['firstname'] = !empty( $data[0] ) ? sanitize_text_field( $data[0] ) : '';
		$user['option']['user_info']['lastname'] = !empty( $data[1] ) ? sanitize_text_field( $data[1] ) : '';
		$user['option']['user_info']['social_security_number'] = !empty( $data[6] ) ? sanitize_text_field( $data[6] ) : '';
		$user['option']['user_info']['birthday'] = !empty( $data[7] ) ? sanitize_text_field( $data[7] ) : '';
		$user['option']['user_info']['sexe'] = !empty( $data[8] ) ? sanitize_text_field( $data[8] ) : '';
		$user['option']['user_info']['nationality'] = !empty( $data[9] ) ? sanitize_text_field( $data[9] ) : '';
		$user['option']['user_info']['hiring_date'] = !empty( $data[14] ) ? sanitize_text_field( $data[14] ) : '';
		$user['option']['user_info']['job'] = !empty( $data[15] ) ? sanitize_text_field( $data[15] ) : '';
		$user['option']['user_info']['professional_qualification'] = !empty( $data[16] ) ? sanitize_text_field( $data[16] ) : '';
		$user['option']['user_info']['insurance_compagny'] = !empty( $data[17] ) ? sanitize_text_field( $data[17] ) : '';
		$user['option']['user_info']['release_date_of_society'] = !empty( $data[18] ) ? sanitize_text_field( $data[18] ) : '';

		$user = $this->create( $user );

		$address = array();
		$address['address'] = !empty( $data[10] ) ? sanitize_text_field( $data[10] ) : '';
		$address['additional_address'] = !empty( $data[11] ) ? sanitize_text_field( $data[11] ) : '';
		$address['postcode'] = !empty( $data[12] ) ? (int)$data[12] : '';
		$address['town'] = !empty( $data[13] ) ? sanitize_text_field( $data[13] ) : '';
		$address['post_id'] = $user->id;

		global $wpdigi_address_ctr;
		$address = $wpdigi_address_ctr->create( $address );

		$user->option['user_info']['address_id'][] = $address->id;
		$this->update( $user );

		return true;
	}
}
