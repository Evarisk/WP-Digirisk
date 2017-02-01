<?php
/**
 * La classe gérant la galerie.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package file_management
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * La classe gérant la galerie.
 */
class Gallery_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	protected function construct() {}

	/**
	 * Permet d'afficher la galerie d'image
	 *
	 * @param array $param Les paramètres.
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function display( $param ) {
		if ( ! is_array( $param ) ) {
			return false;
		}

		$element_id = $param['element_id'];
		$element = society_class::g()->show_by_type( $element_id, array( false ) );

		$title = ! empty( $param['title'] ) ? sanitize_text_field( $param['title'] ) : '';
		$action = ! empty( $param['action'] ) ? sanitize_text_field( $param['action'] ) : 'eo_associate_file';

		$list_id = ! empty( $element->associated_document_id['image'] ) ? $element->associated_document_id['image'] : array();
		$thumbnail_id = $element->thumbnail_id;

		View_Util::exec( 'file_management', 'gallery', array( 'param' => $param, 'title' => $title, 'element_id' => $element_id, 'element' => $element, 'action' => $action, 'list_id' => $list_id, 'thumbnail_id' => $thumbnail_id ) );
	}
}

Gallery_Class::g();
