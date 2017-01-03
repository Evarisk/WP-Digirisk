<?php namespace digi;
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class user_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 10, 2 );
	}

	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['user'] = array(
			'text' => __( 'User', 'digirisk' ),
		);
		return $list_tab;
	}
}

new user_filter();
