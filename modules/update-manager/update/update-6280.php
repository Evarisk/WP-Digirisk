<?php
/**
 * Mise à jour des données pour les version à partir de 6.2.7.0
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Update_6280 {
	private $limit_risk_update_equivalence = 10;

	public function __construct() {
		add_action( 'wp_ajax_update_risk_equivalence', array( $this, 'callback_update_risk_equivalence' ) );
	}

	public function callback_update_risk_equivalence() {
		$done = false;

		$args = array(
			'offset' => ! empty( $_POST['args'] ) && ! empty( $_POST['args']['offset'] ) ? (int) $_POST['args']['offset'] : 0,
		);

		$risks = Risk_Class::g()->get( array(
			'offset' => $args['offset'],
			'posts_per_page' => $this->limit_risk_update_equivalence,
		) );

		if ( empty( $risks ) ) {
			$done = true;
		}

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$risk->evaluation->equivalence = (int) $risk->evaluation->risk_level['equivalence'];

				Risk_Evaluation_Class::g()->update( $risk->evaluation );
			}
		}

		$args['offset'] += $this->limit_risk_update_equivalence;

		wp_send_json_success( array(
			'done' => $done,
			'args' => $args,
			'test' => count( $risks ),
		) );
	}
}

new Update_6280();
