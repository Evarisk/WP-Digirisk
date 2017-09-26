<?php
/**
 * Les actions relatives à la page 'Organiseur'
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives à la page 'Organiseur'
 */
class Page_Sorter_Action {

	/**
	 * Le constructeur ajoutes les actions WordPress suivantes:
	 * -admin_menu
	 * -admin_post_sorter_parent
	 *
	 * @since 6.0.0
	 * @version 6.2.5
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 15 );
		add_action( 'admin_post_sorter_parent', array( $this, 'callback_sorter_parent' ) );
	}

	/**
	 * Définition du menu dans l'administration de WordPress pour Digirisk
	 *
	 * @since 6.0.0
	 * @version 6.2.5
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Organiseur', 'digirisk' ), __( 'Organiseur', 'digirisk' ), 'manage_digirisk', 'digirisk-handle-sorter', array( Page_Sorter_Class::g(), 'display' ) );
	}

	/**
	 * Met le parent_id à l'élément.
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.5
	 */
	public function callback_sorter_parent() {
		check_admin_referer( 'callback_sorter_parent' );

		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$array_order = array();

		if ( ! empty( $_POST['menu_item_db_id'] ) ) {
			foreach ( $_POST['menu_item_db_id'] as $element_id ) {
				$element_id = (int) $element_id;
				$parent_id = (int) $_POST['menu_item_parent_id'][ $element_id ];

				$society = Society_Class::g()->show_by_type( $element_id );
				$society->parent_id = $parent_id;

				if ( empty( $society->parent_id ) ) {
					$society->parent_id = $main_society->id;
				}

				// Met le menu order.
				if ( empty( $array_order[ $parent_id ] ) ) {
					$array_order[ $parent_id ] = 0;
				}

				$society->order = $array_order[ $parent_id ];
				$array_order[ $parent_id ]++;

				Society_Class::g()->update_by_type( $society );
			}
		}

		set_transient( 'display_notice', true, 5 );
		wp_safe_redirect( wp_get_referer() );
	}
}

new Page_Sorter_Action();
