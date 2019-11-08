<?php
/**
 * Gestion du déroulement du plan de prévention.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.4.0
 * @version   7.4.0
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

		if ( ! empty( $prevention ) ) {
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/main', array(
				'prevention' => $prevention
			) );
		} else{
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'main' );
		}
	}

	public function display_dashboard() {
		$preventions = Prevention_Class::g()->get( array(
			'meta_key'   => '_wpdigi_prevention_prevention_is_end',
            'meta_value' => \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'dashboard/main', array(
			'preventions' => $preventions
		) );
	}

	public function display_progress() {
		$args = array(
		    'meta_query' => array(
				'relation' => 'OR',
        		array(
		            'key'     => '_wpdigi_prevention_prevention_is_end',
		            'compare' => 'NOT EXISTS',
		        ),
		        array(
		            'key' => '_wpdigi_prevention_prevention_is_end',
		            'value'   => \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IN_PROGRESS,
		        ),
		    ),
		);

		$preventions = Prevention_Class::g()->get( $args );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'progress/main', array(
			'preventions' => $preventions,
			'nbr' => count( $preventions )
		) );
	}

	public function display_outofdate() {
		$args = array(
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => '_wpdigi_prevention_date_end_exist',
					'compare' => '=',
					'value'   => 'defined',
				),
				array(
					'key'     => '_wpdigi_prevention_date_end',
					'value'   => date( "Y-m-d" ),
					'compare' => '<',
					'type'    => 'DATE',
				),
			),
		);

		$preventions = Prevention_Class::g()->get( $args );

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'outofdate/main', array(
			'preventions' => $preventions,
			'nbr' => count( $preventions )
		) );
	}

	public function display_step_nbr( $prevention ){
		$user = null;

		if ( ! empty( $prevention->data['former'] ) && ! empty( $prevention->data['former']['user_id'] ) ) {
			$user = get_userdata( $prevention->data['former']['user_id'] );
		}
		$url = "";


		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		if( ! empty( $society ) ){
			$legal_display = Legal_Display_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $society->data[ 'id' ],
			), true );
		}
		$this->register_search( $user, $prevention );

		$file = "step-" . $prevention->data[ 'step' ];
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/' . $file, array(
			'prevention' => Prevention_Class::g()->add_information_to_prevention( $prevention ),
			'all_signed' => false,
			'society'       => $society,
			'legal_display' => $legal_display
		) );
	}

	public function register_search( $former, $prevention, $post_values = array() ) {
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
					'\digi\Society_Class',
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

	public function save_society_information( $prevention, $society, $legal_display ) {
		$data = array(
			'name' => isset( $_POST[ 'outside_name' ] ) ? sanitize_text_field( $_POST[ 'outside_name' ] ) : '',
			'siret' => isset( $_POST[ 'outside_siret' ] ) ? sanitize_text_field( $_POST[ 'outside_siret' ] ) : '',
			'address' => isset( $_POST[ 'outside_address' ] ) ? sanitize_text_field( $_POST[ 'outside_address' ] ) : '',
			'postal' => isset( $_POST[ 'outside_postalcode' ] ) ? sanitize_text_field( $_POST[ 'outside_postalcode' ] ) : '',
			'town' => isset( $_POST[ 'outside_town' ] ) ? sanitize_text_field( $_POST[ 'outside_town' ] ) : '',
		);

		$prevention->data[ 'society_outside' ] = $data;

		$prevention->data['step'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_PARTICIPANT;

		return Prevention_Class::g()->update( $prevention->data );
	}

	public function step_close_prevention( $prevention, $society, $legal_display ){
		$prevention->data['step'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->steps->PREVENTION_CLOSED;
		$prevention->data['is_end'] = \eoxia\Config_Util::$init['digirisk']->prevention_plan->status->PREVENTION_IS_ENDED;
		$prevention->data['unique_identifier_int'] = Prevention_Class::g()->get_identifier_prevention();
		return Prevention_Class::g()->update( $prevention->data );
	}


	public function next_step( $prevention, $nextstep ) {
		$prevention->data['step'] = $nextstep;
		return Prevention_Class::g()->update( $prevention->data );
	}

}

Prevention_Page_Class::g();
