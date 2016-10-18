<?php

namespace digi;

/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage filter
*/
if ( !defined( 'ABSPATH' ) ) exit;

class society_shortcode {
	/**
	* Le constructeur
	*/
  public function __construct() {
    add_shortcode( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ) );
  }

  /**
	* Affiches le contenu d'un établissement
	*
	* @param array $param
  */
  public function callback_digi_dashboard( $param ) {
		$id = !empty( $param['id'] ) ? (int)$param['id'] : 0;
    $element = society_class::g()->show_by_type( $id, array( 'list_group' ) );
		$display_trash = true;

		if ( $element ) {
			$tab_to_display = !empty( $param['tab_to_display'] ) ? $param['tab_to_display'] : 'digi-evaluator';

			if ( $element->type == 'digi-group' ) {
				$group_list = group_class::g()->get( array( 'order' => 'ASC', 'posts_per_page' => 1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), array( false ) );
				$element_id = !empty( $group_list ) ? $group_list[0]->id : 0;

				if ( $element_id === $id ) {
					$display_trash = false;
				}
			}

			view_util::exec( 'society', 'content', array( 'element' => $element, 'tab_to_display' => $tab_to_display ) );
		}
  }
}

new society_shortcode();
