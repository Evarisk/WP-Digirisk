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
		$user = $user[0];

		$list_workunit = workunit_class::g()->get( array(), array( false ), array( 'after_get' => array( array( 'func' => 'filter_by_affected_user_id', 'args' => array( 'user_id' => $user->id ) ) ) ) );

		require( USERS_VIEW . '/user-detail/main.view.php' );
	}
}

new user_detail_shortcode();
