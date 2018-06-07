<?php
/**
 * La classe gérant la page principale des causeries.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2018 Evarisk.
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant la page principale des causeries.
 */
class Causerie_Page_Class extends \eoxia\Singleton_Util {

	/**
	 * Accès rapide vers les états d'une causerie.
	 *
	 * @var array
	 */
	private $steps;

	/**
	 * Méthodes obligatoire pour Singleton_Util
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	protected function construct() {
		$this->steps = \eoxia\Config_Util::$init['digirisk']->causerie->steps;
	}

	/**
	 * Affiches la vue principale de la page "Causerie".
	 *
	 * Si $_GET['id'] existe, affiches la vue d'intervention.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0; // WPCS: CSRF ok.

		if ( ! empty( $id ) ) {
			Causerie_Intervention_Page_Class::g()->display_single( $id );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'main' );
		}
	}

	/**
	 * Affichage onglet "Dashboard".
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display_dashboard() {
		$final_causeries = Causerie_Intervention_Class::g()->get( array(
			'meta_key'   => '_wpdigi_current_step',
			'meta_value' => 4,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/main', array(
			'final_causeries' => $final_causeries,
		) );
	}

	/**
	 * Affichage onglet "Démarrer une causerie".
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display_start_table() {
		$causeries              = Causerie_Class::g()->get();
		$causeries_intervention = Causerie_Intervention_Class::g()->get( array(
			'meta_key'     => '_wpdigi_current_step',
			'meta_value'   => $this->steps->CAUSERIE_CLOSED,
			'meta_compare' => '<',
		) );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/main', array(
			'causeries'              => $causeries,
			'causeries_intervention' => $causeries_intervention,
		) );
	}

	/**
	 * Affichage onglet "Ajouter une causerie".
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display_edit_form() {
		$causeries = Causerie_Class::g()->get();

		$causerie_schema = Causerie_Class::g()->get( array( 'schema' => true ), true );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/main', array(
			'causeries'       => $causeries,
			'causerie_schema' => $causerie_schema,
		) );
	}
}

Causerie_Page_Class::g();
