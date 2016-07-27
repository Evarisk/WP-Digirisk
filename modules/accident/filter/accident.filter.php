<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package accident
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class accident_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ) );
	}

	public function callback_tab( $list_tab ) {
		$list_tab['digi-workunit']['accident'] = array(
			'text' => __( 'Accident', 'digirisk' ),
		);
		$list_tab['digi-group']['accident'] = array(
			'text' => __( 'Accident', 'digirisk' ),
		);

		return $list_tab;
	}
}

new accident_filter();
