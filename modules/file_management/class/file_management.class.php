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

class file_management_class {
  public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ) );
	}

	public function callback_admin_enqueue_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( 'wpeofiles-scripts', FILE_MANAGEMENT_URL . '/asset/js/file_management.backend.js', '', FILE_MANAGEMENT_VERSION );
		wp_enqueue_script( 'gallery', FILE_MANAGEMENT_URL . '/asset/js/gallery.backend.js', '', FILE_MANAGEMENT_VERSION );
	}

  // @TODO : Ajout du support multifichier, Sécurité nonce et $_POST['file_id']
  public function associate_file( $file_id, $element_id, $object_name, $thumbnail = true ) {
		global ${$object_name};
    $element = ${$object_name}->show( $element_id );

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

    ${$object_name}->update( $element );
  }
}

global $file_management_class;
$file_management_class = new file_management_class();
