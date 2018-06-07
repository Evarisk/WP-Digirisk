<?php
/**
 * La classe gérant les causeries dans son état "final".
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
 * La classe gérant les causeries
 */
class Causerie_Intervention_Page_Class extends \eoxia\Singleton_Util {
	protected function construct() {}

	public function display_single( $id ) {
		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$main_causerie  = Causerie_Class::g()->get( array( 'id' => $final_causerie->parent_id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/main', array(
			'final_causerie' => $final_causerie,
			'main_causerie'  => $main_causerie,
		) );
	}

	public function step_former( $causerie, $former_id, $signature_data ) {
		$causerie = Causerie_Intervention_Class::g()->add_participant( $causerie, $former_id, true );
		$causerie = Causerie_Intervention_Class::g()->add_signature( $causerie, $former_id, $signature_data, true );

		$causerie->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PRESENTATION;

		return Causerie_Intervention_Class::g()->update( $causerie );
	}

	public function step_slider( $causerie ) {
		$causerie->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PARTICIPANT;

		return Causerie_Intervention_Class::g()->update( $causerie );
	}

	public function step_participants( $causerie_intervention ) {
		$causerie = Causerie_Class::g()->get( array( 'id' => $causerie_intervention->parent_id ), true );

		$causerie->number_time_realized++;
		$causerie->number_formers++;
		$causerie->number_participants = count( $causerie_intervention->participants );
		$causerie->last_date_realized  = current_time( 'mysql' );

		Causerie_Class::g()->update( $causerie );

		$causerie_intervention->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED;

		$causerie_intervention->date_end = current_time( 'mysql' );

		Sheet_Causerie_Intervention_Class::g()->generate( $causerie_intervention->id );

		return Causerie_Intervention_Class::g()->update( $causerie_intervention );
	}
}

Causerie_Intervention_Page_Class::g();
