<?php
/**
 * Mise à jour des données pour la version 6.3.1
 *
 * @author Evarisk
 * @since 6.3.1
 * @version 6.3.1
 * @copyright 2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mise à jour des données pour la version 6.3.1
 */
class Update_631 {
	private $limit_update_risk = 10;

	/**
	 * Initialise les actions nécessaire pour les mises à jour de la 6.3.1
	 * Ses actions sont définis dans le fichier data/update-6310-data.php
	 *
	 * @since 6.3.1
	 * @version 6.3.1
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_risk_equivalence', array( $this, 'callback_digirisk_update_risk_equivalence' ) );
	}

	/**
	 *
	 * @since 6.3.1
	 * @version 6.3.1
	 */
	public function callback_digirisk_update_risk_equivalence() {
		$done = false;

		$index = ! empty( $_POST['args']['index'] ) ? (int) $_POST['args']['index'] : 0;
		$count = ! empty( $_POST['args']['count'] ) ? (int) $_POST['args']['count'] : count( get_posts( array(
			'posts_per_page' => -1,
			'post_status' => 'any',
			'post_type' => Risk_Class::g()->get_post_type(),
		) ) );

		$risks = Risk_Class::g()->get( array(
			'posts_per_page' => $this->limit_update_risk,
			'post_status' => 'any',
			'offset' => $index,
		) );

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {

				$risk->evaluation->equivalence = $risk->evaluation->risk_level['equivalence'];
				Risk_Evaluation_Class::g()->update( $risk->evaluation );

				$risk->current_equivalence = $risk->evaluation->equivalence;
				Risk_Class::g()->update( $risk );
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
}

new Update_631();
