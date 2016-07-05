<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ) );
	}

	public function callback_tab( $list_tab ) {
		$list_tab['digi-group']['risk'] = array(
			'text' => __( 'Risk', 'digirisk' ),
		);
		$list_tab['digi-workunit']['risk'] = array(
			'text' => __( 'Risk', 'digirisk' ),
		);

		return $list_tab;
	}
}

new risk_filter();
