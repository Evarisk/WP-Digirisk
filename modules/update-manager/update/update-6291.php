<?php
/**
 * Mise à jour des données pour les version à partir de 6.2.9.1
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.2.9.1
 */
class Update_6291 {
	private $limit_update_risk = 10;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_recreate_category_danger', array( $this, 'callback_digirisk_update_recreate_category_danger' ) );
		add_action( 'wp_ajax_digirisk_update_associate_danger_to_risk', array( $this, 'callback_digirisk_update_associate_danger_to_risk' ) );
		add_action( 'wp_ajax_digirisk_update_roles_2', array( $this, 'callback_digirisk_update_roles_2' ) );
	}

	/**
	 * AJAX Callback - Change danger categories picto
	 */
	public function callback_digirisk_update_recreate_category_danger() {
		$done = false;

		$saved_slug = array();
		$dangers_slug = JSON_Util::g()->open_and_decode( PLUGIN_DIGIRISK_PATH . Config_Util::$init['update-manager']->path . 'asset/json/danger-6291.json' );
		$number_risk = 0;

		if ( ! empty( $dangers_slug ) ) {
			foreach ( $dangers_slug as $danger_slug ) {
				$term = get_term_by( 'slug', $danger_slug, Danger_Class::g()->get_taxonomy() );

				if ( ! empty( $term ) ) {
					$risks_id = get_posts( array(
						'fields' => 'ids',
						'posts_per_page' => -1,
						'post_type' => Risk_Class::g()->get_post_type(),
						'tax_query' => array(
							array(
								'taxonomy' => Danger_Class::g()->get_taxonomy(),
								'field' => 'slug',
								'terms' => $term->slug,
							),
						),
					) );

					$saved_slug['danger'][ $term->slug ][]['risks_id']  = $risks_id;
					$number_risk += count( $risks_id );

					wp_delete_term( $term->term_id, Danger_Class::g()->get_taxonomy() );
				}
			}
		}

		update_option( 'digirisk_update_6291_saved_slug', $saved_slug );

		Danger_Default_Data_Class::g()->create();

		wp_send_json_success( array(
			'done' => true,
			'args' => array(
				'numberRisk' => $number_risk,
				'moreDescription' => ' (0/' . $number_risk . ')',
			),
		) );
	}

	public function callback_digirisk_update_associate_danger_to_risk() {
		$done = false;

		$liaisons = JSON_Util::g()->open_and_decode( PLUGIN_DIGIRISK_PATH . Config_Util::$init['update-manager']->path . 'asset/json/risk-danger-6291.json', 'ARRAY_A' );
		$saved_slug = get_option( 'digirisk_update_6291_saved_slug' );
		$index = 0;
		$count_risk = ! empty( $_POST['args']['countRisk'] ) ? (int) $_POST['args']['countRisk'] : 0;
		$number_risk = ! empty( $_POST['args']['numberRisk'] ) ? (int) $_POST['args']['numberRisk'] : 0;

		if ( ! empty( $saved_slug['danger'] ) ) {
			foreach ( $saved_slug['danger'] as $slug => &$danger ) {
				if ( ! empty( $danger ) ) {
					foreach ( $danger as &$data ) {
						if ( ! empty( $data['risks_id'] ) ) {
							$risks = Risk_Class::g()->get( array(
								'post__in' => $data['risks_id'],
							) );

							if ( ! empty( $liaisons[ $slug ] ) ) {
								$term = get_term_by( 'slug', $liaisons[ $slug ], Danger_Class::g()->get_taxonomy() );

								if ( ! empty( $term ) && ! empty( $risks ) ) {
									foreach ( $risks as $risk ) {
										$risk->taxonomy['digi-danger'][] = (int) $term->term_id;
										Risk_Class::g()->update( $risk );
										$key = array_search( $risk->id, $data['risks_id'], true );

										if ( false !== $key ) {
											unset( $data['risks_id'][ $key ] );
										}

										$index++;
										$count_risk++;
										if ( $index >= $this->limit_update_risk ) {
											break;
										}
									}
								}
							}
						}
					}
				}

				if ( $this->check_all_empty( $saved_slug['danger'] ) ) {
					$done = true;
					break;
				}

				if ( $index >= $this->limit_update_risk ) {
					break;
				}
			} // End foreach().
		} // End if().

		update_option( 'digirisk_update_6291_saved_slug', $saved_slug );

		wp_send_json_success( array(
			'done' => $done,
			'args' => array(
				'numberRisk' => $number_risk,
				'countRisk' => $count_risk,
				'moreDescription' => $done ? '' : ' (' . $count_risk . '/' . $number_risk . ')',
			),
		) );
	}

	public function check_all_empty( $saved_danger ) {
		if ( ! empty( $saved_danger ) ) {
			foreach ( $saved_danger as $data ) {
				if ( ! empty( $data ) ) {
					foreach ( $data as $d ) {
						if ( ! empty( $d['risks_id'] ) ) {
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_roles_2() {
		$done = true;

		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}

		wp_send_json_success( array(
			'done' => $done,
		) );
	}
}

new Update_6291();
