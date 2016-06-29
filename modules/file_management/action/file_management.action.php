<?php
/**
* Les actions pour la gestion des fichiers
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class file_management_action {
  public function __construct() {
    add_action( 'wp_ajax_eo_associate_file', array( $this, 'callback_associate_file' ) );
  }

  /**
  * Vérifie les données et appelle associate_file de la class file_management_class
  *
  * @param array $_POST
  * @param int $_POST['element_id'] Le fichier sera associé à cette id
  * @param bool $_POST['thumbnail'] True pour mettre l'image en vignette
  * @param int $_POST['file_id'] L'id du fichier
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return application/json data.template Le template html pour mettre à jour le bouton
  */
  public function callback_associate_file() {
    check_ajax_referer( 'associate_file' );

    $element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
    $thumbnail = !empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
    $file_id = !empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;

    if ( 0 === $element_id || 0 === $file_id ) {
			wp_send_json_error();
    }

    $object_name = str_replace( 'digi-', '', sanitize_title( $_POST['object_name'] ) ) . '_class';

    file_management_class::get()->associate_file( $file_id, $element_id, $object_name, $thumbnail );

    ob_start();
    require( FILE_MANAGEMENT_VIEW_DIR . '/button.view.php' );
    wp_send_json_success( array( 'template' => ob_get_clean() ));
  }
}

new file_management_action();
