<?php
/**
* Add shortcode
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class file_management_shortcode {
	public function __construct() {
		add_shortcode( 'eo_upload_button', array( $this, 'callback_eo_upload_button' ) );
		add_shortcode( 'wpeo_gallery', array( $this, 'callback_shortcode_gallery' ) );
	}

	/**
  * Permet d'afficher le template pour upload une image
  *
  * @param array $param
	* @param int $param['id'] Le fichier sera associé à cette id
	* @param string $param['type'] Le post_type
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
	public function callback_eo_upload_button( $param ) {
    $id = 0;
    $type = "";
		global $wpdigi_group_ctr;

    if ( !empty( $param['id'] ) ) {
      $id = (int) $param['id'];
    }

    if ( !empty( $param['object_name'] ) ) {
      $type = sanitize_text_field( $param['object_name'] );
    }

    $element = $wpdigi_group_ctr->show( $id );

		require( FILE_MANAGEMENT_VIEW_DIR . '/button.view.php' );
	}

	/**
  * Permet d'afficher la gallerie d'image
  *
  * @param array $param
	* @param int $param['element_id'] Le fichier sera associé à cette id
	* @param string $param['object_name'] Le post_type
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
	public function callback_shortcode_gallery( $param ) {
		$element_id = $param['element_id'];
  	global ${$param['object_name']};
		$element = ${$param['object_name']}->show( $element_id );

		$list_id = !empty( $element->option['associated_document_id']['image'] ) ? $element->option['associated_document_id']['image'] : array();
		$thumbnail_id = $element->thumbnail_id;

		require( FILE_MANAGEMENT_VIEW_DIR . '/gallery.view.php' );
  }
}

new file_management_shortcode();
