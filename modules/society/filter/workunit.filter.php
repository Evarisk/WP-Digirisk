<?php if ( !defined( 'ABSPATH' ) ) exit;

class workunit_filter {

	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 3, 1 );
	}

	 function callback_digi_tab( $tab_list ) {
		 $list_tab['digi-workunit']['sheet-workunit'] = array(
 			'text' => __( 'Sheet workunit', 'digirisk' ),
 			'class' => 'wp-digi-sheet-generation-button dashicons-before dashicons-share-alt2',
 		);

		return $list_tab;
	}
}

new workunit_filter();
