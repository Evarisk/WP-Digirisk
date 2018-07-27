<?php
/**
 * Les shortcodes relatif aux sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les shortcodes relatif aux sociétés
 */
class Society_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ) );
		add_shortcode( 'digi-informations', array( $this, 'callback_informations' ) );
	}

	/**
	 * Affiches le contenu d'un établissement
	 *
	 * @since 6.2.10
	 * @version 6.3.0
	 *
	 * @param array $param Les arguments du shortcode.
	 */
	public function callback_digi_dashboard( $param ) {
		$id = ! empty( $param['id'] ) ? (int) $param['id'] : 0;
		$element = society_class::g()->show_by_type( $id );
		$display_trash = true;

		if ( $element ) {
			$tab_to_display = ( $element->type !== Society_Class::g()->get_post_type() ) ? 'digi-risk' : \eoxia001\Config_Util::$init['digirisk']->default_tab;

			if ( ! empty( $param['tab_to_display'] ) ) {
				$tab_to_display = $param['tab_to_display'];
			}

			$title = \eoxia001\Config_Util::$init['digirisk']->default_tab_title . ' ';
			if ( Society_Class::g()->get_post_type() !== $element->type ) {
				$title .= $element->unique_identifier . ' - ';
			} else {
				$title = 'Informations ';
			}
			$title .= $element->title;

			if ( 'digi-group' === $element->type ) {
				$group_list = group_class::g()->get( array( 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ), 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft' ) ) );
				$element_id = ! empty( $group_list ) ? $group_list[0]->id : 0;
				if ( $element_id === $id ) {
					$display_trash = false;
				}
			}

			\eoxia001\View_Util::exec( 'digirisk', 'society', 'content', array(
				'title' => $title,
				'display_trash' => $display_trash,
				'element' => $element,
				'tab_to_display' => $tab_to_display,
			) );
		}
	}

	/**
	 * Affiches le formulaire pour configurer un groupement
	 *
	 * @param array $param Les paramètres du shortcode.
	 *
	 * @return void
	 *
	 * @since 1.0.0.0
	 * @version 6.2.10.0
	 */
	public function callback_informations( $param ) {
		$element_id = $param['post_id'];
		$element = Society_Class::g()->show_by_type( $element_id );

		Society_Informations_Class::g()->display( $element );
	}
}

new Society_Shortcode();
