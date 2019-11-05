<?php
/**
 * Classe principale de DigiRisk
 * Contient la méthode qui fait l'affichage principale de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation
 */
class Digirisk extends \eoxia\Singleton_Util {

	public $menu = array();

	public $menu_bottom = array();

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	protected function construct() {
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		add_image_size( 'digirisk-element-miniature', 50, 50, true );

		$menu_def = array(
			'digirisk-welcome' => array(
				'icon'  => 'fas fa-home',
				'link'  => admin_url( 'admin.php?page=digirisk-welcome' ),
				'title' => __( 'Bienvenue', 'digirisk' ),
				'class' => '',
				'right' => 'read',
			),
			'digirisk-du' => array(
				'icon'  => 'fas fa-exclamation-triangle',
				'link'  => admin_url( 'admin.php?page=digirisk-du' ),
				'title' => __( 'Document Unique', 'digirisk' ),
				'class' => '',
				'right' => 'manage_du',
			),
			'digirisk-accident' => array(
				'icon'  => 'fas fa-user-injured',
				'link'  => admin_url( 'admin.php?page=digirisk-accident' ),
				'title' => __( 'Accidents', 'digirisk' ),
				'class' => '',
				'right' => 'manage_accident',
			),
			'digirisk-causerie' => array(
				'icon'  => 'fas fa-comments',
				'link'  => admin_url( 'admin.php?page=digirisk-causerie' ),
				'title' => __( 'Causeries', 'digirisk' ),
				'class' => '',
				'right' => 'manage_causerie',
			),
			'digirisk-prevention' => array(
				'icon'  => 'fas fa-info',
				'link'  => admin_url( 'admin.php?page=digirisk-prevention' ),
				'title' => __( 'Plan de prévention', 'digirisk' ),
				'class' => '',
				'right' => 'manage_prevention',
			),
			'digirisk-permis-feu' => array(
				'icon'  => 'fas fa-fire-alt',
				'link'  => admin_url( 'admin.php?page=digirisk-permis-feu' ),
				'title' => __( 'Permis de feu', 'digirisk' ),
				'class' => '',
				'right' => 'manage_permis_feu',
			),
			'digirisk-handle-risk' => array(
				'icon'  => 'fas fa-list',
				'link'  => admin_url( 'admin.php?page=digirisk-handle-risk' ),
				'title' => __( 'Listing de risque', 'digirisk' ),
				'class' => '',
				'right' => 'manage_listing_risque',
			),
			'digirisk-handle-sorter' => array(
				'icon'  => 'fas fa-network-wired',
				'link'  => admin_url( 'admin.php?page=digirisk-handle-sorter' ),
				'title' => __( 'Organisation des UT', 'digirisk' ),
				'class' => '',
				'right' => 'manage_sorter',
			),
			'digirisk-users' => array(
				'icon'  => 'fas fa-user',
				'link'  => admin_url( 'admin.php?page=digirisk-users' ),
				'title' => __( 'Utilisateurs', 'digirisk' ),
				'class' => '',
				'right' => 'manage_users',
			),
			'digirisk-tools' => array(
				'icon'  => 'fas fa-wrench',
				'link'  => admin_url( 'tools.php?page=digirisk-tools' ),
				'title' => __( 'Outils', 'digirisk' ),
				'class' => '',
				'right' => 'manage_tools',
			),
			'digirisk-setting' => array(
				'icon'  => 'fas fa-cog',
				'link'  => admin_url( 'options-general.php?page=digirisk-setting' ),
				'title' => __( 'Réglages', 'digirisk' ),
				'class' => '',
				'right' => 'manage_setting',
			),
		);

		$this->menu = apply_filters( 'digi_nav_items', $menu_def );

		$menu_bottom_def = array(
			'digirisk-dashboard' => array(
				'icon'  => 'fas fa-sitemap',
				'link'  => admin_url( 'admin.php?page=digirisk-dashboard-sites' ),
				'title' => __( 'Go to Dashboard', 'digirisk' ),
				'class' => 'item-bottom',
				'right' => '',
			),
			'back-to-wp' => array(
				'icon'  => 'fas fa-tachometer-alt',
				'link'  => admin_url( 'index.php' ),
				'title' => __( 'Go to WP Admin', 'digirisk' ),
				'class' => 'item-bottom',
				'right' => '',
			),
			'minimize_menu' => array(
				'icon'  => 'fas fa-arrow-left',
				'link'  => '#',
				'title' => __( 'Minimize menu', 'digirisk' ),
				'class' => 'minimize-menu',
				'right' => '',
			),
		);

		$this->menu_bottom = apply_filters( 'digi_nav_items_bottom', $menu_bottom_def );
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * $request_uri est utilisé
	 *
	 * @since 6.0.0
	 *
	 * @param integer $id L'ID de la société à afficher.
	 */
	public function display() {
		$request_uri     = ! empty( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$waiting_updates = get_option( '_digi_waited_updates', array() );

		require PLUGIN_DIGIRISK_PATH . '/core/view/main-navigation.view.php';
		require PLUGIN_DIGIRISK_PATH . '/core/view/main.view.php';
	}

	public function display_header() {
		$current_user = wp_get_current_user();
		$link         = '';

		if ( class_exists( 'user_switching' ) ) {
			$old_user = \user_switching::get_old_user();
			if ( !empty( $old_user ) ) {
				$link = add_query_arg(
					array(
						'redirect_to' => urlencode( \user_switching::current_url() ),
					), \user_switching::switch_back_url( $old_user ) );
			}
		}

		require PLUGIN_DIGIRISK_PATH . '/core/view/main-header.view.php';
	}

	/**
	 * Affiches le contenu principale de l'application.
	 *
	 * @since 7.0.0
	 *
	 * @param  integer $id L'ID de la société.
	 */
	public function display_main_container( $id = 0 ) {
		if ( 0 === $id ) {
			$society = Society_Class::g()->get_current_society();
		} else {
			$society = Society_Class::g()->show_by_type( $id );
		}

		$tab_data = Tab_Class::g()->build_tab_to_display( $society );

		require PLUGIN_DIGIRISK_PATH . '/core/view/main-content.view.php';
	}

	/**
	 * Récupères le patch note pour la version actuelle.
	 *
	 * @since 6.3.0
	 *
	 * @return array
	 */
	public function get_patch_note() {
		$patch_note_url = 'https://www.evarisk.com/wp-json/eoxia/v1/change_log/' . \eoxia\Config_Util::$init['digirisk']->version;

		$json = wp_remote_get( $patch_note_url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'verify_ssl' => false,
		) );


		$result = __( 'No update notes for this version.', 'digirisk' );

		if ( ! is_wp_error( $json ) && ! empty( $json ) && ! empty( $json['body'] ) ) {
			$result = json_decode( $json['body'] );
		}

		return array(
			'status'  => is_wp_error( $json ) ? false : true,
			'content' => $result,
		);
	}

	/**
	 * Ajoutes la capacité "manage_digirisk" à l'activation de DigiRisk.
	 *
	 * @since 6.0.0
	 */
	public function activation() {
		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}
	}

}

new Digirisk();
