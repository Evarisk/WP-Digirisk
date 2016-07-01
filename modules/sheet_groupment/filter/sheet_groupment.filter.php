<?php if ( !defined( 'ABSPATH' ) ) exit;

class sheet_groupment_filter {

	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 16, 1 );
	}

	public function callback_digi_tab( $list_tab ) {
		$list_tab['digi-group']['sheet-groupment'] = array(
			'text' => __( 'Sheet groupment', 'digirisk' ),
			'class' => 'wp-digi-sheet-generation-button dashicons-before dashicons-share-alt2',
		);

		return $list_tab;
	}
}

new sheet_groupment_filter();
