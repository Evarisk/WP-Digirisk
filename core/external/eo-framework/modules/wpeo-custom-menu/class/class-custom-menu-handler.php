<?php
/**
 * Handle Custom Menu.
 *
 * @author Eoxia <dev@eoxia>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2016-2019 Eoxia
 * @package EO_Framework\WPEO_Custom_Menu\Class
 */

namespace eoxia;

use eoxia\Custom_Menu_Handler as CMH;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Custom_Menu_Handler' ) ) {

	/**
	 * Class wpeo_custom_menu.
	 */
	class Custom_Menu_Handler
	{
		private static $_instance = null;

		/**
		 * List of Menu.
		 *
		 * @since 1.0.0
		 */
		public static $menus = array();

		public static function getInstance() {
			if(is_null(self::$_instance)) {
				self::$_instance = new Custom_Menu_Handler();
			}

			return self::$_instance;
		}

		public static function add_logo( $parent_slug, $logo_src, $logo_url ) {
			self::$menus[ $parent_slug ]['logo'] = array(
				'src' => $logo_src,
				'url' => $logo_url,
			);
		}

		public static function register_container( $page_title, $menu_title, $capability, $menu_slug ) {
			add_menu_page( $page_title, $menu_title, $capability, $menu_slug );
		}

		/**
		 * Register a menu.
		 *
		 * @param string            $name Menu Name, ID.
		 * @param Class_Custom_Menu $menu Menu definition.
		 *
		 * @since 1.0.0
		 */
		public static function register_menu( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $fa_class = '', $position = null ) {
			$menu_wp = add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array( self::getInstance(), 'display' ) );

			$menu = null;

			$menu = new Custom_Menu_Class($page_title, $menu_title, $capability, $menu_slug, $function, $fa_class, $position);

			self::$menus[$parent_slug]['items'][$menu_slug] = apply_filters('eo_custom_menu_' . $parent_slug . '_' . $menu_slug, $menu);
			self::$menus[$parent_slug]['items'][$menu_slug]->wp = $menu_wp;
			self::$menus[$parent_slug]['position'] = $position;

			\eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->inserts_page[] = $menu_slug;

			return $menu;
		}

		public static function register_others_menu( $parent_slug, $other_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $fa_class = '', $position = null ) {
			$menu = self::register_menu($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function, $fa_class, $position);
			$menu->other_slug = $other_slug;
		}

		public function display() {
			$this->display_nav();
			$this->display_content();
		}

		public function display_nav() {
			global $current_screen;

			$menus = array();

			$menus[ $current_screen->parent_base ] = self::$menus[ $current_screen->parent_base ];
			$menus['others']                       = self::$menus['others'];

			foreach ( $menus['others']['items'] as $key => $menu ) {
				if ( isset( $menu->other_slug ) && $menu->other_slug !== $current_screen->parent_base ) {
					unset( $menus['others']['items'][ $key ] );
				}
			}

			$logo_url = $menus[ $current_screen->parent_base ]['logo']['url'];
			$logo_src = $menus[ $current_screen->parent_base ]['logo']['src'];

			require_once PLUGIN_EO_FRAMEWORK_PATH . '/modules/wpeo-custom-menu/view/nav.view.php';
		}

		public function display_content() {
			global $current_screen;

			$current_user = wp_get_current_user();

			$parent_menu = $current_screen->parent_base;
			$page        = $_GET['page'];

			$menu = self::$menus[ $parent_menu ]['items'][ $page ];

			require_once PLUGIN_EO_FRAMEWORK_PATH . '/modules/wpeo-custom-menu/view/content.view.php';
		}

		public function display_screen_option() {
			$current_screen = get_current_screen();

			if ( ! empty( $current_screen->get_options() ) ) {
				require_once PLUGIN_EO_FRAMEWORK_PATH . '/modules/wpeo-custom-menu/view/screen-options.view.php';
			}
		}
	}
}
