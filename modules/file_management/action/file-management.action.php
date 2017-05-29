<?php
/**
 * Les actions relatives à la gestion des fichiers
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package file_management
 * @subpackage action
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives à la gestion des fichiers
 */
class File_Management_Action {
	/**
	 * Le constructeur appelle l'action ajax: wp_ajax_eo_associate_file
	 */
	public function __construct() {
		add_action( 'wp_ajax_eo_associate_file', array( $this, 'callback_associate_file' ) );
		add_action( 'wp_ajax_eo_set_model', array( $this, 'callback_set_model' ) );
	}

	/**
	 * Vérifie les données et appelle associate_file de la class file_management_class
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_associate_file() {
		check_ajax_referer( 'associate_file' );

		$id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$thumbnail = ! empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
		$action = ! empty( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : 'eo_associate_file';
		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$file_id = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
		$type = str_replace( 'digi-', '', $_POST['object_name'] );
		$namespace = sanitize_text_field( $_POST['namespace'] );
		$type_class = $type . '_class';

		if ( 0 === $id || 0 === $file_id ) {
			wp_send_json_error();
		}

		File_Management_Class::g()->associate_file( $file_id, $id, $type_class, $namespace, $thumbnail );
		$type_class = '\\' . $namespace . '\\' . $type_class;
		$element = $type_class::g()->get( array( 'id' => $id ) );
		$element = $element[0];

		ob_start();
		View_Util::exec( 'file_management', 'button', array( 'id' => $id, 'thumbnail' => $thumbnail, 'title' => $title, 'action' => $action, 'file_id' => $file_id, 'type' => $type, 'namespace' => $namespace, 'type_class' => $type, 'element' => $element ) );
		wp_send_json_success( array(
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Appelle la méthode "upload_model" de "File_Management_Class"
	 *
	 * @since 6.2.1.0
	 * @version 6.2.4.0
	 */
	public function callback_set_model() {
		check_ajax_referer( 'associate_file' );

		$id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$thumbnail = ! empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
		$action = ! empty( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : 'eo_associate_file';
		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$file_id = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';

		if ( ! File_Management_Class::g()->upload_model( $type ) ) {
			wp_send_json_error();
		}

		ob_start();
		do_shortcode( '[digi-handle-model]' );
		wp_send_json_success( array(
			'type' => 'set_model',
			'template' => ob_get_clean(),
		) );
	}
}

new File_Management_Action();
