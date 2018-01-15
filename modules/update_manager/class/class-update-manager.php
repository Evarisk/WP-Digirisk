<?php
/**
 * Classe gérant les mises à jour.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7
 * @version 6.2.7
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les mises à jour de DigiRisk.
 */
class Update_Manager extends \eoxia\Singleton_Util {

	/**
	 * Constructeur obligatoire pour Singleton_Util
	 *
	 * @since 6.2.7
	 * @version 6.2.7
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Récupères les mises à jour en attente et appel la vue "main" du module "update_manager".
	 *
	 * @since 6.2.7
	 * @version 6.2.7
	 *
	 * @return void
	 */
	public function display() {
		$waiting_updates = get_option( '_digi_waited_updates', array() );
		\eoxia\View_Util::exec( 'digirisk', 'update_manager', 'main', array(
			'waiting_updates' => $waiting_updates,
		) );
	}
}

new Update_Manager();
