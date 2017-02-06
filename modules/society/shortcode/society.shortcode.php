<?php
/**
 * Les shortcodes relatif aux sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package establishment
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les shortcodes relatif aux sociétés
 */
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
	 * @param array $param Les arguments du shortcode.
	 */
	public function callback_digi_dashboard( $param ) {
		$id = ! empty( $param['id'] ) ? (int) $param['id'] : 0;
		$element = society_class::g()->show_by_type( $id );
		$display_trash = true;

		if ( $element ) {
			$tab_to_display = ! empty( $param['tab_to_display'] ) ? $param['tab_to_display'] : Config_Util::$init['digirisk']->default_tab;
			$title = Config_Util::$init['digirisk']->default_tab_title . ' ' . $element->unique_identifier . ' - ' . $element->title;
			if ( 'digi-group' === $element->type ) {
				$group_list = group_class::g()->get( array( 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ), 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft' ) ) );
				$element_id = ! empty( $group_list ) ? $group_list[0]->id : 0;
				if ( $element_id === $id ) {
					$display_trash = false;
				}
			}

			view_util::exec( 'society', 'content', array( 'title' => $title, 'display_trash' => $display_trash, 'element' => $element, 'tab_to_display' => $tab_to_display ) );
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
