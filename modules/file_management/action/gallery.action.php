<?php namespace digi;
/**
* Les actions pour la gestion des fichiers
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class Gallery_Action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_eo_set_thumbnail
	*/
  public function __construct() {
    add_action( 'wp_ajax_eo_set_thumbnail', array( $this, 'callback_set_thumbnail' ) );
		add_action( 'wp_ajax_dessociate_file', array( $this, 'callback_dessociate_file' ) );
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
		echo get_the_post_thumbnail( $element_id, 'thumbnail' );
		$template = ob_get_clean();

		wp_send_json_success( array( 'element_id' => $element_id, 'template' => $template ) );
	}

	/**
	 * Appelle la méthode dessociate_file de File_Management_Class
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.3.0
	 */
	public function callback_dessociate_file() {
		check_ajax_referer( 'dessociate_file' );

		$thumbnail_id = ! empty( $_POST['thumbnail_id'] ) ? (int) $_POST['thumbnail_id'] : 0;
		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$object_name = ! empty( $_POST['object_name'] ) ? sanitize_text_field( $_POST['object_name'] ) : '';
		$type = str_replace( 'digi-', '', $object_name );
		$type_class = $type . '_class';

		if ( empty( $thumbnail_id ) || empty( $element_id ) || empty( $object_name ) ) {
			wp_send_json_error();
		}

		if ( ! File_Management_Class::g()->dessociate_file( $thumbnail_id, $element_id, $type_class ) ) {
			wp_send_json_error();
		}

		$model_name = '\digi\\' . $type_class;
		$element = $model_name::g()->get( array( 'id' => $element_id ) );

		ob_start();
		view_util::exec( 'file_management', 'button', array( 'id' => $element_id, 'thumbnail' => true, 'title' => $title, 'action' => 'eo_associate_file', 'file_id' => $thumbnail_id, 'type' => $type, 'type_class' => $type, 'element' => $element[0] ) );
		wp_send_json_success( array( 'view' => ob_get_clean(), 'element_id' => $element_id, 'module' => 'gallery', 'callback_success' => 'dessociate_file_success' ) );
	}
}

new Gallery_Action();
