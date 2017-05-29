<?php
/**
 * Les actions relatives à la gallerie.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package gallery
 * @subpackage action
 */
namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives à la gallerie.
 */
class Gallery_Action {

	/**
	 * Le constructeur appelle l'action ajax: wp_ajax_eo_set_thumbnail ainsi que dessociate_file
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_gallery', array( $this, 'callback_load_gallery' ) );
		add_action( 'wp_ajax_eo_set_thumbnail', array( $this, 'callback_set_thumbnail' ) );
		add_action( 'wp_ajax_dessociate_file', array( $this, 'callback_dessociate_file' ) );
	}

	/**
	 * Charges les images de la galerie selon l'id de la société.
	 *
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.9.0
	 */
	public function callback_load_gallery() {
		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		$namespace = ! empty( $_POST['namespace'] ) ? sanitize_text_field( $_POST['namespace'] ) : '';

		if ( 0 === $id ) {
			wp_send_json_error();
		}

		$data = array(
			'element_id' => $id,
			'title' => 'title',
			'object_name' => $type,
			'namespace' => $namespace
		);

		ob_start();
		Gallery_Class::g()->display( $data );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * Vérifie les données et appelle associate_file de la class file_management_class
	 *
	 * @since 0.1
	 * @version 6.2.9.0
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
		echo get_the_post_thumbnail( $element_id, 'thumbnail wp-digi-element-thumbnail' );
		$template = ob_get_clean();

		wp_send_json_success( array(
			'template' => $template,
			'elementId' => $element_id,
			'namespace' => 'digirisk',
			'module' => 'gallery',
			'callback_success' => 'successfulSetThumbnail',
		) );
	}

	/**
	 * Appelle la méthode dessociate_file de File_Management_Class
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.9.0
	 */
	public function callback_dessociate_file() {
		check_ajax_referer( 'dessociate_file' );

		$thumbnail_id = ! empty( $_POST['thumbnail_id'] ) ? (int) $_POST['thumbnail_id'] : 0;
		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$object_name = ! empty( $_POST['object_name'] ) ? sanitize_text_field( $_POST['object_name'] ) : '';
		$namespace = ! empty( $_POST['namespace'] ) ? sanitize_text_field( $_POST['namespace'] ) : '';
		$type = str_replace( 'digi-', '', $object_name );
		$type_class = $type . '_class';

		if ( empty( $thumbnail_id ) || empty( $element_id ) || empty( $object_name ) ) {
			wp_send_json_error();
		}

		if ( ! File_Management_Class::g()->dessociate_file( $thumbnail_id, $element_id, $type_class, $namespace ) ) {
			wp_send_json_error();
		}

		$model_name = '\\' . $namespace . '\\' . $type_class;
		$element = $model_name::g()->get( array( 'id' => $element_id ) );

		$close_popup = ( 0 === $element[0]->thumbnail_id ) ? true : false;

		ob_start();
		View_Util::exec( 'file_management', 'button', array( 'id' => $element_id, 'thumbnail' => true, 'title' => '', 'action' => 'eo_associate_file', 'file_id' => $thumbnail_id, 'type' => $type, 'type_class' => $type, 'element' => $element[0] ) );
		wp_send_json_success( array(
			'view' => ob_get_clean(),
			'closePopup' => $close_popup,
			'elementId' => $element_id,
			'namespace' => 'digirisk',
			'module' => 'gallery',
			'callback_success' => 'dessociatedFileSuccess',
		) );
	}
}

new Gallery_Action();
