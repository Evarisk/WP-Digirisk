<?php
/**
 * All methods utils for associate, dessociate and anothers things about upload.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\WPEO_Upload_Class' ) ) {

	/**
	 * All methods utils for associate, dessociate and anothers things about upload.
	 */
	class WPEO_Upload_Class extends \eoxia\Singleton_Util {

		/**
		 * Need to be declared for Singleton_Util.
		 *
		 * @since 0.1.0-alpha
		 * @version 0.1.0-alpha
		 */
		protected function construct() {}

		/**
		 * Get and sanitize $_POST data and return it.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param string $nonce_name Nonce name from the request AJAX.
		 *
		 * @return array $param {
		 *     Les variables renvoyées.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $title        The popup title.
		 *     @type string  $mode         Can be "edit" or "view".
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type string  $custom_class Add custom class.
		 *     @type string  $size         The size of the box (button for upload or open the gallery).
		 *     @type boolean $single       One media or more.
		 *     @type string  $mime_type    Can be application/document, application/png or empty for all mime types.
		 *     @type string  $display_type Can be box or list. By default box.
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 */
		public function get_post_data( $nonce_name ) {
			// check_ajax_referer( $nonce_name );

			$data                 = array();
			$data['id']           = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
			$data['title']        = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
			$data['mode']         = ! empty( $_POST['mode'] ) ? sanitize_text_field( $_POST['mode'] ) : '';
			$data['field_name']   = ! empty( $_POST['field_name'] ) ? sanitize_text_field( $_POST['field_name'] ) : '';
			$data['model_name']   = ! empty( $_POST['model_name'] ) ? stripslashes( sanitize_text_field( $_POST['model_name'] ) ) : '';
			$data['custom_class'] = ! empty( $_POST['custom_class'] ) ? stripslashes( sanitize_text_field( $_POST['custom_class'] ) ) : '';
			$data['size']         = ! empty( $_POST['size'] ) ? sanitize_text_field( $_POST['size'] ) : 'thumbnail';
			$data['single']       = ! empty( $_POST['single'] ) ? sanitize_text_field( $_POST['single'] ) : 'false';
			$data['mime_type']    = ! empty( $_POST['mime_type'] ) ? sanitize_text_field( $_POST['mime_type'] ) : '';
			$data['display_type'] = ! empty( $_POST['display_type'] ) ? sanitize_text_field( $_POST['display_type'] ) : '';
			$data['file_id']      = ! empty( $_POST['file_id'] ) ? (int) $_POST['file_id'] : 0;
			$data['upload_dir']   = ! empty( $_POST['upload_dir'] ) ? sanitize_text_field( $_POST['upload_dir'] ) : '';

			return $data;
		}

		/**
		 * Associate the file_id in the Object.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @param array $data {
		 *     Les variables du tableau.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 *
		 * @return mixed
		 */
		public function associate_file( $data ) {
			$element = null;

			if ( ! empty( $data['id'] ) ) {
				$element = $data['model_name']::g()->get( array(
					'id' => $data['id'],
				), true );

				$element->data['associated_document_id'][ $data['field_name'] ][] = (int) $data['file_id'];
				$data['model_name']::g()->update( $element->data );
			}

			return $element;
		}

		/**
		 * Dessociate the file_id in the Object.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @param array $data {
		 *     Les variables du tableau.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 *
		 * @return mixed
		 */
		public function dissociate_file( $data ) {
			$element = $data['model_name']::g()->get( array(
				'id' => $data['id'],
			), true );

			// Check if the file is in associated file list.
			if ( isset( $element->data['associated_document_id'] ) && isset( $element->data['associated_document_id'][ $data['field_name'] ] ) ) {
				$key = array_search( $data['file_id'], $element->data['associated_document_id'][ $data['field_name'] ], true );
				if ( false !== $key ) {
					array_splice( $element->data['associated_document_id'][ $data['field_name'] ], $key, 1 );
				}
			}

			// Check if the file is set as thumbnail.
			if ( $data['file_id'] === $element->data['thumbnail_id'] ) {
				$element->data['thumbnail_id'] = 0;
			}

			// Set another thumbnail id.
			if ( empty( $element->data['thumbnail_id'] ) && ! empty( $element->data['associated_document_id'][ $data['field_name'] ] ) ) {
				$element->data['thumbnail_id'] = $element->data['associated_document_id'][ $data['field_name'] ][0];
			}

			$data['model_name']::g()->update( $element->data );

			return $element;
		}

		/**
		 * Load and display the gallery.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @param array $data {
		 *     Les variables du tableau.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $title        The popup title.
		 *     @type string  $mode         Can be "edit" or "view".
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type string  $custom_class Add custom class.
		 *     @type string  $size         The size of the box (button for upload or open the gallery).
		 *     @type boolean $single       One media or more.
		 *     @type string  $mime_type    Can be application/document, application/png or empty for all mime types.
		 *     @type string  $display_type Can be box or list. By default box.
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 *
		 * @return void
		 */
		public function display_gallery( $data ) {
			$element = $data['model_name']::g()->get( array(
				'id' => $data['id'],
			), true );

			$main_picture_id = $element->data['thumbnail_id'];

			if ( empty( $main_picture_id ) ) {
				$main_picture_id = $element->data['associated_document_id'][ $data['field_name'] ][0];
			}

			$list_id = ! empty( $element->data['associated_document_id'][ $data['field_name']  ] ) ? $element->data['associated_document_id'][ $data['field_name'] ] : array();

			require \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/box/gallery/main.view.php';
		}

		/**
		 * Set the thumbnail.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @param array $data {
		 *     Les variables du tableau.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 *
		 * @return mixed
		 */
		public function set_thumbnail( $data ) {
			$element = $data['model_name']::g()->get( array( 'id' => $data['id'] ), true );

			$element->data['thumbnail_id'] = $data['file_id'];

			$element = $data['model_name']::g()->update( $element->data );

			return $element;
		}

		/**
		 * Output all attributes to send to the AJAX request.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param array $data {
		 *     Les variables du tableau.
		 *
		 *     @type integer $id           The id of the POST Element (Can be a custom post).
		 *     @type string  $title        The popup title.
		 *     @type string  $mode         Can be "edit" or "view".
		 *     @type string  $field_name   For use "_thumbnail_id" postmeta of WordPress let it empty.
		 *     @type string  $model_name   Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
		 *     @type string  $custom_class Add custom class.
		 *     @type string  $size         The size of the box (button for upload or open the gallery).
		 *     @type boolean $single       One media or more.
		 *     @type string  $mime_type    Can be application/document, application/png or empty for all mime types.
		 *     @type string  $display_type Can be box or list. By default box.
		 *     @type integer $file_id      The uploaded file ID.
		 * }
		 *
		 * @return void
		 */
		public function out_all_attributes( $data ) {
			require \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/box/gallery/attributes.view.php';
		}
	}

	WPEO_Upload_Class::g();
}
