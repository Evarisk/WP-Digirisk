<?php
/**
 * Mise à jour des données pour les version à partir de 6.2.10.0
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.2.10.0
 */
class Update_62100 {
	private $limit_update_risk = 10;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_risk_cotation', array( $this, 'callback_digirisk_update_risk_cotation' ) );
		add_action( 'wp_ajax_digirisk_update_doc', array( $this, 'callback_digirisk_update_doc' ) );
	}
	/**
	 * AJAX Callback - Assign capability to site administrator
	 */
	public function callback_digirisk_update_risk_cotation() {
		$done = false;

		$index = ! empty( $_POST['args']['index'] ) ? (int) $_POST['args']['index'] : 0;
		$count = ! empty( $_POST['args']['count'] ) ? (int) $_POST['args']['count'] : count( get_posts( array(
			'posts_per_page' => -1,
			'post_type' => Risk_Class::g()->get_post_type(),
			'meta_key' => '_wpdigi_preset',
			'meta_value' => 1,
			'meta_compare' => '!=',
		) ) );

		$risks = Risk_Class::g()->get( array(
			'posts_per_page' => $this->limit_update_risk,
			'offset' => $index,
			'meta_key' => '_wpdigi_preset',
			'meta_value' => 1,
			'meta_compare' => '!=',
		) );

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {

				$risk->evaluation->equivalence = $risk->evaluation->risk_level['equivalence'];
				Risk_Evaluation_Class::g()->update( $risk->evaluation );
			}
		}

		$index += $this->limit_update_risk;

		if ( $index >= $count ) {
			$done = true;
		}

		wp_send_json_success( array(
			'done' => $done,
			'args' => array(
				'more' => true,
				'index' => $index,
				'count' => $count,
				'moreDescription' => ' (' . $index . '/' . $count . ')',
			),
		) );
	}

	/**
	 * Transfères des identifiants des documents depuis le module de mise à jour.
	 *
	 * @return void
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function callback_digirisk_update_doc() {
		Tools_Class::g()->transfert_doc();

		wp_send_json_success( array(
			'args' => array(
				'more' => false,
			),
			'done' => true,
		) );
	}
}

new Update_62100();
