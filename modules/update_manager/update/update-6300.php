<?php
/**
 * Mise à jour des données pour les version à partir de 6.3.0
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mise à jour des données pour les version à partir de 6.3.0
 */
class Update_630 {
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_create_society', array( $this, 'callback_digirisk_update_create_society' ) );
	}

	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_create_society() {
		$done = true;

		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		if ( ! empty( $society ) ) {
			wp_send_json_success( array(
				'updateComplete'    => false,
				'done'              => $done,
				'progressionPerCent'       => '100',
				'doneDescription'   => '',
				'doneElementNumber' => 0,
				'errors'            => null,
			) );
		}

		$groups = Group_Class::g()->get( array(
			'posts_per_page' => 1,
			'post_parent' => 0,
			'orderby' => 'ID',
			'order' => 'ASC',
		) );

		if ( empty( $groups ) ) {
			$society = Society_Class::g()->update( array(
				'title' => __( 'Ma société', 'digirisk' ),
			) );

			wp_send_json_success( array(
				'updateComplete'    => false,
				'done'              => $done,
				'progressionPerCent'       => '100',
				'doneDescription'   => '',
				'doneElementNumber' => 0,
				'errors'            => null,
			) );
		}

		$group_to_society = $groups[0];

		$society = Society_Class::g()->update( array(
			'title' => $group_to_society->data['title'],
		) );

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				Group_Class::g()->update( array(
					'id' => $group->data['id'],
					'parent_id' => $society->data['id'],
				) );
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => $done,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}
}

new Update_630();
