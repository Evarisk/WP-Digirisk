<?php namespace digi;
/**
* Les fonctions principales pour la gestion des fichiers
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class File_Management_Class extends singleton_util {
	/**
	* Le constructeur
	*/
	protected function construct() {}

	/**
	* Associes un fichier à un element, todo: Sécurité
	*
	* @param int $file_id L'ID du fichier à associer
	* @param int $element_id L'ID de l'élement parent
	* @param string $object_name Le type de l'objet
	* @param bool $thumbnail (Optional) Le défini en vignette
	*/
  public function associate_file( $file_id, $element_id, $object_name, $namespace, $thumbnail = true ) {
		$model_name = '\\' . $namespace . '\\' . $object_name;
    $element = $model_name::g()->get( array( 'id' => $element_id ) );

    if ( wp_attachment_is_image( $file_id ) ) {
      $element[0]->associated_document_id['image'][] = (int) $file_id;

      if ( !empty( $thumbnail ) ) {
        set_post_thumbnail( $element_id, $file_id );
        $element[0]->thumbnail_id = $file_id;
      }
    }
    else {
      $element[0]->associated_document_id['document'][] = $file_id;
    }

    $model_name::g()->update( $element[0] );
  }

	/**
	 * Déssocies le fichier du tableau associated_document_id['image']
	 *
	 * @param  integer $file_id     L'ID du fichier.
	 * @param  integer $element_id  L'ID du l'élement contenant le fichier.
	 * @param  string  $object_name Le nom du modèle de l'objet.
	 * @param  string  $namespace Le namespace de l'objet.
	 *
	 * @return boolean
	 *
	 * @since 6.2.3.0
	 * @version 6.2.5.0
	 */
	public function dessociate_file( $file_id, $element_id, $object_name, $namespace ) {
		$model_name = '\\' . $namespace . '\\' . $object_name;
		$element = $model_name::g()->get( array( 'id' => $element_id ) );

		$founded_key = array_search( $file_id, $element[0]->associated_document_id['image'], true );
		if ( false === $founded_key ) {
			return false;
		}

		array_splice( $element[0]->associated_document_id['image'], $founded_key, 1 );

		if ( $element[0]->thumbnail_id === $file_id ) {
			delete_post_thumbnail( $element_id );
		}

		if ( 0 < count( $element[0]->associated_document_id['image'] ) ) {
			$element[0]->thumbnail_id = $element[0]->associated_document_id['image'][0];
		} else {
			$element[0]->thumbnail_id = 0;
		}

		$model_name::g()->update( $element[0] );

		return true;
	}

	public function upload_model( $type ) {
		// Upload le fichier vers le dossier ./wp-content/uploads/digirisk/document_template/
		$upload_dir = wp_upload_dir();
		$document_template_path = $upload_dir['basedir'] . '/digirisk/document_template/';
		wp_mkdir_p( $document_template_path );

		$attachment = get_post( $_POST['file_id'] );
		$attachment_current_path = str_replace( $upload_dir['url'], $upload_dir['path'] , $attachment->guid );
		$attachment_copy_path = str_replace( $upload_dir['url'], $document_template_path , $attachment->guid );

		$copy_status = copy( $attachment_current_path, $attachment_copy_path );

		if (!$copy_status) {
			return false;
		}

		// Génère les données du média
		$document_args = array(
			'post_content'	=> '',
			'post_status'	=> 'inherit',
			'post_author'	=> get_current_user_id(),
			'post_date'		=> current_time( 'mysql', 0 ),
			'post_title'	=> $attachment->title,
		);

		$response[ 'id' ] = wp_insert_attachment( $document_args, $attachment_copy_path, 0 );

		$attach_data = wp_generate_attachment_metadata( $response['id'], $attachment_copy_path );
		wp_update_attachment_metadata( $response['id'], $attach_data );
		wp_set_object_terms( $response[ 'id' ], array( $type, 'default_model', 'model' ), document_class::g()->attached_taxonomy_type );
		$response['model_id'] = $attachment_copy_path;
		attachment_class::g()->update( $response );

		return true;
	}
}
