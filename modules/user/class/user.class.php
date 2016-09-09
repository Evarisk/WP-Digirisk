<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_class extends \user_class {
	protected $model_name 	= 'user_model';
	protected $meta_key		= '_wpeo_user_info';
	protected $before_post_function = array( '\digi\construct_login', '\build_user_initial', '\build_avatar_color' );
	protected $before_put_function = array( '\build_user_initial', '\build_avatar_color' );
	protected $after_get_function = array( '\digi\get_hiring_date', '\get_identifier' );

	protected $base 	= 'digirisk/user';
	protected $version 	= '0.1';
	public $limit_user = 5;

	/**
	* Le constructeur
	*/
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

	/**
	* Ajout de la date de fin pour l'utilisateur
	*
	* @param object $user L'utilisateur courant
	*/
	public function callback_user_profile( $user ) {
		$user_information = get_the_author_meta( 'digirisk_user_information_meta', $user->ID );
		$hiring_date = !empty( $user_information['digi_hiring_date'] ) ? $user_information['digi_hiring_date'] : '';

		require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'user-profile' ) );
	}

	/**
	* Met à jour la date de fin pour l'utilisateur
	*
	* @param int $user_id L'ID de l'utilisateur
	*/
	public function callback_options_update( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		update_usermeta( $user_id, 'digirisk_user_information_meta', $_POST['digirisk_user_information_meta'] );
	}

	/**
	* Affiches le rendu principal des utilisateurs
	*
	* @param object $workunit L'objet parent
	*/
	public function render( $workunit ) {
		$array = $this->list_affected_user( $workunit );
		$list_affected_user = $array['list_affected_user'];
		$list_affected_id = $array['list_affected_id'];

		$current_page = !empty( $_GET['current_page'] ) ? (int) $_GET['current_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$list_user_to_assign = $this->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->get( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		require( USERS_VIEW . '/main.php' );
	}

	/**
	* Fait le rendu de la liste des utilisateurs à assigner
	*
	* @param object $workunit L'objet
	*/
	public function render_list_user_to_assign( $workunit ) {
		$current_page = !empty( $_REQUEST['next_page'] ) ? (int) $_REQUEST['next_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$list_user_to_assign = $this->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->get( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		require( USERS_VIEW . '/list-user-to-assign.php' );
	}

	/**
	 * Récupère la liste des utilisateurs affectés avec ses informations d'affectations à cette unité de travail
	 * Get the list of affected users with assignement information for this workunit
	 *
	 * @param object $workunit L'objet unité de travail
	 * @param array $list_affected_id La liste des utilisateurs affectés
	 *
	 * @return array list users affected
	 */
	public function list_affected_user( $workunit ) {
		if ( !is_object( $workunit) ) {
			return false;
		}

		if ( $workunit->id === 0 || empty( $workunit->user_info ) || empty( $workunit->user_info['affected_id'] ) )
			return false;

		$list_affected_id = array();

		$list_user = array();
		if ( !empty( $workunit->user_info['affected_id']['user'] ) ) {
			foreach ( $workunit->user_info['affected_id']['user'] as $user_id => $sub_value ) {
				if ( !empty( $sub_value ) ) {
					foreach( $sub_value as $array_value ) {
						if ( !empty( $array_value['status'] ) && $array_value['status'] == 'valid' ) {
							$user = $this->get( array( 'id' => $user_id ) );
							$list_user[$user_id] = $user[0];
							$list_user[$user_id]->date_info = $array_value;
							$list_user[$user_id]->date_info['last_entry'] = count( $array_value ) - 1;
							$list_affected_id[] = $user_id;
						}
					}
				}
			}
		}

		return array(
			'list_affected_user' => $list_user,
			'list_affected_id' => $list_affected_id,
		);
	}


	/**
	 * Construction de la liste des utilisateurs avec leurs informations d'affectation pour l'export d'un document / Build a user list with their informations about affectation for document export
	 *
	 * @param array $users La liste des utilisateurs que l'on doit lire et ordonner pour l'impression dans les documents / Users' list to read and format for export into document
	 *
	 * @return array si aucun utilisateur n'a été spécifié | Un tableau contenant les utilisateurs actuellement affectés ou ayant été affectés auparavant / null if no user have been specified | An array with affected users or users who have been affected
	 */
	public function build_list_for_document_export( $users ) {
		if ( !is_array( $users ) ) {
			return false;
		}

		$affected_users = $unaffected_users = null;
		if ( !empty( $users ) ) {
			foreach ( $users as $user_id => $user_affectations ) {
				$the_user = $this->get( array( 'id' => $user_id ) );
				$the_user = $the_user[0];
				foreach ( $user_affectations as $user ) {
					if ( !empty( $user[ 'status' ] ) && ( 'valid' == $user[ 'status' ] ) )  {
						$affected_users[] = array(
								'idUtilisateur'								=> $this->element_prefix . $user_id,
								'nomUtilisateur'							=> $the_user->lastname,
								'prenomUtilisateur'						=> $the_user->firstname,
								'dateAffectationUtilisateur'	=> mysql2date( 'd/m/Y H:i', $user[ 'start' ][ 'date' ], true ),
						);
					}
					else {
						$unaffected_users[] = array(
								'idUtilisateur'									=> $this->element_prefix . $user_id,
								'nomUtilisateur'								=> $the_user->lastname,
								'prenomUtilisateur'							=> $the_user->firstname,
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

	/**
	* Ajoutes un utilisateur
	*
	* @param array $data Les données à enregistrer
	*
	* @return bool
	*/
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

	/**
	* Renvoie l'utilisateur ayant le status "valid" selon $user_id
	*
	* @param object $workunit L'objet
	* @param int $user_id L'ID de l'utilisateur a chercher
	*
	* @return int La clé de l'utilisateur
	*/
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
}
