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
class Permis_Feu_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Permis_Feu_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-permisfeu';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'permisfeu';

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
	protected $meta_key = '_wpdigi_permis_feu';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'C';

	public function get_link( $permis_feu, $step_number, $skip = false ) {
		return admin_url( 'admin-post.php?action=change_step_permis_feu&id=' . $permis_feu->data['id'] . '&step=' . $step_number );
	}

	public function add_information_to_permis_feu( $permis_feu ){
		$permis_feu->data[ 'intervention' ] = Permis_Feu_Intervention_Class::g()->get( array( 'post_parent' => $permis_feu->data[ 'id' ] ) ); // Recupere la liste des interventions

		if( $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ){ // Maitre d'oeuvre data
			$id = $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ];
			$permis_feu = $this->get_information_from_user( $id, $permis_feu, 'maitre_oeuvre' );
		}
		if( $permis_feu->data[ 'prevention_id' ] != 0 ){
			$prevention = Prevention_Class::g()->get( array( 'id' => $permis_feu->data[ 'prevention_id' ] ), true );
			$permis_feu->data[ 'prevention_data' ] = $prevention->data;
		}

		if( $permis_feu->data[ 'step' ] >= \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_CLOSED ){
			$permis_feu->data[ 'is_end' ] = \eoxia\Config_Util::$init['digirisk']->permis_feu->status->PERMIS_FEU_IS_ENDED;
			$permis_feu->data[ 'step' ] = \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_FORMER;
			Permis_feu_Class::g()->update( $permis_feu->data );
		}

		return $permis_feu;
	}

	public function display_maitre_oeuvre( $permis_feu ){
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-4-maitre-oeuvre', array(
			'permis_feu' => $permis_feu
		) );
	}

	public function update_maitre_oeuvre( $id, $user_info ){
		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );

		if( ! empty( $user_info ) ){
			$permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] =  intval( $user_info->data->ID );
		}
		return Permis_Feu_Class::g()->update( $permis_feu->data );
	}

	public function get_information_from_user( $id, $permis_feu, $type_user ){
		$user_info = get_user_by( 'id', $id );
		$permis_feu->data[ $type_user ] = wp_parse_args( $user_info, $permis_feu->data[ $type_user ] );

		$avatar_color = array( 'e9ad4f', '50a1ed', 'e05353', 'e454a2', '47e58e', '734fe9' ); // Couleur
		$color = $id % count( $avatar_color );
		$permis_feu->data[ $type_user ][ 'data' ]->avator_color = $avatar_color[ $color ]; // De l'avatar

		$permis_feu->data[ $type_user ][ 'data' ]->first_name = $user_info->first_name != "" ? $user_info->first_name : $user_info->data->display_name; // De l'avatar
		$permis_feu->data[ $type_user ][ 'data' ]->last_name = $user_info->last_name != "" ? $user_info->last_name : $user_info->data->display_name; // De l'avatar

		if( $user_info->first_name != "" || $user_info->last_name != "" ){ // Inital
			$permis_feu->data[ $type_user ][ 'data' ]->initial = substr( $user_info->first_name, 0, 1 ) . ' ' . substr( $user_info->last_name, 0, 1 );
		}else{
			$permis_feu->data[ $type_user ][ 'data' ]->initial = substr( $user_info->display_name, 0, 1 );
		}

		$user_information = get_the_author_meta( 'digirisk_user_information_meta', $id );
		$phone_number = ! empty( $user_information['digi_phone_number_full'] ) ? $user_information['digi_phone_number_full'] : '';
		$phone_only_number = ! empty( $user_information['digi_phone_number'] ) ? $user_information['digi_phone_number'] : '';
		$permis_feu->data[ $type_user ][ 'data' ]->phone = $phone_number;
		$permis_feu->data[ $type_user ][ 'data' ]->phone_nbr = $phone_only_number;

		return $permis_feu;
	}

	public function add_signature_maitre_oeuvre( $permis_feu, $signature_data , $slug ) {
		$upload_dir = wp_upload_dir();

		// Association de la signature.
		if ( ! empty( $signature_data ) ) {
			$encoded_image = explode( ',', $signature_data )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $permis_feu->data['id'] );

			$permis_feu->data[$slug]['signature_id']   = $file_id;
			$permis_feu->data[$slug]['signature_date'] = current_time( 'mysql' );
		}

		return $permis_feu;
	}

	public function step_maitreoeuvre( $permis_feu ) {

		$mo_phone      = ! empty( $_POST['maitre-oeuvre-phone'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-phone'] ) : '';
		$mo_phone_code = ! empty( $_POST['maitre-oeuvre-phone-callingcode'] ) ? sanitize_text_field( $_POST['maitre-oeuvre-phone-callingcode'] ) : '';
		$update = ! empty( $_POST['update'] ) ? false : true;

		$permis_feu->data['step'] = \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_INFORMATION;

		if( $mo_phone != "" && $update ){
			$mo_phone_code = $mo_phone_code != "" ? '(' . $mo_phone_code . ')' : '';
			$permis_feu->data[ 'maitre_oeuvre' ][ 'phone' ] = $mo_phone_code . $mo_phone;

			if( $permis_feu->data[ 'maitre_oeuvre'][ 'user_id' ] ){

				$user_information = get_the_author_meta( 'digirisk_user_information_meta', $permis_feu->data[ 'maitre_oeuvre'][ 'user_id' ] );
				$user_information = ! empty( $user_information ) ? $user_information : array();
				$user_information[ 'digi_phone_number' ] = $mo_phone;
				$user_information[ 'digi_phone_number_full' ] = $mo_phone_code . $mo_phone;

				update_user_meta( $permis_feu->data[ 'maitre_oeuvre'][ 'user_id' ], 'digirisk_user_information_meta', $user_information );
			}
		}

		$permis_feu = Permis_Feu_Class::g()->update( $permis_feu->data );
		return Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu );
	}

	public function display_prevention( $permis_feu ){
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-prevention', array(
			'permis_feu' => $permis_feu
		) );
	}

	public function generate_worktype_if_not_exist(){
		$default_core_option = array(
			'installed'                   => false,
			'db_version'                  => '1',
			'danger_installed'            => false,
			'recommendation_installed'    => false,
			'evaluation_method_installed' => false,
			'worktype_installed'          => false,
		);

		$core_option = get_option( \eoxia\Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! isset( $core_option['worktype_installed'] ) || ! $core_option['worktype_installed'] ){
			\eoxia\LOG_Util::log( 'Installeur composant - DEBUT: Création des catégories de types de travaux', 'digirisk' );
			if ( Worktype_Category_Default_Data_Class::g()->create() ) {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégories de types de travaux SUCCESS', 'digirisk' );
				$core_option['worktype_installed'] = true;
			} else {
				\eoxia\LOG_Util::log( 'Installeur composant - FIN: Création des catégories de types de travaux ERROR', 'digirisk' );
			}
			update_option( \eoxia\Config_Util::$init['digirisk']->core_option, $core_option );
			return true;
		}
		return false;
	}

	public function display_intervenant_exterieur( $user = array(), $id = 0 ){
		$permis_feu = Permis_feu_Class::g()->get( array( 'id' => $id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-4-intervenant-exterieur', array(
			'user' => $user,
			'permis_feu' => $permis_feu
		) );
	}

	public function save_info_maitre_oeuvre(){
		$id   = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$i_name        = ! empty( $_POST['intervenant-name'] ) ? sanitize_text_field( $_POST['intervenant-name'] ) : '';
		$i_lastname    = ! empty( $_POST['intervenant-lastname'] ) ? sanitize_text_field( $_POST['intervenant-lastname'] ) : '';
		$i_phone       = ! empty( $_POST['intervenant-phone'] ) ? sanitize_text_field( $_POST['intervenant-phone'] ) : '';
		$i_phone_code  = ! empty( $_POST['intervenant-phone-callingcode'] ) ? sanitize_text_field( $_POST['intervenant-phone-callingcode'] ) : '';

		if( ! $i_name || ! $i_lastname || ! $i_phone ){
			wp_send_json_error( 'Erreur in intervenant exterieur' );
		}

		$permis_feu = Permis_feu_Class::g()->get( array( 'id' => $id ), true );

		$data_i = array(
			'firstname' => $i_name,
			'lastname'  => $i_lastname,
			'phone'     => '(' . $i_phone_code . ')' . $i_phone,
			'phone_nbr' => $i_phone
		);

		$permis_feu->data[ 'intervenant_exterieur' ] = wp_parse_args( $data_i, $permis_feu->data[ 'intervenant_exterieur' ] );
		return Permis_feu_Class::g()->update( $permis_feu->data );
	}

	public function display_list_intervenant( $id ){
		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-3-table-users', array(
			'permis_feu' => $permis_feu
		) );
	}

	public function generate_document_odt_prevention( $permis_feu ){

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

		$response = Sheet_Permis_Feu_Class::g()->prepare_document( $permis_feu, $data );
		echo '<pre>'; print_r( $response['document']->data['id'] ); echo '</pre>';
		$response = Sheet_Permis_Feu_Class::g()->create_document( $response['document']->data['id'] );
		echo '<pre>'; print_r( $response ); echo '</pre>';
		return $response;
	}

	public function update_information_permis_feu( $permis_feu, $data = array() ){
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

		$permis_feu_data = wp_parse_args( $data, $permis_feu->data );

		return Permis_feu_Class::g()->update( $permis_feu_data );
	}

	public function import_list_intervenant( $permis_feu ){
		$text_info = "";

		if( $permis_feu->data[ 'prevention_id' ] != 0 ){
			$prevention = Prevention_Class::g()->get( array( 'id' => $permis_feu->data[ 'prevention_id' ] ), true );
			$permis_feu->data[ 'intervenants' ] = $prevention->data[ 'intervenants' ];
			$permis_feu = Permis_feu_Class::g()->update( $permis_feu->data );
			$text_info = esc_html__( sprintf( 'Récupération des intervenants définies dans le plan de prévention ( %1$d )', count( $permis_feu->data[ 'intervenants' ] ) ), 'dirigisk' );
		}

		return array( 'permis_feu' => $permis_feu, 'text_info' => $text_info );
	}

	public function prepare_permis_feu_to_odt_prevention( $prevention ){

		$raison_du_plan_de_prevention = "";
		if( $prevention->data['more_than_400_hours'] ){
			$raison_du_plan_de_prevention = esc_html__( 'Plus de 400 heures' );
		}
		if( $prevention->data['imminent_danger'] ){
			if( $raison_du_plan_de_prevention != "" ){
				$raison_du_plan_de_prevention .= ", " . esc_html__( 'Danger grave et imminent' );
			}else{
				$raison_du_plan_de_prevention = esc_html__( 'Danger grave et imminent' );
			}
		}
		$raison_du_plan_de_prevention = $raison_du_plan_de_prevention != "" ? $raison_du_plan_de_prevention : 'Non-précisé';

		$args = array(
			'titre_plan_prevention' => $prevention->data[ 'title' ],
			'raison_plan_prevention' => $raison_du_plan_de_prevention,
			'date_start_intervention_pre' => date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ) ),
			'date_end_intervention_pre' => date( 'd/m/Y', strtotime( $prevention->data[ 'date_end' ][ 'rendered' ][ 'mysql' ] ) )
		);

		return $args;
	}

	public function prepare_permis_feu_to_odt_intervention( $permis_feu ){

		$data_interventions = array();

		if( ! empty( $permis_feu->data[ 'intervention' ] ) ){
			foreach( $permis_feu->data[ 'intervention' ] as $intervention ){
				$worktype = Worktype_Category_Class::g()->get( array( 'id' => $intervention->data[ 'worktype' ] ), true );
				$data_temp = array(
					'key_unique'    => $intervention->data[ 'key_unique' ],
					'unite_travail' => Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] ),
					'action'        => $intervention->data[ 'action_realise' ],
					'risk'          => $worktype->data[ 'name' ],
					'prevention'    => $intervention->data[ 'materiel_utilise' ]
				);
				$data_interventions[] = $data_temp;
			}
			$nbr = count( $permis_feu->data[ 'intervention' ] );
			$interventions_info = esc_html__( sprintf( 'Il y a %1$d intervention(s)', $nbr ), 'digirisk' );
		}else{
			$data_interventions[0] = array(
				'key_unique' => '',
				'unite_travail' => '',
				'action' => '',
				'risk' => '',
				'prevention' => ''
			);
			$interventions_info = esc_html__( 'Aucune intervention définie' );
		}

		return array( 'data' => $data_interventions, 'text' => $interventions_info );
	}
}

Permis_Feu_Class::g();
