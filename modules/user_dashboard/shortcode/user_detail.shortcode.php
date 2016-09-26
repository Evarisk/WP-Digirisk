<?php
/**
* Ajoutes un shortcode qui permet d'afficher le détail d'un utilisateur
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
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

			$list_workunit = user_detail_class::g()->get_list_workunit( $user->id, $user->dashboard_compiled_data['list_workunit_id'] );

			require( USER_DASHBOARD_VIEW . '/user-detail/main.view.php' );
		}
	}
}

new user_detail_shortcode();
