<?php
/**
 * La classe gérant les plans de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
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
	public $element_prefix = 'C';


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

	public function step_former( $prevention, $former_id ) {
		$prevention = $this->add_participant( $prevention, $former_id, true );
		$prevention->data['step'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_INFORMATION;

		return Prevention_Class::g()->update( $prevention->data );
	}

	public function add_participant( $prevention, $user_id, $is_former = false ) {
		if ( $is_former ) {
			$prevention->data['former']['user_id'] = $user_id;
		} else {
			$prevention->data['participants'][ $user_id ] = array(
				'user_id' => $user_id,
			);
		}

		return $prevention;
	}

	public function check_all_signed( $causerie ) {
		$all_signed = true;

		if ( empty( $causerie->data['participants'] ) ) {
			$all_signed = false;
		}

		if ( ! empty( $causerie->data['participants'] ) ) {
			foreach ( $causerie->data['participants'] as $participant ) {
				if ( empty( $participant['signature_id'] ) ) {
					$all_signed = false;
					break;
				}
			}
		}

		return $all_signed;
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
			$data[ 'title' ] = esc_html__( 'Aucun titre', 'task-manager' );
		}

		if( ! isset( $data[ 'date_start' ] ) || $data[ 'date_start' ] == '' ){
			$data[ 'date_start' ] = date( 'd-m-Y', strtotime( 'now' ) );
		}

		if( ! isset( $data[ 'date_end' ] ) || $data[ 'date_end' ] == '' || strtotime( $data[ 'date_start' ] ) > strtotime( $data[ 'date_end' ] ) ){
			$data[ 'date_end_exist' ] = 0;
		}else{
			$data[ 'date_end_exist' ] = 1;
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
			'prevention' => $prevention
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

		$mo_name     = ! empty( $_POST['maitre-oeuvre-name'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-name'] ) : '';
		$mo_lastname = ! empty( $_POST['maitre-oeuvre-lastname'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-lastname'] ) : '';
		$mo_phone    = ! empty( $_POST['maitre-oeuvre-phone'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-phone'] ) : '';
		$mo_sign     = ! empty( $_POST['maitre-oeuvre-signature'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-signature'] ) : '';

		$i_name      = ! empty( $_POST['intervenant-name'] ) ? sanitize_text_field( $_POST['intervenant-name'] ) : '';
		$i_lastname = ! empty( $_POST['intervenant-lastname'] ) ? sanitize_text_field( $_POST['intervenant-lastname'] ) : '';
		$i_phone    = ! empty( $_POST['intervenant-phone'] ) ? sanitize_text_field( $_POST['intervenant-phone'] ) : '';
		$i_sign     = ! empty( $_POST['intervenant-exterieur-signature'] ) ? sanitize_text_field( $_POST['intervenant-exterieur-signature'] ) : '';

		if( ! $id || ! $mo_name || ! $mo_lastname || ! $mo_phone || ! $mo_sign ){
			wp_send_json_error( 'Erreur in master ouvrage' );
		}

		if( ! $i_name || ! $i_lastname || ! $i_phone || ! $i_sign ){
			wp_send_json_error( 'Erreur in intervenant exterieur' );
		}


		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );

		$data_mo = array(
			'firstname' => $mo_name,
			'lastname'  => $mo_lastname,
			'phone'     => $mo_phone
		);

		$prevention->data[ 'maitre_oeuvre' ] = wp_parse_args( $data_mo, $prevention->data[ 'maitre_oeuvre' ] );

		$data_i = array(
			'firstname' => $i_name,
			'lastname'  => $i_lastname,
			'phone'     => $i_phone
		);
		$prevention->data[ 'intervenant_exterieur' ] = wp_parse_args( $data_i, $prevention->data[ 'intervenant_exterieur' ] );

		return Prevention_Class::g()->update( $prevention->data );
	}


	public function add_information_to_prevention( $prevention ){
		$avatar_color = array( 'e9ad4f', '50a1ed', 'e05353', 'e454a2', '47e58e', '734fe9' );

		$id = $prevention->data[ 'former' ][ 'user_id' ];
		$user_info = get_user_by( 'id', $id );

		$prevention->data[ 'former' ] = wp_parse_args( $user_info, $prevention->data[ 'former' ] );
		$color = $id % count( $avatar_color );
		$prevention->data[ 'former' ][ 'data' ]->avator_color = $avatar_color[ $color ];

		$prevention->data[ 'intervention' ] = Prevention_Intervention_Class::g()->get( array( 'post_parent' => $prevention->data[ 'id' ] ) );
		$inital = substr( $user_info->first_name, 0, 1 ) . ' ' . substr( $user_info->last_name, 0, 1 );
		$prevention->data[ 'former' ][ 'data' ]->initial = $inital;
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
		Sheet_Prevention_Class::g()->create_document( $response['document']->data['id'] );
	}
}

Prevention_Class::g();
