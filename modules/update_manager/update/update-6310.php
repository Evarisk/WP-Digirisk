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
	private $limit_update_risk = 50;

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
		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
		) );
	}
}

new Update_631();
