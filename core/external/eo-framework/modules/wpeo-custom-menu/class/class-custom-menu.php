<?php
/**
 * Class Custom Menu.
 *
 * @author Eoxia <dev@eoxia>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2016-2019 Eoxia
 * @package EO_Framework\WPEO_Custom_Menu\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Custom_Menu_Class' ) ) {

	/**
	 * Class wpeo_custom_menu.
	 */
	class Custom_Menu_Class {

		public $page_title;
		public $menu_title;
		public $capability;
		public $menu_slug;
		public $function;
		public $icon_url;
		public $class;
		public $link;
		public $additional_attrs;
		public $other_slug;

		/**
		 * Position of menu.
		 *
		 * $type string
		 *
		 * @since 1.0.0
		 *
		 * Can Be top or bottom. Default is top.
		 */
		public $position = 'top';

		/**
		 * Init.
		 *
		 * @since 1.0.0
		 */
		public function __construct( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null ) {
			$this->page_title = $page_title;
			$this->menu_title = $menu_title;
			$this->capability = $capability;
			$this->menu_slug  = $menu_slug;
			$this->function   = $function;
			$this->link       = admin_url( 'admin.php?page=' . $menu_slug );
			$this->icon_url   = $icon_url;
			$this->position   = $position;
		}
	}
}
