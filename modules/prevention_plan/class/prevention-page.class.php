<?php
/**
 * Gestion du déroulement du plan de prévention.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion du déroulement de l'intervention du quart d'heure sécurité.
 */
class Prevention_Page_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructeur obligatoire pour Singleton_Util.
	 *
	 * @since   6.6.0
	 */
	protected function construct() {}


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

		if ( ! empty( $id ) ) {
			$this->display_single( $id );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'main' );
		}
	}

	public function display_single( $id ){

		$prevention = Prevention_Class::g()->get( array( 'id' => $id ), true );
		if( ! empty( $prevention ) ){
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/main', array(
				'prevention' => $prevention
			) );
		}else{
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'main' );
		}
	}

	public function display_dashboard() {
		$preventions = Prevention_Class::g()->get( array(
			'meta_value' => \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_CLOSED,
		) );

		if( ! empty( $preventions ) ){
			echo '<pre>'; print_r( $preventions ); echo '</pre>'; exit;
		}

		$nbr = count( Prevention_Class::g()->get( array() ) );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'dashboard/main', array(
			'preventions' => $preventions,
			'nbr' => $nbr
		) );
	}

	public function display_progress() {
		$preventions = Prevention_Class::g()->get( array() );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'progress/main', array(
			'preventions' => $preventions,
			'nbr' => count( $preventions )
		) );
	}

	public function display_step_nbr( $prevention ){
		$user = null;

		if ( ! empty( $prevention->data['former'] ) && ! empty( $prevention->data['former']['user_id'] ) ) {
			$user = get_userdata( $prevention->data['former']['user_id'] );
		}


		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		if( ! empty( $society ) ){
			$legal_display = Legal_Display_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $society->data[ 'id' ],
			), true );
		}

		$this->register_search( $user );
		if( $prevention->data[ 'step' ] >= \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_CLOSED ){
			echo '<pre>'; print_r( 'FINIE' ); echo '</pre>'; exit;
		}else{
			$file = "step-" . $prevention->data[ 'step' ];
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/' . $file, array(
				'prevention' => $prevention,
				'all_signed' => false,
				'society'       => $society,
				'legal_display' => $legal_display
			) );
		}
	}

	public function register_search( $former, $post_values = array() ) {
		global $eo_search;

		$args_causerie_former = array(
			'type'         => 'user',
			'name'         => 'former_id',
			'value'        => ! empty( $former ) ? $former->data->display_name : '',
		);

		$eo_search->register_search( 'prevention_former', $args_causerie_former );

		$args_prevention_participants = array(
			'type'  => 'user',
			'name'  => 'participant_id',
		);

		$eo_search->register_search( 'prevention_participants', $args_prevention_participants );

		$args_accident_post = array(
			'type'  => 'post',
			'name'  => 'unitedetravail',
			'args' => array(
				'model_name' => array(
					'\digi\Group_Class',
					'\digi\Workunit_Class',
				),
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => '_wpdigi_unique_identifier',
						'compare' => 'LIKE',
					),
					array(
						'key' => '_wpdigi_unique_key',
						'compare' => 'LIKE',
					),
				)
			),
			'icon' => 'fa-search',
		);

		$args_accident_post = wp_parse_args( $args_accident_post, $post_values );

		$args_prevention_maitreoeuvre = array(
			'type'  => 'user',
			'name'  => 'user_id',
		);
		$eo_search->register_search( 'maitre_oeuvre', $args_prevention_maitreoeuvre );

		$eo_search->register_search( 'accident_post', $args_accident_post );
	}

	public function step_participants( $prevention ) {
		$prevention->data['step'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_PARTICIPANT;
		$prevention->data['date_closure'] = current_time( 'mysql' );

		// $response = Sheet_Causerie_Intervention_Class::g()->prepare_document( $prevention, array( 'causerie' => $causerie ) );
		// Sheet_Causerie_Intervention_Class::g()->create_document( $response['document']->data['id'] );

		return Prevention_Class::g()->update( $prevention->data );;
	}

	public function next_step( $prevention, $nextstep ) {
		// Passes à l'étape suivante.
		$prevention->data['step'] = $nextstep;
		return Prevention_Class::g()->update( $prevention->data );
	}
}

Prevention_Page_Class::g();
