<?php
/**
 * Les actions relatives aux categories de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux categories de risque.
 */
class Danger_Action {

	/**
	 * Le constructeur appelle l'action WordPress suivante: init (Pour déclarer la taxonomy danger)
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_check_predefined_danger', array( $this, 'callback_check_predefined_danger' ) );
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
				WHERE RISK_META_MAIN.meta_value LIKE '%digi-category-risk\":[" . $danger_id . "]%'" );

		if ( empty( $preset_risk_id ) ) {
			wp_send_json_error();
		}

		$preset_risk = Risk_Class::g()->get( array(
			'include' => array( $preset_risk_id ),
		) );

		$preset_risk = $preset_risk[0];

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'item-edit', array(
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