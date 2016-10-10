<?php namespace digi;
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
		$action = !empty( $param['action'] ) ? sanitize_text_field( $param['action'] ) : 'eo_associate_file';

    if ( !empty( $param['id'] ) ) {
      $id = (int) $param['id'];
    }

    if ( !empty( $param['type'] ) ) {
      $type = sanitize_text_field( $param['type'] );
    }

		if ( $id != 0 ) {
    	$element = society_class::g()->show_by_type( $id, array( 'false' ) );
		}
		else {
			$element = null;
		}

		view_util::exec( 'file_management', 'button', array( 'param' => $param, 'id' => $id, 'type' => $type, 'action' => $action, 'element' => $element ) );
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
		if ( !is_array( $param ) ) {
			return false;
		}

		$element_id = $param['element_id'];
		$element = society_class::g()->show_by_type( $element_id, array( false ) );

		$action = !empty( $param['action'] ) ? sanitize_text_field( $param['action'] ) : 'eo_associate_file';

		$list_id = !empty( $element->associated_document_id['image'] ) ? $element->associated_document_id['image'] : array();
		$thumbnail_id = $element->thumbnail_id;

		view_util::exec( 'file_management', 'gallery', array( 'param' => $param, 'element_id' => $element_id, 'element' => $element, 'action' => $action, 'list_id' => $list_id, 'thumbnail_id' => $thumbnail_id ) );
  }
}

new file_management_shortcode();
