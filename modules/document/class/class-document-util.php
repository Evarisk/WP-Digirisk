<?php
/**
 * Classe gérant toutes les méthode utilitaires pour les documents ODT de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Document util class.
 */
class Document_Util_Class extends \eoxia\Singleton_Util {

	/**
	 * Les types par défaut des modèles.
	 *
	 * @since 7.0.0
	 *
	 * @var array
	 */
	private $default_types = array( 'model', 'default_model' );

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	protected function construct() {}

	/**
	 * Récupères le chemin vers le dossier "digirisk" dans wp-content/uploads
	 *
	 * @since 6.0.0
	 *
	 * @param string $path_type (Optional) Le type de path 'basedir' ou 'baseurl'.
	 * @return string Le chemin vers le document
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_upload_dir/
	 */
	public function get_digirisk_upload_dir() {
		$upload_dir = wp_upload_dir();
		return str_replace( '\\', '/', $upload_dir['basedir'] ) . '/digirisk';
	}

	/**
	 * Renvoies le chemin HTTP vers l'ODT.
	 *
	 * @since   6.0.0
	 *
	 * @param mixed  $element     Le modèle (objet) ODT.
	 * @param string $parent_type Le type de l'élement parent.
	 *
	 * @return string             Le chemin HTTP vers l'ODT.
	 */
	public function get_document_url( $element, $parent_type ) {
		$url = '';
		$dir = wp_upload_dir();

		if ( ! empty( $element ) && is_object( $element ) ) {
			$basedir = str_replace( '\\', '/', $dir['basedir'] );
			$baseurl = str_replace( '\\', '/', $dir['baseurl'] );
			$url     = $baseurl . '/';

			if ( ! empty( $element->data['parent_id'] ) && ! empty( $element->data['mime_type'] ) ) {
				$url .= '/' . $parent_type . '/' . $element->data['parent_id'] . '/';
			}

			$url .= $element->data['title'];

			if ( empty( $element->data['mime_type'] ) ) {
				$url = '';
			}

		}

		return $url;
	}

	public function get_picture( $id, $size_odt, $size = 'thumbnail' ) {

		$picture_definition = wp_get_attachment_image_src( $id, $size );
		
		/* $upload_dir = wp_upload_dir();
		
		$attachment   = get_post( $id );
		$post_name = $attachment->post_name;
		$attachment->post_title = $post_name;
		
		$picture_definition_path = $upload_dir['url'] . '/' .  $post_name;							affichage des images avec des accents
		$attachment->guid = $picture_definition_path;
		
		$attachment_meta = get_post_meta( $id, '_wp_attached_file', true );
		$attachment_meta = $upload_dir['subdir'] . '/' . $post_name;

		wp_update_post($attachment);
		update_post_meta($id, '_wp_attached_file', $attachment_meta);

		*/
		if ( ! $picture_definition ) {
			return array();
		}

		$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/', 'http' ), ABSPATH, $picture_definition[0] ) );
		$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/', 'https' ), ABSPATH, $picture_final_path ) );
		$picture_final_path = preg_replace( '/\pM+/u', $picture_final_path);
		$picture = array();

		if ( is_file( $picture_final_path ) ) {
			$picture = array(
				'type'		=> 'picture',
				'value'		=> $picture_final_path,
				'option'	=> array(
					'size'	=> $size_odt,
				),
			);
		}
		return $picture;
	}
}

Document_Util_Class::g();
