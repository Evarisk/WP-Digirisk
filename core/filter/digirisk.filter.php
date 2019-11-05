<?php
/**
 * Gestion des filtres principaux de l'application.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.5
 * @version 6.3.1
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres principaux de l'application.
 */
class Digirisk_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.5
	 * @version 6.3.1
	 */
	public function __construct() {
		add_filter( 'upload_size_limit', array( $this, 'callback_upload_size_limit' ) );
		add_filter( 'task_manager_get_tasks_args', array( $this, 'callback_task_manager_get_tasks_args' ) );

		add_filter( 'digirisk_main_header_ul_after', array( $this, 'add_header_multisite' ) );

	}

	/**
	 * Modifie la valeur max pour upload un fichier.
	 *
	 * @param integer $size La valeur courante.
	 *
	 * @return integer La nouvelle valeur.
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function callback_upload_size_limit( $size ) {
		return 1024 * 10000;
	}

	/**
	* Supprimes le paramètre 'post_parent' de la requête de récupération des tâches.
	*
	* @since 6.3.1
	* @version 6.3.1
	*/
	public function callback_task_manager_get_tasks_args( $param ) {
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
		if ( in_array( $page, array( 'wpeomtm-dashboard', '' ), true ) ) {
			unset( $param['post_parent'] );
		}

		return $param;
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

			ob_start();
			require(PLUGIN_DIGIRISK_PATH . '/core/view/header-multisite.view.php');
			$content .= ob_get_clean();
		}

		return $content;
	}

}

new Digirisk_Filter();
