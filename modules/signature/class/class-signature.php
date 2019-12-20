<?php
/**
 * Gestion des signatures
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.2
 * @copyright 2015-2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Gestion des signatures
 */
class Signature extends \eoxia\Singleton_Util {
	protected function construct() {}

	/**
	 * Ajoutes l'ID de la signature associté à l'utilisateur dans la causerie.
	 *
	 * @since   7.5.2
	 *
	 * @param integer $id             ID de l'utilisateur pour associer la signature à la causerie "intervention".
	 * @param string  $signature_data Base64 de l'image de la signature.
	 */
	public function save( $id, $key, $type, $signature_data ) {
		$upload_dir = wp_upload_dir();

		// Association de la signature.
		if ( ! empty( $signature_data ) ) {
			$encoded_image = explode( ',', $signature_data )[1];
			$decoded_image = base64_decode( $encoded_image );

			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );

			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $id );

			if ( ! empty( $key ) ) {
				switch ( $type ) {
					case 'post':
						update_post_meta( $id, $key, $file_id );
						update_post_meta( $id, $key . '_' . $file_id . '_date', current_time( 'mysql' ) );
						break;
					case 'user':
						update_user_meta( $id, $key, $file_id );
						update_user_meta( $id, $key . '_' . $file_id . '_date', current_time( 'mysql' ) );
						break;
					default:
						update_post_meta( $id, $key, $file_id );
						update_post_meta( $id, $key . '_' . $file_id . '_date', current_time( 'mysql' ) );
						break;
				}
			}

			return $file_id;
		}

		return false;
	}
}
