<?php
/**
 * La classe gérant les plans de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.4.0
 * @version   7.4.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les causeries
 */
class Prevention_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Prevention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-prevention';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'prevention';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_prevention';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'PP_';


	public function add_signature( $prevention, $user_id, $signature_data, $is_former = false ) {
		$upload_dir = wp_upload_dir();

		// Association de la signature.
		if ( ! empty( $signature_data ) ) {
			$encoded_image = explode( ',', $signature_data )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $prevention->data['id'] );

			if ( $is_former ) {
				$prevention->data['former']['signature_id']   = $file_id;
				$prevention->data['former']['signature_date'] = current_time( 'mysql' );
			} else {
				$prevention->data['participants'][ $user_id ]['signature_id']   = $file_id;
				$prevention->data['participants'][ $user_id ]['signature_date'] = current_time( 'mysql' );
			}
		}

		return $prevention;
	}

	public function step_maitreoeuvre( $prevention ) {

		// $prevention = $this->add_participant( $prevention, $former_id, true );
		$mo_phone      = ! empty( $_POST['maitre-oeuvre-phone'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-phone'] ) : '';
		$update = ! empty( $_POST['update'] ) ? false : true;

		$prevention->data['step'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_INFORMATION;

		if( $mo_phone != "" && $update ){
			$mo_phone_code = $mo_phone_code != "" ? '(' . $mo_phone_code . ')' : '';
			$prevention->data[ 'maitre_oeuvre' ][ 'phone' ] = $mo_phone_code . $mo_phone;

			if( $prevention->data[ 'maitre_oeuvre'][ 'user_id' ] ){

				$user_information = get_the_author_meta( 'digirisk_user_information_meta', $prevention->data[ 'maitre_oeuvre'][ 'user_id' ] );
				$user_information = ! empty( $user_information ) ? $user_information : array();
				$user_information[ 'digi_phone_number' ] = $mo_phone;
				$user_information[ 'digi_phone_number_full' ] = $mo_phone_code . $mo_phone;

				update_user_meta( $prevention->data[ 'maitre_oeuvre'][ 'user_id' ], 'digirisk_user_information_meta', $user_information );
			}
		}

		return Prevention_Class::g()->update( $prevention->data );
	}

	// public function all_user_in_prevention_id( $id ){
	// 	$users_clean = array();
	//
	// 	$users = User_Class::g()->get();
	//
	// 	foreach( $users as $key => $user ){
	// 		if( $user->data[ 'prevention_parent' ] == $id ){
	// 			array_push( $users_clean, $users[ $key ] );
	// 		}
	// 	}
	//
	// 	return $users_clean;
	// }

	public function get_link( $prevention, $step_number, $skip = false ) {
		return admin_url( 'admin-post.php?action=change_step_prevention&id=' . $prevention->data['id'] . '&step=' . $step_number );
	}

	public function update_information_prevention( $prevention, $data = array() ){
		if( ! isset( $data[ 'title' ] ) || $data[ 'title' ] == '' ){
			$data[ 'title' ] = esc_html__( 'Aucun titre', 'digirisk' );
		}

		if( ! isset( $data[ 'date_start' ] ) || $data[ 'date_start' ] == '' ){
			$data[ 'date_start' ] = date( 'Y-m-d', strtotime( 'now' ) );
		}

		if( strtotime( $data[ 'date_start' ] ) > strtotime( $data[ 'date_end' ] ) ){
			$data[ 'date_end' ] = date( 'Y-m-d', strtotime( $data[ 'date_start' ] ) + 86400 );
		}

		if( ! isset( $data[ 'date_end__is_define' ] ) || $data[ 'date_end__is_define' ] == '' ){
			$data[ 'end_date_is_define' ] == 'undefined';
		}

		$prevention_data = wp_parse_args( $data, $prevention->data );

		return Prevention_Class::g()->update( $prevention_data );
	}

	public function display_list_intervenant( $id ){
		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-3-table-users', array(
			'prevention' => $prevention
		) );
	}

	public function display_maitre_oeuvre( $user = array(), $id = 0 ){
		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-4-maitre-oeuvre', array(
			'user' => $user,
			'prevention' => $this->add_information_to_prevention( $prevention )
		) );
	}

	public function display_intervenant_exterieur( $user = array(), $id = 0 ){
		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-4-intervenant-exterieur', array(
			'user' => $user,
			'prevention' => $prevention
		) );
	}

	public function add_signature_maitre_oeuvre( $prevention, $signature_data , $slug ) {
		$upload_dir = wp_upload_dir();

		// Association de la signature.
		if ( ! empty( $signature_data ) ) {
			$encoded_image = explode( ',', $signature_data )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $prevention->data['id'] );

			$prevention->data[$slug]['signature_id']   = $file_id;
			$prevention->data[$slug]['signature_date'] = current_time( 'mysql' );
		}

		return $prevention;
	}

	public function save_info_maitre_oeuvre(){
		$id   = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$i_name        = ! empty( $_POST['intervenant-name'] ) ? sanitize_text_field( $_POST['intervenant-name'] ) : '';
		$i_lastname    = ! empty( $_POST['intervenant-lastname'] ) ? sanitize_text_field( $_POST['intervenant-lastname'] ) : '';
		$i_phone       = ! empty( $_POST['intervenant-phone'] ) ? sanitize_text_field( $_POST['intervenant-phone'] ) : '';
		$i_phone_code  = ! empty( $_POST['intervenant-phone-callingcode'] ) ? sanitize_text_field( $_POST['intervenant-phone-callingcode'] ) : '';
		$i_email  = ! empty( $_POST['intervenant-email'] ) ? sanitize_text_field( $_POST['intervenant-email'] ) : '';

		if( ! $i_name || ! $i_lastname || ! $i_phone || ! $i_email ){
			wp_send_json_error( 'Erreur in intervenant exterieur' );
		}

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		$data_i = array(
			'firstname' => $i_name,
			'lastname'  => $i_lastname,
			'phone'     => '(' . $i_phone_code . ')' . $i_phone,
			'phone_nbr' => $i_phone,
			'email' => $i_email,
		);

		$prevention->data[ 'intervenant_exterieur' ] = wp_parse_args( $data_i, $prevention->data[ 'intervenant_exterieur' ] );
		return Prevention_Class::g()->update( $prevention->data );
	}


	public function add_information_to_prevention( $prevention ){
		$prevention->data[ 'intervention' ] = Prevention_Intervention_Class::g()->get( array( 'post_parent' => $prevention->data[ 'id' ] ) ); // Recupere la liste des interventions

		if( $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ){ // Maitre d'oeuvre data
			$id = $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ];
			$prevention = $this->get_information_from_user( $id, $prevention, 'maitre_oeuvre' );
		}

		if( $prevention->data[ 'step' ] >= \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_CLOSED ){
			$prevention->data[ 'is_end' ] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED;
			$prevention->data[ 'step' ] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_FORMER;
			Prevention_Class::g()->update( $prevention->data );
		}


		// Go supprimer les 5 prochaines lignes d'ici le 30/09/2019
		// Avec la fonction -> C'était pour update l'identifier de chaque prévention
		if( $prevention->data[ 'is_end' ] == \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED ){
			if( $prevention->data[ 'unique_identifier_int' ] == 0 ){
				$prevention->data[ 'unique_identifier_int' ] = $this->find_this_unique_identifier( $prevention->data[ 'id' ], false );
				Prevention_Class::g()->update( $prevention->data );
			}

			$prevention->data[ 'unique_identifier' ] = Setting_Class::g()->get_prefix_prevention_plan() . $prevention->data[ 'unique_identifier_int' ];
		}
		// Jusqu'ici - Corentin (Meme function dans permis-feu.class.php)

		if( strlen( $prevention->data[ 'title' ] ) > 35 ){
			$prevention->data[ 'title' ] = substr( $prevention->data[ 'title' ], 0, 35 );
		}


		return $prevention;
	}

	public function get_information_from_user( $id, $prevention, $type_user ){
		$user_info = get_user_by( 'id', $id );
		$prevention->data[ $type_user ] = wp_parse_args( $user_info, $prevention->data[ $type_user ] );

		$avatar_color = array( 'e9ad4f', '50a1ed', 'e05353', 'e454a2', '47e58e', '734fe9' ); // Couleur
		$color = $id % count( $avatar_color );
		$prevention->data[ $type_user ][ 'data' ]->avator_color = $avatar_color[ $color ]; // De l'avatar

		$prevention->data[ $type_user ][ 'data' ]->first_name = $user_info->first_name != "" ? $user_info->first_name : $user_info->data->display_name; // De l'avatar
		$prevention->data[ $type_user ][ 'data' ]->last_name = $user_info->last_name != "" ? $user_info->last_name : $user_info->data->display_name; // De l'avatar

		if( $user_info->first_name != "" || $user_info->last_name != "" ){ // Inital
			$prevention->data[ $type_user ][ 'data' ]->initial = substr( $user_info->first_name, 0, 1 ) . ' ' . substr( $user_info->last_name, 0, 1 );
		}else{
			$prevention->data[ $type_user ][ 'data' ]->initial = substr( $user_info->display_name, 0, 1 );
		}

		$user_information = get_the_author_meta( 'digirisk_user_information_meta', $id );
		$phone_number = ! empty( $user_information['digi_phone_number_full'] ) ? $user_information['digi_phone_number_full'] : '';
		$phone_only_number = ! empty( $user_information['digi_phone_number'] ) ? $user_information['digi_phone_number'] : '';
		$prevention->data[ $type_user ][ 'data' ]->phone = $phone_number;
		$prevention->data[ $type_user ][ 'data' ]->phone_nbr = $phone_only_number;

		return $prevention;
	}

	public function generate_document_odt_prevention( $prevention ){

		$legal_display = Legal_Display_Class::g()->get( array(
			'posts_per_page' => 1
		), true );

		if ( empty( $legal_display ) ) {
			$legal_display = Legal_Display_Class::g()->get( array(
				'schema' => true,
			), true );
		}

		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$data = array(
			'legal_display' => $legal_display,
			'society' => $society
		);

		$response = Sheet_Prevention_Class::g()->prepare_document( $prevention, $data );
		$response = Sheet_Prevention_Class::g()->create_document( $response['document']->data['id'] );
		return $response;
	}

	public function update_maitre_oeuvre( $id, $user_info ){
		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		if( ! empty( $user_info ) ){
			$prevention->data['maitre_oeuvre']['user_id'] = intval( $user_info->data->ID );
		}
		return Prevention_Class::g()->update( $prevention->data );
	}

	public function intervenant_is_valid( $idata ){
		if( $idata[ 'firstname' ] && $idata[ 'lastname' ] && $idata[ 'phone_nbr' ] && $idata[ 'signature_id' ] && $idata[ 'email' ] ){
			return true;
		}
		return false;
	}

	public function prepare_prevention_to_odt_intervention( $prevention ){
		$data_interventions = array();
		$interventions_info = "";
		$nbr = 0;
		if( ! empty( $prevention->data[ 'intervention' ] ) ){
			foreach( $prevention->data[ 'intervention' ] as $intervention ){
				$risk = Risk_Category_Class::g()->get( array( 'id' => $intervention->data[ 'risk' ] ), true );
				$data_temp = array(
					'key_unique'    => $intervention->data[ 'key_unique' ],
					'unite_travail' => Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] ),
					'action'        => $intervention->data[ 'action_realise' ],
					'risk'          => $risk->data[ 'name' ],
					'prevention'    => $intervention->data[ 'moyen_prevention' ]
				);
				$data_interventions[] = $data_temp;
			}
			$nbr = count( $prevention->data[ 'intervention' ] );
		}else{
			$data_interventions[0] = array(
				'key_unique' => '',
				'unite_travail' => '',
				'action' => '',
				'risk' => '',
				'prevention' => ''
			);
			// $interventions_info = esc_html__( 'Aucune intervention définie' );
		}
		$interventions_info = esc_html__( sprintf( '%1$d intervention(s)', $nbr ), 'digirisk' );
		return array( 'data' => $data_interventions, 'text' => $interventions_info );
	}

	public function get_identifier_prevention( $with_prefix = false ){
		$unique_key = 0;
		$list_prevention = get_posts( array(
		  	'post_status'    => array( 'publish', 'inherit', 'any', 'trash' ),
		  	'posts_per_page' => -1,
		  	'post_type'      => $this->get_type(),
  			'meta_key'   => '_wpdigi_prevention_prevention_is_end',
            'meta_value' => \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED,
		) );

		$nbr_prevention = count( $list_prevention ) + 1;
		if( $with_prefix ){
			$prefix_prevention_plan = Setting_Class::g()->get_prefix_prevention_plan();
			$unique_key = $prefix_prevention_plan . $nbr_prevention;
		}else{
			$unique_key = $nbr_prevention;
		}
		return $unique_key;
	}

	public function find_this_unique_identifier( $id, $with_prefix = false ){ // A SUPPRIMER POUR LE 30/09
		$list_prevention = get_posts( array(
			'post_status'    => array( 'publish', 'inherit', 'any' ),
			'posts_per_page' => -1,
			'post_type'      => $this->get_type(),
			'meta_key'   => '_wpdigi_prevention_prevention_is_end',
			'meta_value' => \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED,
		) );
		$i = 0;
		if( ! empty( $list_prevention ) ){
			foreach( $list_prevention as $prevention ){
				if( $prevention->ID == $id ){
					$nbr_prevention = count( $list_prevention ) - $i;
					if( $with_prefix ){
						$prefix_prevention_plan = Setting_Class::g()->get_prefix_prevention_plan();
						$unique_key = $prefix_prevention_plan . $nbr_prevention;
					}else{
						$unique_key = $nbr_prevention;
					}
					return $unique_key;
				}else{
					$i ++;
				}
			}
		}

		$nbr_prevention = 0;
		if( $with_prefix ){
			$prefix_prevention_plan = Setting_Class::g()->get_prefix_prevention_plan();
			$unique_key = $prefix_prevention_plan . $nbr_prevention;
		}else{
			$unique_key = $nbr_prevention;
		}
		return $unique_key;
	}  // A SUPPRIMER

	public function verify_all_intervenant( $intervenants ){
		foreach( $intervenants as $key => $user ){
			$intervenants[ $key ][ 'id' ] = $key + 1;
			if( ! isset( $user[ 'phone' ] ) || $user[ 'phone' ] == "" ){
				$intervenants[ $key ][ 'phone' ] = esc_html__( 'Téléphone non-défini', 'digirisk' );
			}

			if( ! isset( $user[ 'mail' ] ) || $user[ 'mail' ] == "" ){
				$intervenants[ $key ][ 'mail' ] = esc_html__( 'Mail non-défini', 'digirisk' );
			}
		}

		return $intervenants;
	}

	public function step_is_valid( $step, $prevention_plan ) {
		switch( $step ) {
			case 1:
				$signature_id = (int) get_post_meta( $prevention_plan->data['id'], 'maitre_oeuvre_signature_id', true );

				if ( isset( $prevention_plan->data['maitre_oeuvre']['data'] ) && $prevention_plan->data['maitre_oeuvre']['data']->first_name != "" &&
				     $prevention_plan->data['maitre_oeuvre']['data']->last_name != ""  && $signature_id != 0 ) {
					return true;
				}
				break;
			case 2:
				return true;
				break;
			case 3:
				return true;
				break;
			case 4:
				return true;
				break;
			default:
				break;
		}

		return false;
	}
}

Prevention_Class::g();
