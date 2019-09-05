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

	public function get_link( $prevention, $step_number, $skip = false ) {
		return admin_url( 'admin-post.php?action=change_step_permis_feu&id=' . $prevention->data['id'] . '&step=' . $step_number );
	}

	public function add_information_to_permis_feu( $permis_feu ){
		if( $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ){ // Maitre d'oeuvre data
			$id = $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ];
			$permis_feu = $this->get_information_from_user( $id, $permis_feu, 'maitre_oeuvre' );
		}
		if( $permis_feu->data[ 'prevention_id' ] != 0 ){
			$prevention = Prevention_Class::g()->get( array( 'id' => $permis_feu->data[ 'prevention_id' ] ), true );
			$permis_feu->data[ 'prevention_data' ] = $prevention->data;
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

}

Permis_Feu_Class::g();
