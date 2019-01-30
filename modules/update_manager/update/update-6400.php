<?php
/**
 * Mise à jour des données pour la version 6.4.0
 *
 * @author Evarisk
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.4.0
 */
class Update_640 {
	private $limit_update_risk = 50;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ) );
		add_action( 'wp_ajax_digirisk_update_to_ed840_danger', array( $this, 'callback_digirisk_update_to_ed840_danger' ) );
		add_action( 'wp_ajax_digirisk_update_to_ed840_to_risk', array( $this, 'callback_digirisk_update_to_ed840_to_risk' ) );
	}

	public function callback_init() {
		register_taxonomy( 'digi-danger', 'digi-risk' );
	}

	/**
	 * AJAX Callback - Change danger categories picto
	 */
	public function callback_digirisk_update_to_ed840_danger() {
		$done = false;

		$saved_slug = array();
		$dangers_slug = \eoxia\JSON_Util::g()->open_and_decode( \eoxia\Config_Util::$init['digirisk']->update_manager->path . 'asset/json/danger-6291.json' );
		$number_risk = 0;

		if ( ! empty( $dangers_slug ) ) {
			foreach ( $dangers_slug as $danger_slug ) {
				$term = get_term_by( 'slug', $danger_slug, 'digi-danger' );

				if ( ! empty( $term ) && ! empty( $term->slug ) ) {
					$risks_id = get_posts( array(
						'fields' => 'ids',
						'posts_per_page' => -1,
						'post_status' => 'any',
						'post_type' => Risk_Class::g()->get_type(),
						'tax_query' => array(
							array(
								'taxonomy' => 'digi-danger',
								'field' => 'slug',
								'terms' => $term->slug,
							),
						),
					) );

					$saved_slug['danger'][ $term->slug ][]['risks_id']  = $risks_id;
					$number_risk += count( $risks_id );

					wp_delete_term( $term->term_id, 'digi-danger' );
				}
			}
		}

		update_option( 'digirisk_update_6400_saved_slug', $saved_slug );
		update_option( 'digirisk_update_6400_number_risk', $number_risk );


		// On assure le nettoyage des catÃ©gories de risque.
		$terms = get_terms( 'digi-danger', array( 'fields' => 'ids', 'hide_empty' => false ) );
		foreach ( $terms as $value ) {
			wp_delete_term( $value, 'digi-danger' );
		}
		$terms = get_terms( 'digi-danger-category', array( 'fields' => 'ids', 'hide_empty' => false ) );
		foreach ( $terms as $value ) {
			wp_delete_term( $value, 'digi-danger-category' );
		}

		Risk_Category_Default_Data_Class::g()->create();

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'progressionPerCent' => 100,
			// Translators: 1. Number of treated points 2. Previsionnal number of points to treat.
			'errors'             => null,
		) );
	}

	public function callback_digirisk_update_to_ed840_to_risk() {
		$done = false;

		$liaisons = \eoxia\JSON_Util::g()->open_and_decode( \eoxia\Config_Util::$init['digirisk']->update_manager->path . 'asset/json/risk-danger-6400.json', 'ARRAY_A' );
		$saved_slug = get_option( 'digirisk_update_6400_saved_slug' );
		$index = 0;
		$count_risk = get_option( 'digirisk_update_6400_count_risk', 0 );
		$number_risk = get_option( 'digirisk_update_6400_number_risk', 0 );

		if ( ! empty( $saved_slug['danger'] ) ) {
			foreach ( $saved_slug['danger'] as $slug => &$danger ) {
				if ( ! empty( $danger ) ) {
					foreach ( $danger as &$data ) {
						if ( ! empty( $data['risks_id'] ) ) {
							$risks = Risk_Class::g()->get( array(
								'post__in'    => $data['risks_id'],
								'post_status' => 'any',
							) );

							if ( ! empty( $liaisons[ $slug ] ) ) {
								$term = get_term_by( 'slug', $liaisons[ $slug ], Risk_Category_Class::g()->get_type() );
								if ( ! empty( $term ) && ! empty( $risks ) ) {
									foreach ( $risks as $risk ) {

										$risk->data['taxonomy']['digi-category-risk'][] = (int) $term->term_id;
										Risk_Class::g()->update( $risk->data );
										$key = array_search( $risk->data['id'], $data['risks_id'], true );

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
		} else { // End if().
			$done = true;
		}

		update_option( 'digirisk_update_6400_saved_slug', $saved_slug );
		update_option( 'digirisk_update_6400_count_risk', $count_risk );

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => $done,
			'progression'        => $count_risk . '/' . $number_risk,
			'progressionPerCent' => 0 !== $number_risk ? ( ( $count_risk * 100 ) / $number_risk ) : 0,
			// Translators: 1. Number of treated points 2. Previsionnal number of points to treat.
			'doneElementNumber'  => $count_risk,
			'errors'             => null,
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
}

new Update_640();
