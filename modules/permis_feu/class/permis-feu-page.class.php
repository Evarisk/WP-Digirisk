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
class Permis_Feu_Page_Class extends \eoxia\Singleton_Util {

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
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'main' );
		}
	}

	public function display_single( $id ){

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $id ), true );
		if( ! empty( $permis_feu ) ){
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/main', array(
				'permis_feu' => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu )
			) );
		}else{
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'main' );
		}
	}

	public function display_dashboard(){
		$list_permis_feu = Permis_Feu_Class::g()->get( array(
			'meta_value' => \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_CLOSED,
			'post_status'     => "publish"
		) );

		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'dashboard/main', array(
			'list_permis_feu' => $list_permis_feu
		) );
	}

	public function register_search( $former, $post_values = array() ) {
		global $eo_search;

		$args_permis_feu_participants = array(
			'type'  => 'user',
			'name'  => 'participant_id',
		);

		$eo_search->register_search( 'permis_feu_participants', $args_permis_feu_participants );

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

		$args_permis_feu_maitreoeuvre = array(
			'type'  => 'user',
			'name'  => 'user_id',
		);
		$eo_search->register_search( 'maitre_oeuvre', $args_permis_feu_maitreoeuvre );

		$eo_search->register_search( 'accident_post', $args_accident_post );

		$args_prevention = array(
			'label' => 'Prevention',
			'icon'  => 'fa-search',
			'type'  => 'post',
			'name'  => 'prevention_id',
			'args' => array(
				'model_name' => array(
					'\digi\Prevention_Class'
				),
				'meta_query' => array(
					array(
						'key' => '_wpdigi_prevention_prevention_step',
						'compare' => '=',
						'value' => 5,
					)
				)
			),
			'icon' => 'fa-search',
		);

		$eo_search->register_search( 'prevention_list', $args_prevention );
	}


	public function display_step_nbr( $permis_feu ){
		$user = null;

		// if ( ! empty( $permis_feu->data['former'] ) && ! empty( $permis_feu->data['former']['user_id'] ) ) {
		// 	$user = get_userdata( $permis_feu->data['former']['user_id'] );
		// }

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

		if( $permis_feu->data[ 'step' ] >= \eoxia\Config_Util::$init['digirisk']->permis_feu->steps->PERMIS_FEU_CLOSED ){
			echo '<pre>'; print_r( 'FINIE' ); echo '</pre>'; exit;
		}else{
			$file = "step-" . $permis_feu->data[ 'step' ];
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/' . $file, array(
				'permis_feu'    => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu ),
				'society'       => $society,
				'legal_display' => $legal_display
			) );
		}
	}

	public function next_step( $prevention, $nextstep ) {
		// Passes à l'étape suivante.
		$prevention->data['step'] = $nextstep;
		return Prevention_Class::g()->update( $prevention->data );
	}
}

Permis_Feu_Page_Class::g();
