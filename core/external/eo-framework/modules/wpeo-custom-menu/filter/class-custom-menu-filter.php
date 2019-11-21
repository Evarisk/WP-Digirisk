<?php
/**
 * Filters for Custom Menu.
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

if ( ! class_exists( '\eoxia\Custom_Menu_Filter' ) ) {
	/**
	 * Filters for wpeo_custom_menu.
	 */
	class Custom_Menu_Filter {

		/**
		 * Declare Filters.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_filter( 'admin_body_class', array( $this, 'custom_body_class' ) );

			add_filter( 'eoxia_main_header_ul_after', array( $this, 'add_header_multisite' ) );
		}

		public function custom_body_class( $classes ) {
			$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : ''; // WPCS: input var ok, CSRF ok.
			if ( in_array( $page, \eoxia\Config_Util::$init['eo-framework']->wpeo_custom_menu->inserts_page, true ) ) {
				$classes .= " eo-custom-page ";
			}

			return $classes;
		}

		public function add_header_multisite( $content ) {
			if ( is_multisite() ) {
				$current_site = get_blog_details(get_current_blog_id());

				$sites = get_sites();

				usort($sites, function ($a, $b) {
					$al = strtolower($a->blogname);
					$bl = strtolower($b->blogname);

					if ($al == $bl) {
						return 0;
					}
					return ($al > $bl) ? +1 : -1;
				});

				if (!empty($sites)) {
					foreach ($sites as $key => $site) {
						if (!is_super_admin(get_current_user_id()) &&
							($site->blog_id == $current_site->blog_id
								|| empty(get_user_meta(get_current_user_id(), 'wp_' . $site->blog_id . '_user_level', true)))) {
							unset($sites[$key]);
						} else {
							$sites[$key]->site_info = get_blog_details($sites[$key]->blog_id);
						}
					}
				}

				$page = ! empty( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

				ob_start();
				require(PLUGIN_EO_FRAMEWORK_PATH . 'modules/wpeo-custom-menu/view/header-multisite.view.php');
				$content .= ob_get_clean();
			}

			return $content;
		}
	}

	new Custom_Menu_Filter();
}
