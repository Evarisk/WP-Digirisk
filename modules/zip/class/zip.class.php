<?php
/**
 * Gestion des ZIP
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

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
	protected $post_type = 'zip';

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
	 * Fonctions appelées avant le PUT
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * Fonctions appelées après le GET
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

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
	 * @version 6.4.4
	 *
	 * @param  string $zip_path Le chemin absolu vers le fichier.
	 *
	 * @return string           L'URL vers le fichier
	 */
	public function get_zip_url( $zip_path ) {
		$basedir = Document_Class::g()->get_digirisk_dir_path( 'basedir' );
		$baseurl = Document_Class::g()->get_digirisk_dir_path( 'baseurl' );
		$url     = str_replace( $basedir, $baseurl, $zip_path );

		if ( ! file_exists( str_replace( '\\', '/', $zip_path ) ) ) {
			$url = '';
		}
		return $url;
	}

	/**
	 * Create a zip file with a list of file given in parameter / Créé un fichier au format zip a partir d'une liste de fichiers passé en paramètres
	 *
	 * @since 6.1.9
	 * @version 6.4.0
	 *
	 * @param string $final_file_path Le chemin vers lequel il faut sauvegarder le fichier zip.
	 * @param array  $file_list       La liste des fichiers à ajouter au fichier zip.
	 * @param object $element         L'élément auquel il faut associer le fichier zip.
	 * @param string $version         La version du zip.
	 */
	public function create_zip( $final_file_path, $file_list, $element, $version ) {
		$zip = new \ZipArchive();

		$response = array();
		if ( $zip->open( $final_file_path, \ZipArchive::CREATE ) !== true ) {
			$response['status'] = false;
			$response['message'] = __( 'An error occured while opening zip file to write', 'digirisk' );
		}

		if ( ! empty( $file_list ) ) {
			foreach ( $file_list as $file ) {
				if ( ! empty( $file['link'] ) ) {
					$zip->addFile( $file['link'], $file['filename'] );
				}
			}
		}
		$zip->close();

		$document_revision = $this->get_document_type_next_revision( array( 'zip' ), $element->id );

		$filename = mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_';
		$filename .= 'Z' . $element->unique_key . '_';
		$filename .= sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V';
		$filename .= $document_revision . '.odt';

		$attachment_args = array(
			'post_title' => basename( $filename, '.odt' ),
			'post_status' => 'inherit',
			'post_mime_type' => 'application/zip',
		);

		$path = $this->get_digirisk_dir_path() . '/' . $element->type . '/' . $element->id . '/' . $filename;

		$attachment_id = wp_insert_attachment( $attachment_args, $this->get_digirisk_dir_path() . '/' . $path, $element->id );
		wp_set_object_terms( $attachment_id, array( 'zip', 'printed' ), $this->attached_taxonomy_type );

		$document_args = array(
			'id' => $attachment_id,
			'title' => basename( $filename, '.odf' ),
			'parent_id' => $element->id,
			'mime_type' => 'application/zip',
			'list_generation_results' => $file_list,
			'status' => 'inherit',
			'version' => $document_revision,
		);

		$this->update( $document_args );

		return array(
			'zip_path' => $path,
		);
	}

	/**
	 * Génères un zip et le met dans l'élément.
	 *
	 * @since 6.1.9
	 * @version 6.4.4
	 *
	 * @param Group_Model $element    Les données du groupement.
	 * @param array       $files_info Un tableau contenant le nom des fichiers ainsi que le chemin sur le disque dur.
	 * @return array
	 */
	public function generate( $element, $files_info ) {
		\eoxia\LOG_Util::log( 'DEBUT - Création ZIP', 'digirisk' );
		$version               = Document_Class::g()->get_document_type_next_revision( array( 'zip' ), $element->id );
		$zip_path              = Document_Class::g()->get_digirisk_dir_path() . '/' . $element->type . '/' . $element->id . '/' . mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->unique_identifier . '_zip_' . sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V' . $version . '.zip';
		$zip_generation_result = $this->create_zip( $zip_path, $files_info, $element, $version );
		\eoxia\LOG_Util::log( 'FIN - Création ZIP', 'digirisk' );
		return array(
			'zip_path' => $zip_path,
			'creation_response' => $zip_generation_result,
			'element' => $element,
			'success' => true,
		);
	}
}

ZIP_Class::g();
