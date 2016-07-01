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
	protected function construct() {}

	// @TODO : Ajout du support multifichier, Sécurité nonce et $_POST['file_id']
  public function associate_file( $file_id, $element_id, $object_name, $thumbnail = true ) {
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
