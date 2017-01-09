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

class Recommendation_Filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );
	}

	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['recommendation'] = array(
			'type' => 'text',
			'text' => __( 'Recommendation', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Recommendation_Filter();
