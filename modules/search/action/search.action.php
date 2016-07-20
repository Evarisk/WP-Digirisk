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

		if ( !empty( $_GET['next_action'] ) ) {
			do_action( $_GET['next_action'], $_GET['id'], $list );
		}

		$return = array();

		foreach ( $list as $element ) {
			if( $element->id != $_GET['id'] && !wpdigi_utils::is_parent( $_GET['id'], $element->id ) && count( get_children( array( 'post_parent' => $element->id, 'post_type' => 'digi-workunit' ) ) ) == 0 ) {
				$return[] = array(
					'label' => $element->option['unique_identifier'] . ' ' . $element->title,
					'value' => $element->option['unique_identifier'] . ' ' . $element->title,
					'id'		=> $element->id,
				);
			}
		}

		wp_die( wp_json_encode( $return ) );
	}
}

new search_action();
