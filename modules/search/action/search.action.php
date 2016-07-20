<?php if ( !defined( 'ABSPATH' ) ) exit;

class search_action {

	/**
	* Le constructeur
	*/
	function __construct() {
		add_action( 'wp_ajax_digi_search', array( $this, 'callback_digi_search' ) );
	}

	public function callback_digi_search() {
		$list = search_class::get()->search( $_GET );

		$type = str_replace( '.', '\\', $_GET['type'] );

		do_action( $_GET['next_action'], $_GET['id'], $list, $type );

		wp_send_json_success( $list_user );
	}
}

new search_action();
