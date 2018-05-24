<?php
/**
 * La classe gérant la page des causeries sécurité.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant la page des causeries sécurité.
 */
class Causerie_Add_Class extends \eoxia\Singleton_Util {

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
	 * Affiches la fenêtre principale des accidents
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function display() {
		$causeries = Causerie_Class::g()->get();

		$causerie_schema = Causerie_Class::g()->get( array( 'schema' => true ), true );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'add/main', array(
			'causeries'       => $causeries,
			'causerie_schema' => $causerie_schema,
		) );
	}

	/**
	 * Génération de l'affichage des risques à partir d'un shortcode
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 * @return void
	 */
	public function display_causerie_list() {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$causerie_schema = Causerie_Class::g()->get( array(
			'schema' => true,
		), true );

		$causeries = Causerie_Class::g()->get();

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'page/list', array(
			'main_society' => $main_society,
			'causerie_schema' => $causerie_schema,
			'causeries' => $causeries,
		) );
	}
}

Causerie_Add_Class::g();
