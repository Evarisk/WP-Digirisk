<?php
/**
 * Call the main view of the plugin.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Shortcode
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\WPEO_Upload_Shortcode' ) ) {

	/**
	 * Call the main view of the plugin.
	 */
	class WPEO_Upload_Shortcode extends Singleton_Util {

		/**
		 * Add the shortcode [wpeo_upload].
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 */
		protected function construct() {
			add_shortcode( 'wpeo_upload', array( $this, 'wpeo_upload' ) );
		}

		/**
		 * Call the button view
		 * Developper: WPEO_Model is required for use this shortcode.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @see https://github.com/Eoxia/eo-framework/blob/master/modules/wpeo-upload/README.md
		 *
		 * @param  array $atts See paramaters in func.
		 *
		 * @return HTML Le code html permettant l'affichage du module d'upload
		 */
		public function wpeo_upload( $atts ) {

			// Parameters of the shortcode.
			$atts = shortcode_atts( array(
				'id'           => 0,                                   // The id of the POST Element (Can be a custom post).
				'title'        => __( 'Upload media', 'wpeo-upload' ), // Popup title.
				'mode'         => 'edit',                              // Can be "edit" or "view".
				'field_name'   => 'thumbnail_id',                      // For use "_thumbnail_id" postmeta of WordPress let _thumbnail_id. Again for more details @see.
				'model_name'   => '//eoxia//Post_Class',               // Say to WPEO_Model the model used. Write double slashes when use in shortcode. This method convert it from "//" to "\".
				'custom_class' => '',                                  // Add custom class.
				'size'         => 'thumbnail',                         // The size of the box (button for upload or open the gallery).
				'single'       => 'true',                              // One media or more.
				'mime_type'    => 'image',                             // Can be application, image, audio or empty for all mime types. By default "image".
				'display_type' => 'box',                               // Can be box or list. By default box.
				'upload_dir'   => '',                                  // Empty for default WordPress upload dir.
			), $atts );

			// Convert "//" to "\".
			if ( ! empty( $atts['model_name'] ) ) {
				$atts['model_name'] = str_replace( '/', '\\', $atts['model_name'] );
			}

			// Load the POST element with WPEO_Model.
			$args = array( 'id' => $atts['id'] );

			if ( empty( $atts['id'] ) ) {
				$args = array( 'schema' => true );
			}

			$element = $atts['model_name']::g()->get( $args, true );
			$main_picture_id = $element->data['thumbnail_id'];

			if ( empty( $main_picture_id ) ) {
				$nonce_name = 'associate_file';
			} else {
				$nonce_name = 'load_gallery';
			}

			$field_name = $atts['field_name'];

			$no_file_class = '';
			if ( empty( $main_picture_id ) && empty( $element->data['associated_document_id'][ $atts['field_name'] ] ) ) {
				$no_file_class = 'no-file';
			} else {
				$nonce_name = 'load_gallery';
			}

			ob_start();
			require \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $atts['display_type'] . '/button.view.php';

			return ob_get_clean();
		}

	}

	new WPEO_Upload_Shortcode();
}
