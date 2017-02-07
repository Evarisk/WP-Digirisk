<?php
/**
 * Classe gérant les utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les utilisateurs
 */
class User_Digi_Class extends User_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name 	= '\digi\user_digi_model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key		= '_wpeo_user_info';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans le script PHP
	 *
	 * @var array
	 */
	protected $before_model_post_function = array( '\digi\construct_login', '\digi\generate_password' );

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\build_user_initial', '\digi\build_avatar_color' );

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\build_user_initial' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_hiring_date', '\digi\get_identifier', '\digi\force_avatar_color' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base 	= 'digirisk/user';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version 	= '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'U';

	/**
	 * La limite des utilisateurs a affiché par page
	 *
	 * @var integer
	 */
	public $limit_user = 5;

	/**
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	protected function construct() {
		// Ajout de 4 actions pour ajouter des champs dans la partie utilisateur de WordPress.
		add_action( 'show_user_profile', array( $this, 'callback_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'callback_user_profile' ) );
		add_action( 'personal_options_update', array( $this, 'callback_options_update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'callback_options_update' ) );
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Ajout de la date de fin pour l'utilisateur
	 *
	 * @param object $user L'utilisateur courant.
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_user_profile( $user ) {
		$user_information = get_the_author_meta( 'digirisk_user_information_meta', $user->ID );
		$hiring_date = ! empty( $user_information['digi_hiring_date'] ) ? $user_information['digi_hiring_date'] : '';

		require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'user-profile' ) );
	}

	/**
	 * Met à jour la date de fin pour l'utilisateur
	 *
	 * @param int $user_id L'ID de l'utilisateur.
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function callback_options_update( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		update_usermeta( $user_id, 'digirisk_user_information_meta', $_POST['digirisk_user_information_meta'] );
	}

	/**
	 * Affiches le rendu principal des utilisateurs
	 *
	 * @param object  $workunit L'objet parent.
	 * @param integer $current_page La page courant.
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function render( $workunit, $current_page = 1 ) {
		$array = $this->list_affected_user( $workunit );
		$list_affected_user = $array['list_affected_user'];
		$list_affected_id = $array['list_affected_id'];

		$current_page = ! empty( $_GET['next_page'] ) ? (int) $_GET['next_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$list_user_to_assign = $this->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->get( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		view_util::exec( 'user', 'main', array( 'current_page' => $current_page, 'list_affected_user' => $list_affected_user, 'list_affected_id' => $list_affected_id, 'list_user_to_assign' => $list_user_to_assign, 'number_page' => $number_page, 'workunit' => $workunit ) );
	}

	/**
	 * Fait le rendu de la liste des utilisateurs à assigner
	 *
	 * @param object $workunit L'objet.
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function render_list_user_to_assign( $workunit ) {
		$current_page = ! empty( $_REQUEST['next_page'] ) ? (int) $_REQUEST['next_page'] : 1;
		$args_where_user = array(
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
			'exclude' => array( 1 ),
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$array = $this->list_affected_user( $workunit );
		$list_affected_id = $array['list_affected_id'];

		$list_user_to_assign = $this->get( $args_where_user );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_user['offset'] );
		unset( $args_where_user['number'] );
		$args_where_user['fields'] = array( 'ID' );
		$count_user = count( $this->get( $args_where_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		view_util::exec( 'user', 'list-user-to-assign', array( 'workunit' => $workunit, 'current_page' => $current_page, 'number_page' => $number_page, 'users' => $list_user_to_assign, 'list_affected_id' => $list_affected_id ) );
	}

	/**
	 * Récupère la liste des utilisateurs affectés avec ses informations d'affectations à cette unité de travail
	 * Get the list of affected users with assignement information for this workunit
	 *
	 * @param object $workunit L'objet unité de travail.
	 *
	 * @return array list users affected
	 *
	 * @since 0.1
	 * @version 6.2.4.0
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
	 * @param array $users La liste des utilisateurs que l'on doit lire et ordonner pour l'impression dans les documents / Users' list to read and format for export into document.
	 *
	 * @return array si aucun utilisateur n'a été spécifié | Un tableau contenant les utilisateurs actuellement affectés ou ayant été affectés auparavant / null if no user have been specified | An array with affected users or users who have been affected
	 *
	 * @since 0.1
	 * @version 6.2.4.0
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
				'affected'		=> ! empty( $affected_users ) ? $affected_users : array(),
				'unaffected'	=> ! empty( $unaffected_users ) ? $unaffected_users : array(),
			);
		}

		return null;
	}

	/**
	 * Ajoutes un utilisateur
	 *
	 * @param array $data Les données à enregistrer.
	 *
	 * @return bool
	 *
	 * @since 0.1
	 * @version 6.2.4.0
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
	 * @param object $workunit L'objet.
	 * @param int    $user_id L'ID de l'utilisateur a chercher.
	 *
	 * @return bool|int La clé de l'utilisateur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function get_valid_in_workunit_by_user_id( $workunit, $user_id ) {

		if ( 0 === $workunit->id || empty( $workunit->user_info ) || empty( $workunit->user_info['affected_id'] ) ||
				empty( $workunit->user_info['affected_id']['user'] ) || ( empty( $user_id ) &&
				ctype_digit( strval( $user_id ) ) ) || empty( $workunit->user_info['affected_id']['user'][ $user_id ] ) ) {
			return false;
		}

		$index_valid_key = -1;
		foreach ( $workunit->user_info['affected_id']['user'] [ $user_id ] as $key => $affected_user ) {
			if ( 'valid' === $affected_user['status'] ) {
				$index_valid_key = $key;
				break;
			}
		}
		if ( -1 === $index_valid_key ) {
			return false;
		}

		return $index_valid_key;
	}
}
