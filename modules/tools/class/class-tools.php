<?php
/**
 * Classe gérant les sociétés (groupement et unité de travail)
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les sociétés (groupement et unité de travail)
 */
class Tools_Class extends \eoxia\Singleton_Util {

	protected function construct() {}

	public function fix_hidden_society() {
		$groups = get_posts( array(
			'post_type'      => array( 'digi-group' ,'digi-workunit' ),
			'posts_per_page' => -1,
			'post_parent'    => 0,
			'post_status'    => 'publish,inherit',
		) );

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				wp_update_post( array(
					'ID'          => $group->ID,
					'post_status' => 'trash',
				) );

				Society_Class::g()->delete_child( $group->ID );
			}
		}

		$groups = get_posts( array(
			'post_type'      => array( 'digi-group' ,'digi-workunit' ),
			'posts_per_page' => -1,
			'post_status'    => 'trash',
		) );

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				wp_update_post( array(
					'ID'          => $group->ID,
					'post_status' => 'trash',
				) );

				Society_Class::g()->delete_child( $group->ID );
			}
		}
	}
}

Tools_Class::g();
