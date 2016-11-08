<?php
/**
 * Gestion des types des posts personnalisés
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des types des posts personnalisés
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Custom_Post_Type_Util extends Singleton_util {
	/**
	 * Le constructeur obligatoirement pour utiliser la classe Singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Initialise le post type $name
	 *
	 * @param  zrray $config Les configurations du custom post type (.config.json du module).
	 * @return void
	 */
	static public function init( $config ) {
		$labels = array(
			'name'                => $config->name,
			'singular_name'       => $config->name_singular,
			'menu_name'           => $config->name,
			'name_admin_bar'      => $config->name_singular,
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => $config->name,
			'add_new_item'        => sprintf( __( 'Add %s', 'digirisk' ),  $config->name_singular ),
			'add_new'             => sprintf( __( 'Add %s', 'digirisk' ), $config->name_singular ),
			'new_item'            => sprintf( __( 'New %s', 'digirisk' ),  $config->name_singular ),
			'edit_item'           => sprintf( __( 'Edit %s', 'digirisk' ), $config->name_singular ),
			'update_item'         => sprintf( __( 'Update %s', 'digirisk' ), $config->name_singular ),
			'view_item'           => sprintf( __( 'View %s', 'digirisk' ), $config->name_singular ),
			'search_items'        => sprintf( __( 'Search %s', 'digirisk' ), $config->name_singular ),
			'not_found'           => __( 'Not found', 'digirisk' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'digirisk' ),
		);

		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		$args = array(
			'description'         => sprintf( __( 'Manage %s into digirisk', 'digirisk' ), $config->name ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'public'              => ! empty( $config->public ) ? $config->public : false,
			'show_ui'             => ! empty( $config->show_ui ) ? $config->show_ui : false,
			'show_in_menu'        => ! empty( $config->show_in_menu ) ? $config->show_in_menu : false,
			'show_in_admin_bar'   => ! empty( $config->show_in_admin_bar ) ? $config->show_in_admin_bar : false,
			'show_in_nav_menus'   => ! empty( $config->show_in_nav_menus ) ? $config->show_in_nav_menus : false,
			'can_export'          => ! empty( $config->can_export ) ? $config->can_export : false,
			'has_archive'         => ! empty( $config->has_archive ) ? $config->has_archive : false,
			'exclude_from_search' => ! empty( $config->exclude_from_search ) ? $config->exclude_from_search : false,
			'publicly_queryable'  => ! empty( $config->publicly_queryable ) ? $config->publicly_queryable : false,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);

		$class = '\digi\\' . $config->class;
		register_post_type( $class::g()->get_post_type(), $args );
	}
}
