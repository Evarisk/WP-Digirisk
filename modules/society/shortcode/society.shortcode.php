<?php

namespace digi;

/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage filter
*/
if ( !defined( 'ABSPATH' ) ) exit;

class Society_Shortcode {
	/**
	* Le constructeur
	*/
  public function __construct() {
    add_shortcode( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ) );
		add_shortcode( 'digi-configuration', array( $this, 'callback_configuration' ) );
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

		$groupments = Group_Class::g()->get( array( 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ), 'posts_per_page' => -1, 'post_status' => array( 'publish', 'draft' ) ) );

		if ( $element ) {
			$tab_to_display = !empty( $param['tab_to_display'] ) ? $param['tab_to_display'] : 'digi-risk';
			if ( $element->type == 'digi-group' ) {
				$group_list = group_class::g()->get( array( 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ), 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ) );
				$element_id = ! empty( $group_list ) ? $group_list[0]->id : 0;
				if ( $element_id === $id ) {
					$display_trash = false;
				}
			}

			view_util::exec( 'society', 'content', array( 'display_trash' => $display_trash, 'groupments' => $groupments, 'element' => $element, 'tab_to_display' => $tab_to_display ) );
		}
  }

	/**
	 * Affiches le formulaire pour configurer un groupement
	 *
	 * @param array $param Les paramètres du shortcode.
	 *
	 * @return void
	 */
	public function callback_configuration( $param ) {
		$element_id = $param['post_id'];
		$element = Society_Class::g()->show_by_type( $element_id );

		Society_Configuration_Class::g()->display( $element );
	}
}

new Society_Shortcode();
