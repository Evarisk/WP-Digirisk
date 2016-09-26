
<?php if ( !defined( 'ABSPATH' ) ) exit;

class user_detail_class extends singleton_util {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {}

	public function get_list_workunit( $user_id, $list_workunit_id ) {
		$custom_list_workunit = array();
		$list_workunit = workunit_class::g()->get( array( 'include' => $list_workunit_id ), array( false ) );

		if ( !empty( $list_workunit ) ) {
		  foreach ( $list_workunit as $key => $workunit ) {
				// Récupères le groupement pour afficher l'identifiant
				$custom_list_workunit[$key]['groupment'] = society_class::g()->show_by_type( $workunit->parent_id, array( false ) );
				$custom_list_workunit[$key]['self'] = $workunit;
				$custom_list_workunit[$key]['affectation_date_info'] = max( $workunit->user_info['affected_id']['user'][$user_id] );
		  }
		}

		return $custom_list_workunit;
	}
}

user_detail_class::g();
