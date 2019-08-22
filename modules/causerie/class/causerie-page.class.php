<?php
/**
 * La classe gérant la page principale des causeries.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
	 * @since   6.6.0
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
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0; // WPCS: CSRF ok.
		$page = ! empty( $_GET[ 'tab' ] ) ? sanitize_text_field( $_GET[ 'tab' ] ) : 'dashboard';

		if ( ! empty( $id ) ) {
			Causerie_Intervention_Page_Class::g()->display_single( $id );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'main',	array( 'page' => $page )
			);
		}
	}

	/**
	 * Affichage onglet "Dashboard".
	 *
	 * Récupères toutes les causeries "intervention" et les envoies à la vu principale du "dashboard".
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display_dashboard() {
		$causeries_intervention = Causerie_Intervention_Class::g()->get( array(
			'meta_key'   => '_wpdigi_current_step',
			'meta_value' => \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED,
		), false, true );

		$causeries_intervention = $this->get_documents( $causeries_intervention );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/main', array(
			'causeries_intervention' => $causeries_intervention,
		) );
	}

	/**
	 * Affichage onglet "Démarrer une causerie".
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display_start() {
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
	 * @since   6.6.0
	 */
	public function display_form() {
		$causeries = Causerie_Class::g()->get();
		$causeries = $this->get_documents( $causeries );

		$causerie_schema = Causerie_Class::g()->get( array( 'schema' => true ), true );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/main', array(
			'causeries'       => $causeries,
			'causerie_schema' => $causerie_schema,
		) );
	}

	/**
	 * Récupères le document lié à la causerie.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param  Causerie_Intervention_Model[]|Causerie_Model[] $causeries Tableau de causeries.
	 *
	 * @return Causerie_Intervention_Model[]|Causerie_Model[] $causeries Tableau de causeries avec leurs documents.
	 */
	private function get_documents( $causeries ) {
		if ( ! empty( $causeries ) ) {
			foreach ( $causeries as &$causerie ) {
				$class = '\digi\Sheet_Causerie_Class';

				if ( Causerie_Intervention_Class::g()->get_type() === $causerie->data['type'] ) {
					$class = '\digi\Sheet_Causerie_Intervention_Class';
				}

				$causerie->document = $class::g()->get( array(
					'post_parent'    => $causerie->data['id'],
					'posts_per_page' => 1,
				), true );

				if ( ! empty( $causerie->data['document'] ) ) {
					// $causerie->document->path = Document_Class::g()->get_document_path( $causerie->document, $causerie->type );
				}
			}
		}

		return $causeries;
	}
}

Causerie_Page_Class::g();
