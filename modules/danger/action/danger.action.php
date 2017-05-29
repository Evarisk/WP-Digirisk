<?php
/**
 * Les actions relatives aux dangers.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux dangers.
 */
class Danger_Action {

	/**
	 * Le constructeur appelle l'action WordPress suivante: init (Pour déclarer la taxonomy danger)
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ), 1 );

		add_action( 'wp_ajax_check_predefined_danger', array( $this, 'callback_check_predefined_danger' ) );
	}

	/**
	 * Déclares la taxonomy danger
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	function callback_init() {
		$labels = array(
			'name'                       => _x( 'Dangers', 'digirisk' ),
			'singular_name'              => _x( 'Danger', 'digirisk' ),
			'search_items'               => __( 'Search Dangers', 'digirisk' ),
			'popular_items'              => __( 'Popular Dangers', 'digirisk' ),
			'all_items'                  => __( 'All Dangers', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Danger', 'digirisk' ),
			'update_item'                => __( 'Update Danger', 'digirisk' ),
			'add_new_item'               => __( 'Add New Danger', 'digirisk' ),
			'new_item_name'              => __( 'New Danger Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate dangers with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove dangers', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used dangers', 'digirisk' ),
			'not_found'                  => __( 'No dangers found.', 'digirisk' ),
			'menu_name'                  => __( 'Dangers', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array(
				'slug' => 'danger',
			),
		);

		register_taxonomy( danger_class::g()->get_taxonomy(), array( risk_class::g()->get_post_type() ), $args );
	}

	/**
	 * Vérifie si ce danger est prédéfini.
	 * Si c'est le cas, renvoie toutes les données prédéfinis.
	 *
	 * @return void
	 *
	 * @since 6.2.9.0
	 * @version 6.2.9.0
	 */
	public function callback_check_predefined_danger() {
		check_ajax_referer( 'check_predefined_danger' );

		$danger_id = ! empty( $_POST['danger_id'] ) ? (int) $_POST['danger_id'] : 0;
		$society_id = ! empty( $_POST['society_id'] ) ? (int) $_POST['society_id'] : 0;

		if ( empty( $danger_id ) || empty( $society_id ) ) {
			wp_send_json_error();
		}

		global $wpdb;

		$preset_risk_id = $wpdb->get_var(
			"SELECT RISK.ID FROM {$wpdb->posts} AS RISK
				JOIN {$wpdb->postmeta} AS RISK_META ON RISK.ID=RISK_META.post_id
					AND RISK_META.meta_key = '_wpdigi_preset'
					AND RISK_META.meta_value = 1
				JOIN {$wpdb->postmeta} AS RISK_META_MAIN ON RISK.ID=RISK_META_MAIN.post_id
					AND RISK_META_MAIN.meta_key = '_wpdigi_risk'
				WHERE RISK_META_MAIN.meta_value LIKE '%digi-danger\":[" . $danger_id . "]%'" );

		if ( empty( $preset_risk_id ) ) {
			wp_send_json_error();
		}

		$preset_risk = Risk_Class::g()->get( array(
			'include' => array( $preset_risk_id ),
		) );

		$preset_risk = $preset_risk[0];

		ob_start();
		View_Util::exec( 'risk', 'item-edit', array(
			'society_id' => $society_id,
			'risk' => $preset_risk,
		) );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
			'namespace' => 'digirisk',
			'module' => 'risk',
			'callback_success' => 'checkedPredefinedDanger',
		) );
	}
}

new danger_action();
