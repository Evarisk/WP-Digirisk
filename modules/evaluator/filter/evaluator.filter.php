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

class evaluator_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 11 );
	}

	public function callback_tab( $list_tab ) {
		$list_tab['digi-group']['evaluator'] = array(
			'text' => __( 'Evaluator', 'digirisk' ),
		);
		$list_tab['digi-workunit']['evaluator'] = array(
			'text' => __( 'Evaluator', 'digirisk' ),
		);

		return $list_tab;
	}
}

new evaluator_filter();
