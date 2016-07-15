<?php
/**
* Les fonctions principales pour la gestion des fichiers
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class file_management_class extends singleton_util {
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
  public function associate_file( $file_id, $element_id, $object_name, $thumbnail = true ) {
		// if ( !is_int( $file_id ) || !is_int( $element_id ) || !is_string( $object_name ) || !is_bool( $thumbnail ) ) {
		// 	return false;
		// }

    $element = $object_name::get()->show( $element_id );

    if ( wp_attachment_is_image( $file_id ) ) {
      $element->option['associated_document_id']['image'][] = $file_id;

      if ( !empty( $thumbnail ) ) {
        set_post_thumbnail( $element_id, $file_id );
        $element->thumbnail_id = $file_id;
      }
    }
    else {
      $element->option['associated_document_id']['document'][] = $file_id;
    }

    $object_name::get()->update( $element );
  }
}
