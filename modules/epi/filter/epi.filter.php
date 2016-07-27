<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package epi
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class epi_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ) );
	}

	public function callback_tab( $list_tab ) {
		$list_tab['digi-workunit']['epi'] = array(
			'text' => __( 'EPI', 'digirisk' ),
		);
		$list_tab['digi-group']['epi'] = array(
			'text' => __( 'EPI', 'digirisk' ),
		);

		return $list_tab;
	}
}

new epi_filter();
