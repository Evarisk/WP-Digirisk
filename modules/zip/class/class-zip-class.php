<?php
/**
 * Gestion des ZIP.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des ZIP
 */
class ZIP_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\ZIP_Model';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	protected $type = 'zip';

	/**
	 * A faire
	 *
	 * @todo
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale de l'objet
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La base de l'URI pour la Rest API
	 *
	 * @var string
	 */
	protected $base = 'zip';

	/**
	 * La version pour la Rest API
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe pour le champs "unique_key" de l'objet
	 *
	 * @var string
	 */
	public $element_prefix = 'ZIP';

	/**
	 * La limite des documents affichés par page
	 *
	 * @var integer
	 */
	protected $limit_document_per_page = 50;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'ZIP';

	/**
	 * Convertis le chemin absolu vers le fichier en URL
	 *
	 * @since 6.1.9
	 *
	 * @param  string $zip_path Le chemin absolu vers le fichier.
	 *
	 * @return string           L'URL vers le fichier
	 */
	public function get_zip_url( $zip_path ) {
		$upload_dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $upload_dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $upload_dir['baseurl'] );
		$url     = str_replace( $basedir, $baseurl, $zip_path );

		if ( ! file_exists( str_replace( '\\', '/', $zip_path ) ) ) {
			$url = '';
		}
		return $url;
	}

	/**
	 * Créé un fichier au format zip a partir d'une liste de fichiers passé en paramètres
	 *
	 * @since 6.1.9
	 *
	 * @param string $path     Le chemin vers lequel il faut sauvegarder le fichier zip.
	 * @param object $element  L'élément auquel il faut associer le fichier zip.
	 *
	 * array['status']  boolean True si tout s'est bien passé, sinon false.
	 * array['message'] string  Le message informatif du résultat de la méthode.
	 *
	 * @return array (Voir au dessus).
	 */
	public function create_zip( $path, $element ) {
		$zip           = new \ZipArchive();
		$files_details = get_option( \eoxia\Config_Util::$init['digirisk']->zip->key_temporarly_files_details, array() );
		$response      = array( 'status' => false );

		if ( empty( $files_details ) ) {
			return $response;
		}

		if ( $zip->open( $path, \ZipArchive::CREATE ) !== true ) {
			$response['status']  = false;
			$response['message'] = __( 'An error occured while opening zip file to write', 'digirisk' );
			return $response;
		}

		if ( ! empty( $files_details ) ) {
			foreach ( $files_details as $file_details ) {
				if ( ! empty( $file_details['path'] ) && ! empty( $file_details['filename'] ) ) {
					$zip->addFile( $file_details['path'], $file_details['filename'] );
				}
			}
		}
		$zip->close();

		$document_revision = \eoxia\ODT_Class::g()->get_revision( 'zip', $element->data['id'] );

		$filename  = mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_';
		$filename .= 'Z' . $element->data['unique_key'] . '_';
		$filename .= sanitize_title( str_replace( ' ', '_', $element->data['title'] ) ) . '_V';
		$filename .= $document_revision . '.zip';

		// base de données.
		$document_args = array(
			'link'                    => Document_Util_Class::g()->get_digirisk_upload_dir() . '/' . $path,
			'title'                   => basename( $filename, '.zip' ),
			'mime_type'               => 'application/zip',
			'parent_id'               => $element->data['id'],
			'parent'                  => $element,
			'status'                  => 'inherit',
			'list_generation_results' => $file_details,
		);

		$document = $this->update( $document_args );
		wp_set_object_terms( $document->data['id'], array( 'zip', 'printed' ), $this->attached_taxonomy_type );

		return array(
			'zip_path' => Document_Util_Class::g()->get_digirisk_upload_dir() . '/' . $path,
		);
	}

	/**
	 * Génères un zip et le met dans l'élément.
	 *
	 * @since 6.1.9
	 *
	 * @param Group_Model $element    Les données du groupement.
	 *
	 * @return array
	 */
	public function generate( $element ) {
		\eoxia\LOG_Util::log( 'DEBUT - Création ZIP', 'digirisk' );
		$version               = \eoxia\ODT_Class::g()->get_revision( 'zip', $element->data['id'] );
		$zip_path              = Document_Util_Class::g()->get_digirisk_upload_dir() . '/' . $element->data['type'] . '/' . $element->data['id'] . '/' . mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->data['unique_identifier'] . '_zip_' . sanitize_title( str_replace( ' ', '_', $element->data['title'] ) ) . '_V' . $version . '.zip';
		$zip_generation_result = $this->create_zip( $zip_path, $element );
		\eoxia\LOG_Util::log( 'FIN - Création ZIP', 'digirisk' );

		return array(
			'zip_path'          => $zip_path,
			'creation_response' => $zip_generation_result,
			'element'           => $element,
			'success'           => true,
		);
	}

	/**
	 * Supprimes l'option temporaire des fichiers à zipper.
	 *
	 * @since 6.5.0
	 */
	public function clear_temporarly_files_details() {
		delete_option( \eoxia\Config_Util::$init['digirisk']->zip->key_temporarly_files_details );
	}

	/**
	 * Met dans une meta temporaire les fichiers à zipper.
	 * Cette meta est utilisé et vidé dans la méthode create_zip.
	 *
	 * @since 6.5.0
	 *
	 * array['path']     string Le chemin vers le fichier.
	 * array['filename'] string Le nom du fichier.
	 *
	 * @param array $file_details (Voir au dessus).
	 */
	public function update_temporarly_files_details( $file_details ) {
		$files_details = get_option( \eoxia\Config_Util::$init['digirisk']->zip->key_temporarly_files_details, array() );

		$files_details[] = $file_details;
		update_option( \eoxia\Config_Util::$init['digirisk']->zip->key_temporarly_files_details, $files_details );
	}
}

ZIP_Class::g();
