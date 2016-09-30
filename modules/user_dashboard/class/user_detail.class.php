<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_detail_class extends singleton_util {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {}

	public function get_list_workunit( $user_id, $list_workunit_id ) {
		$custom_list_workunit = array();

		if ( !empty( $list_workunit_id ) ) {
			$list_workunit = workunit_class::g()->get( array( 'include' => $list_workunit_id ), array( false ) );

			if ( !empty( $list_workunit ) ) {
			  foreach ( $list_workunit as $key => $workunit ) {
					// Récupères le groupement pour afficher l'identifiant
					$custom_list_workunit[$key]['groupment'] = society_class::g()->show_by_type( $workunit->parent_id, array( false ) );
					$custom_list_workunit[$key]['self'] = $workunit;
					$custom_list_workunit[$key]['affectation_date_info'] = max( $workunit->user_info['affected_id']['user'][$user_id] );
			  }
			}
		}

		return $custom_list_workunit;
	}

	public function get_list_evaluation( $user_id, $list_evaluation_id ) {
		$custom_list_evaluation = array();

		if ( !empty( $list_evaluation_id ) ) {

		}

		return $custom_list_evaluation;
	}

	public function get_list_accident( $user_id, $list_accident_id ) {
		$custom_list_accident = array();

		if ( !empty( $list_accident_id ) ) {

		}

		return $custom_list_accident;
	}

	public function get_list_stop_day( $user_id, $list_stop_day_id ) {
		$custom_list_stop_day = array();

		if ( !empty( $list_stop_day_id ) ) {

		}

		return $custom_list_stop_day;
	}

	public function get_list_chemical_product( $user_id, $list_chemical_product_id ) {
		$custom_list_chemical_product = array();

		if ( !empty( $list_chemical_product_id ) ) {

		}

		return $custom_list_chemical_product;
	}

	public function get_list_epi( $user_id, $list_epi_id ) {
		$custom_list_epi = array();

		if ( !empty( $list_epi_id ) ) {

		}

		return $custom_list_epi;
	}
}

user_detail_class::g();
