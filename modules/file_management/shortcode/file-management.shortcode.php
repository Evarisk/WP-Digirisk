<?php
/**
 * Les shortcodes relatives à la gestion des fichiers.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package file_management
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les shortcodes relatives à la gestion des fichiers.
 */
class File_Management_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_shortcode( 'eo_upload_button', array( $this, 'callback_eo_upload_button' ) );
		add_shortcode( 'gallery', array( $this, 'callback_shortcode_gallery' ) );
	}

	/**
	 * Permet d'afficher le template pour upload une image
	 *
	 * @param array $param Les paramètres.
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function callback_eo_upload_button( $param ) {
		$id = 0;
		$type = '';
		$action = ! empty( $param['action'] ) ? sanitize_text_field( $param['action'] ) : 'eo_associate_file';
		$title = ! empty( $param['title'] ) ? sanitize_text_field( $param['title'] ) : '';
		$namespace = ! empty( $param['namespace'] ) ? sanitize_text_field( $param['namespace'] ) : 'digi';

		if ( ! empty( $param['id'] ) ) {
			$id = (int) $param['id'];
		}

		if ( ! empty( $param['type'] ) ) {
			$type = sanitize_text_field( $param['type'] );
		}

		if ( 0 !== $id ) {
			$post_type = get_post_type( $id );

			if ( ! $post_type ) {
				return false;
			}
			$model_name = '\\' . $namespace . '\\' . str_replace( 'digi-', '', $post_type ) . '_class';
			$establishment = $model_name::g()->get( array( 'include' => array( $id ) ) );
			$element = $establishment[0];
		} else {
			$element = null;
		}

		View_Util::exec( 'file_management', 'button', array( 'param' => $param, 'id' => $id, 'title' => $title, 'type' => $type, 'namespace' => $namespace, 'action' => $action, 'element' => $element ) );
	}

	/**
	 * Permet d'afficher la gallerie d'image
	 *
	 * @param array $param Les paramètres.
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function callback_shortcode_gallery( $param ) {
		Gallery_Class::g()->display( $param );
	}
}

new File_Management_Shortcode();
