<?php
/**
 * Actions for Custom Menu.
 *
 * @author Eoxia <dev@eoxia>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2016-2019 Eoxia
 * @package EO_Framework\WPEO_Custom_Menu\Action
 */

namespace eoxia;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Custom_Menu_Action' ) ) {
	/**
	 * Actions for wpeo_custom_menu.
	 */
	class Custom_Menu_Action {

		/**
		 * Declare Actions.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_scripts' ) );
			add_action( 'wp_ajax_save_menu_state', array( $this, 'save_menu_state' ) );

			add_action( 'admin_menu', array( $this, 'add_others' ), 99 );
		}

		/**
		 * Load CSS and JS.
		 *
		 * @since 1.0.0
		 */
		public function callback_admin_scripts() {
			$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : ''; // WPCS: input var ok, CSRF ok.
			if ( in_array( $page, \eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->inserts_page, true ) ) {
				wp_enqueue_style('wpeo_custom_menu_style', \eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->url . '/asset/css/wpeo-custom-menu.css', array());
				wp_enqueue_script('wpeo_custom_menu_script', \eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->url . '/asset/js/wpeo-custom-menu.js', array('jquery'), \eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->version);
			}
		}

		public function save_menu_state() {
			$minimize_menu = get_user_meta( get_current_user_id(), '_eo_menu_minimize', true );
			$minimize_menu = empty( $minimize_menu ) ? false : $minimize_menu;

			$minimize_menu = ! $minimize_menu;

			update_user_meta( get_current_user_id(), '_eo_menu_minimize', $minimize_menu );
			wp_send_json_success();
		}

		public function add_others() {
			Custom_Menu_Handler::register_menu( 'others', 'Go to WP Admin', 'Go to WP Admin', 'manage_options', 'go-to-wp-admin', '', 'fa fa-tachometer-alt', 'bottom' );
			Custom_Menu_Handler::$menus['others']['items']['go-to-wp-admin']->link = admin_url( 'index.php' );

			$minimize_menu = get_user_meta( get_current_user_id(), '_eo_menu_minimize', true );
			$minimize_menu = empty( $minimize_menu ) ? false : true;
			$icon_minimize = $minimize_menu ? 'fa fa-arrow-right' : 'fa fa-arrow-left';

			Custom_Menu_Handler::register_menu( 'others', 'Minimize menu', 'Minimize menu', 'manage_options', 'minimize-menu', '', $icon_minimize, 'bottom' );
			Custom_Menu_Handler::$menus['others']['items']['minimize-menu']->link              = '#';
			Custom_Menu_Handler::$menus['others']['items']['minimize-menu']->class            .= ' minimize-menu action-attribute ';
			Custom_Menu_Handler::$menus['others']['items']['minimize-menu']->additional_attrs .= 'data-action=save_menu_state';
		}
	}

	new Custom_Menu_Action();
}
