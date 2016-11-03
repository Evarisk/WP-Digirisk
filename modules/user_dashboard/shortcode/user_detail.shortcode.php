<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher le détail d'un utilisateur
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class user_detail_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-user-detail', array( $this, 'callback_digi_user_detail' ) );
	}

	public function callback_digi_user_detail( $param ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $param['id'] ) ) );

		if ( !empty( $user[0] ) ) {
			$user = $user[0];
			$list_element = user_detail_class::g()->get_list_workunit( $user->id, $user->dashboard_compiled_data['list_workunit_id'] );
			// $list_evaluation = user_detail_class::g()->get_list_evaluation( $user->id, $user->dashboard_compiled_data['list_evaluation_id'] );
			// $list_accident = user_detail_class::g()->get_list_accident( $user->id, $user->dashboard_compiled_data['list_accident_id'] );
			// $list_stop_day = user_detail_class::g()->get_list_stop_day( $user->id, $user->dashboard_compiled_data['list_stop_day_id'] );
			// $list_chemical_product = user_detail_class::g()->get_list_chemical_product( $user->id, $user->dashboard_compiled_data['list_chemical_product_id'] );
			// $list_epi = user_detail_class::g()->get_list_epi( $user->id, $user->dashboard_compiled_data['list_epi_id'] );

			require( USER_DASHBOARD_VIEW . '/user-detail/main.view.php' );
		}
	}
}

new user_detail_shortcode();
