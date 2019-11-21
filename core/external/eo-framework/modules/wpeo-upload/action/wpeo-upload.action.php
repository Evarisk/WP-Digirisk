<?php
/**
 * Actions for wpeo_upload.
 *
 * @author Eoxia <dev@eoxia>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2016-2018 Eoxia
 * @package EO_Framework\EO_Upload\Action
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\WPEO_Upload_Action' ) ) {
	/**
	 * Actions for wpeo_upload.
	 */
	class WPEO_Upload_Action {

		/**
		 * Add actions
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_scripts' ) );
			add_action( 'init', array( $this, 'callback_plugins_loaded' ) );

			add_action( 'wp_ajax_eo_upload_associate_file', array( $this, 'callback_associate_file' ) );
			add_action( 'wp_ajax_eo_upload_dissociate_file', array( $this, 'callback_dissociate_file' ) );

			add_action( 'wp_ajax_eo_upload_load_gallery', array( $this, 'callback_load_gallery' ) );
			add_action( 'wp_ajax_eo_upload_set_thumbnail', array( $this, 'callback_set_thumbnail' ) );
		}

		/**
		 * Charges le CSS et le JS de WPEO_Upload
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		public function callback_admin_scripts() {
			wp_enqueue_style( 'wpeo_upload_style', \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->url . '/assets/css/style.css', array() );
			wp_enqueue_script( 'wpeo_upload_script', \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->url . '/assets/js/wpeo-upload.js', array( 'jquery' ), \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->version );
		}

		/**
		 * Initialise le fichier MO
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		public function callback_plugins_loaded() {
			$path = str_replace( str_replace( '\\', '/', WP_PLUGIN_DIR ), '', str_replace( '\\', '/', \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path ) );
			load_plugin_textdomain( 'wpeo-upload', false, $path . '/asset/language/' );
		}

		/**
		 * Associate a file to an element.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @return void
		 * @todo: nonce
		 */
		public function callback_associate_file() {
			// check_ajax_referer( 'associate_file' );

			$data = WPEO_Upload_Class::g()->get_post_data( 'associate_file' );

			$view          = '';
			$document_view = '';

			if ( ! empty( $data['file_id'] ) && ! empty( $data['upload_dir'] ) ) {
				$wp_upload_dir = wp_upload_dir();
				$path          = str_replace( '\\', '/', $wp_upload_dir['path'] );
				$basedir       = str_replace( '\\', '/', $wp_upload_dir['basedir'] );
				$baseurl       = str_replace( '\\', '/', $wp_upload_dir['baseurl'] );

				$file      = get_post( $data['file_id'] );
				$file_path = str_replace( $wp_upload_dir['url'], $path, $file->guid );
				$basename  = basename( $file->guid );
				$new_path  = $basedir . '/' . $data['upload_dir'] . '/' . $basename;
				$new_url   = $baseurl . '/' . $data['upload_dir'] . '/' . $basename;

				rename( $file_path, $new_path );

				global $wpdb;

				$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET guid=%s WHERE ID=%d", array( $new_url, $data['file_id'] ) ) );
				update_post_meta( $data['file_id'], '_wp_attached_file', $data['upload_dir'] . '/' . $basename );
				set_post_type( $data['file_id'], 'wps-file' );
			}

			// If post ID is not empty.
			if ( ! empty( $data['id'] ) ) {
				if ( 'true' === $data['single'] ) {
					$element = WPEO_Upload_Class::g()->set_thumbnail( $data );
				} else {
					$element = WPEO_Upload_Class::g()->associate_file( $data );

					if ( empty( $element->data['thumbnail_id'] ) ) {
						$element = WPEO_Upload_Class::g()->set_thumbnail( $data );
					}
				}
				if ( ! empty( $element->data['id'] ) ) {
					ob_start();
					do_shortcode( '[wpeo_upload id="' . $element->data['id'] . '" model_name="' . str_replace( '\\', '/', $data['model_name'] ) . '" field_name="' . $data['field_name'] . '" mime_type="' . $data['mime_type'] . '" single="' . $data['single'] . '" size="' . $data['size'] . '" ]' );
					$view = ob_get_clean();
				}
			} else {
				if ( 'application' === $data['mime_type'] ) {
					$document_view = '<div class="document"><i class="icon fas fa-paperclip"></i></div>';
				}
			}

			if ( 'list' === $data['display_type'] ) {
				$filelink      = get_attached_file( $data['file_id'] );
				$filename_only = basename( $filelink );
				$file          = get_post( $data['file_id'] );
				$fileurl_only  = $file->guid;
				$field_name    = $data['field_name'];
				$file_id       = $data['file_id'];

				ob_start();
				$view = apply_filters( 'wpeo_upload_view_list_item', array(
					'view' => \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $data['display_type'] . '/list-item.view.php',
				) );
				require( $view );
				$view = ob_get_clean();
			}

			$media_view = wp_get_attachment_image( $data['file_id'], $data['size'] );

			wp_send_json_success( array(
				'view'          => $view,
				'document_view' => $document_view,
				'id'            => $data['id'],
				'display_type'  => $data['display_type'],
				'media'         => ! empty( $media_view ) ? $media_view : '',
			) );
		}

		/**
		 * Delete the index founded in the array
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @return void
		 */
		public function callback_dissociate_file() {
			$data = WPEO_Upload_Class::g()->get_post_data( 'dissociate_file' );

			$element = WPEO_Upload_Class::g()->dissociate_file( $data );

			ob_start();
			do_shortcode( '[wpeo_upload id="' . $element->data['date']['id'] . '" model_name="' . str_replace( '\\', '/', $data['model_name'] ) . '" field_name="' . $data['field_name'] . '" mime_type="' . $data['mime_type'] . '" single="' . $data['single'] . '" size="' . $data['size'] . '" ]' );
			wp_send_json_success( array(
				'namespace'        => '',
				'module'           => 'gallery',
				'callback_success' => 'dissociatedFileSuccess',
				'view'             => ob_get_clean(),
				'id'               => $data['id'],
				'close_popup'      => ! empty( $element->data['data']['associated_document_id'][ $data['field_name'] ] ) ? false : true,
			) );
		}

		/**
		 * Load all image and return the display gallery view.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @return void
		 */
		public function callback_load_gallery() {
			// check_ajax_referer( 'load_gallery' );

			$data = WPEO_Upload_Class::g()->get_post_data( 'load_gallery' );

			ob_start();
			require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $data['display_type'] . '/gallery/button-add.view.php' );
			$data['title'] .= ob_get_clean();

			ob_start();
			WPEO_Upload_Class::g()->display_gallery( $data );
			wp_send_json_success( array(
				'view' => ob_get_clean(),
			) );
		}

		/**
		 * Update the thumbnail of an element.
		 * The thumbnail ID is not used. The thumbnail of an element is the first index of the array $field_name.
		 *
		 * @since 0.1.0-alpha
		 * @version 1.0.0
		 *
		 * @return void
		 */
		public function callback_set_thumbnail() {
			$data = WPEO_Upload_Class::g()->get_post_data( 'set_thumbnail' );

			$element = WPEO_Upload_Class::g()->set_thumbnail( $data );

			ob_start();
			do_shortcode( '[wpeo_upload id="' . $element->data['id'] . '" model_name="' . str_replace( '\\', '/', $data['model_name'] ) . '" field_name="' . $data['field_name'] . '" mime_type="' . $data['mime_type'] . '" single="' . $data['single'] . '" size="' . $data['size'] . '" ]' );
			wp_send_json_success( array(
				'namespace' => '',
				'module' => 'gallery',
				'callback_success' => 'successfulSetThumbnail',
				'view' => ob_get_clean(),
				'id' => $data['id'],
				'file_id' => $data['file_id'],
			) );
		}
	}

	new WPEO_Upload_Action();
}
