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

class gallery_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_eo_set_thumbnail
	*/
  public function __construct() {
    add_action( 'wp_ajax_eo_set_thumbnail', array( $this, 'callback_set_thumbnail' ) );
  }

	/**
  * Vérifie les données et appelle associate_file de la class file_management_class
  *
	* int $_POST['element_id'] Le fichier sera associé à cette ID
	* int $_POST['thumbnail_id'] L'ID du thumbnail
	*
  * @param array $_POST Les données envoyées par le formulaire
  *
  */
	public function callback_set_thumbnail() {
		if ( 0 === (int) $_POST['element_id'] )
			wp_send_json_error();
		else {
			$element_id = (int) $_POST['element_id'];
		}

		if ( 0 === (int) $_POST['thumbnail_id'] )
			wp_send_json_error();
		else {
			$thumbnail_id = (int) $_POST['thumbnail_id'];
		}

		set_post_thumbnail( $element_id, $thumbnail_id );

		ob_start();
		echo get_the_post_thumbnail( $element_id, 'digirisk-element-miniature' );
		$template = ob_get_clean();

		wp_send_json_success( array( 'template' => $template ) );
	}
}

new gallery_action();
