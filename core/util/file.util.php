<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit;
}

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class file_util extends singleton_util {
	protected function construct() {}

		/**
		 * Upload un fichier et créer ensuite les meta données
		 *
		 * @param string $file Le chemin vers le fichier
		 * @param int    $element_id L'id de l'élement parent
		 *
		 * @return int L'attachement id
		 */
	public static function move_file_and_attach( $file, $element_id ) {
		if ( ! is_string( $file ) || ! is_int( $element_id ) || ! is_file( $file ) ) {
			return false;
		}

		$wp_upload_dir = wp_upload_dir();

		// Transfère le thumbnail
		$upload_result = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) );

		$filetype = wp_check_filetype( basename( $upload_result['file'] ), null );
		/**	Set the default values for the current attachement	*/
		$attachment_default_args = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $upload_result['file'] ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_result['file'] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
		);

		/**	Save new picture into database	*/
		$attach_id = wp_insert_attachment( $attachment_default_args, $upload_result['file'], $element_id );

		/**	Create the different size for the given picture and get metadatas for this picture	*/
		$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_result['file'] );
		/**	Finaly save pictures metadata	*/
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}
}
