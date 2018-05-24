<?php
/**
 * La classe gérant la page des dashboard causeries sécurité.
 *
 * @author Evarisk <jdev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant la page des dashboard causeries sécurité.
 */
class Causerie_Dashboard_Class extends \eoxia\Singleton_Util {

	/**
	 * Méthodes obligatoire pour Singleton_Util
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Affichage principale
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display() {
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/main', array( ) );
	}
}

Causerie_Dashboard_Class::g();
