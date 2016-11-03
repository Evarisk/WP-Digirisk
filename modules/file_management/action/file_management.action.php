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

if ( ! defined( 'ABSPATH' ) ) { exit;
}

class file_management_action {
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
	 * int $_POST['element_id'] Le fichier sera associé à cette ID
	 * bool $_POST['thumbnail'] True pour mettre l'image en vignette
	 * int $_POST['file_id'] L'ID du fichier
	 *
	 *  @param array $_POST Les données envoyées par le formulaire
	 */
	public function callback_associate_file() {
		check_ajax_referer( 'associate_file' );

		$id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$thumbnail = ! empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
		$action = ! empty( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : 'eo_associate_file';
		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$file_id = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
		$type = str_replace( 'digi-', '', $_POST['object_name'] );
		$type_class = $type . '_class';

		if ( 0 === $id || 0 === $file_id ) {
			wp_send_json_error();
		}

		file_management_class::g()->associate_file( $file_id, $id, $type_class, $thumbnail );
		$type_class = '\digi\\' . $type_class;
		$element = $type_class::g()->get( array( 'id' => $id ) );
		$element = $element[0];

		ob_start();
		view_util::exec( 'file_management', 'button', array( 'id' => $id, 'thumbnail' => $thumbnail, 'title' => $title, 'action' => $action, 'file_id' => $file_id, 'type' => $type, 'type_class' => $type, 'element' => $element ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function callback_set_model() {
		check_ajax_referer( 'associate_file' );

		$id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$thumbnail = ! empty( $_POST['thumbnail'] ) ? (bool) $_POST['thumbnail'] : false;
		$action = ! empty( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : 'eo_associate_file';
		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$file_id = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
		$type = ! empty( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';

		if ( ! file_management_class::g()->upload_model( $type ) ) {
			wp_send_json_error();
		}

		ob_start();
		do_shortcode( '[digi-handle-model]' );
		wp_send_json_success( array( 'type' => 'set_model', 'template' => ob_get_clean() ) );
	}
}

new file_management_action();
