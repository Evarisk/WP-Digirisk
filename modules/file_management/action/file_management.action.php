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
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_eo_associate_file
	*/
  public function __construct() {
    add_action( 'wp_ajax_eo_associate_file', array( $this, 'callback_associate_file' ) );
  }

  /**
  * Vérifie les données et appelle associate_file de la class file_management_class
  *
	* int $_POST['element_id'] Le fichier sera associé à cette ID
	* bool $_POST['thumbnail'] True pour mettre l'image en vignette
	* int $_POST['file_id'] L'ID du fichier
	*
  *  @param array $_POST Les données envoyées par le formulaire
  *
  */
  public function callback_associate_file() {
    check_ajax_referer( 'associate_file' );

    $id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
    $thumbnail = !empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
    $file_id = !empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
		$type = str_replace( 'digi-', '', $_POST['object_name'] );
		$type_class = $type . '_class';

    if ( 0 === $id || 0 === $file_id ) {
			wp_send_json_error();
    }

    file_management_class::g()->associate_file( $file_id, $id, $type_class, $thumbnail );
		$element = $type_class::g()->get( array( 'id' => $id ) );
		$element = $element[0];

    ob_start();
    require( FILE_MANAGEMENT_VIEW_DIR . '/button.view.php' );
    wp_send_json_success( array( 'template' => ob_get_clean() ));
  }
}

new file_management_action();
