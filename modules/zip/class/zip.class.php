<?php
/**
 * Fait l'affichage du template de la liste des documents uniques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fait l'affichage du template de la liste des documents uniques
 */
class ZIP_Class extends \eoxia\Post_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   				= '\digi\ZIP_Model';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	protected $post_type    				= 'zip';

	/**
	 * A faire
	 *
	 * @todo
	 * @var string
	 */
	public $attached_taxonomy_type  = 'attachment_category';

	/**
	 * La clé principale de l'objet
	 *
	 * @var string
	 */
	protected $meta_key    					= '_wpdigi_document';

	/**
	 * La base de l'URI pour la Rest API
	 *
	 * @var string
	 */
	protected $base 								= 'zip';

	/**
	 * La version pour la Rest API
	 *
	 * @var string
	 */
	protected $version 							= '0.1';

	/**
	 * Le préfixe pour le champs "unique_key" de l'objet
	 *
	 * @var string
	 */
	public $element_prefix 					= 'ZIP';

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
	 * Ajout du filtre pour la Rest API
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
	}

	/**
	 * Convertis le chemin absolu vers le fichier en URL
	 *
	 * @param  string $zip_path Le chemin absolu vers le fichier.
	 *
	 * @return string           L'URL vers le fichier
	 */
	public function get_zip_url( $zip_path ) {
		$url = document_class::g()->get_digirisk_dir_path( 'baseurl' );
		$zip_path_exploded = explode( 'digirisk/', $zip_path );
		$url .= '/' . $zip_path_exploded[1];
		return $url;
	}

	/**
	 * Create a zip file with a list of file given in parameter / Créé un fichier au format zip a partir d'une liste de fichiers passé en paramètres
	 *
	 * @param string $final_file_path The zip file path where to save it / Le chemin vers lequel il faut sauvegarder le fichier zip
	 * @param array $file_list The file list to add to the zip file / La liste des fichiers à ajouter au fichier zip
	 * @param object $element The current element where to associate the zip file to / L'élément auquel il faut associer le fichier zip
	 * @param string $version La version du zip
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

		$document_creation_response = document_class::g()->create_document( $element, array( 'zip' ), $file_list, $version );
		$document_creation_response = wp_parse_args( $document_creation_response, $response );
		// if ( !empty( $document_creation_response[ 'id' ] ) && !empty( $element ) ) {
		// 	$element->associated_document_id[ 'document' ][] = $document_creation_response[ 'id' ];
		// 	group_class::g()->update( $element );
		// }

		return $document_creation_response;
	}

	/**
	 * Génères un zip et le met dans l'élément.
	 *
	 * @param Group_Model $element Les données du groupement.
	 * @param array       $files_info Un tableau contenant le nom des fichiers ainsi que le chemin sur le disque dur.
	 * @return array
	 */
	public function generate( $element, $files_info ) {
		$version = Document_Class::g()->get_document_type_next_revision( array( 'zip' ), $element->id );

		$zip_path = Document_Class::g()->get_digirisk_dir_path() . '/' . $element->type . '/' . $element->id . '/' . mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->unique_identifier . '_zip_' . sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V' . $version . '.zip';
		$zip_generation_result = Document_Class::g()->create_zip( $zip_path, $files_info, $element, $version );

		return array( 'zip_path' => $zip_path, 'creation_response' => $zip_generation_result, 'element' => $element, 'success' => true );
	}
}

ZIP_Class::g();
