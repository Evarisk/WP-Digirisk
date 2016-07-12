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
	/**
	* Le constructeur
	*/
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
  */
	public function callback_eo_upload_button( $param ) {
    $id = 0;
    $type = "";
		global $wpdigi_group_ctr;

    if ( !empty( $param['id'] ) ) {
      $id = (int) $param['id'];
    }

    if ( !empty( $param['type'] ) ) {
      $type = sanitize_text_field( $param['type'] );
    }

		if ( $id != 0 ) {
    	$element = society_class::get()->show_by_type( $id );
		}
		else {
			$element = null;
		}

		require( FILE_MANAGEMENT_VIEW_DIR . '/button.view.php' );
	}

	/**
  * Permet d'afficher la gallerie d'image
  *
  * @param array $param
	* @param int $param['element_id'] Le fichier sera associé à cette id
	* @param string $param['object_name'] Le post_type
  *
  */
	public function callback_shortcode_gallery( $param ) {
		$element_id = $param['element_id'];
		$element = society_class::get()->show_by_type( $element_id );

		$list_id = !empty( $element->option['associated_document_id']['image'] ) ? $element->option['associated_document_id']['image'] : array();
		$thumbnail_id = $element->thumbnail_id;

		require( FILE_MANAGEMENT_VIEW_DIR . '/gallery.view.php' );
  }
}

new file_management_shortcode();
