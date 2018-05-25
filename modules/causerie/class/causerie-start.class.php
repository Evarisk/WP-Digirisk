<?php
/**
 * La classe gérant la page des causeries sécurité prêt pour l'évaluation.
 *
 * @author Evarisk <dev@evarisk.com>
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
 * La classe gérant la page des causeries sécurité prêt pour l'évaluation.
 */
class Causerie_Start_Class extends \eoxia\Singleton_Util {

	/**
	 * Méthodes obligatoire pour Singleton_Util
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Affiches la fenêtre principale des accidents
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display() {
		$causeries       = Causerie_Class::g()->get();
		$final_causeries = Final_Causerie_Class::g()->get();

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/main', array(
			'causeries'       => $causeries,
			'final_causeries' => $final_causeries,
		) );
	}

	public function display_single( $id ) {
		$step = ! empty( $_GET['step'] ) ? (int) $_GET['step'] : 1;

		$final_causerie = Final_Causerie_Class::g()->get( array( 'id' => $id ), true );
		$main_causerie  = Causerie_Class::g()->get( array( 'id' => $final_causerie->parent_id ), true );

		if ( 1 === $step ) {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/main-single', array(
				'final_causerie' => $final_causerie,
				'main_causerie' => $main_causerie,
			) );
		} elseif ( 2 === $step ) {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/main-step-2', array(
				'final_causerie' => $final_causerie,
				'main_causerie' => $main_causerie,
			) );
		} elseif ( 3 === $step ) {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/main-step-3', array(
				'final_causerie' => $final_causerie,
				'main_causerie' => $main_causerie,
			) );
		}
	}
}

Causerie_Start_Class::g();
