<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Les actions globales / Global actions
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Les actions globales / Global actions
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class digirisk_action {

	/**
	 * Les actions globales / Global actions
	 */
	function __construct() {
		/** Recherche utilisateur */
		add_action( 'wp_ajax_search_user', array( $this, 'ajax_search_user' ) );
		add_action( 'wp_ajax_search', array( $this, 'ajax_search' ) );
	}

	public function ajax_search_user() {
		if ( isset( $_REQUEST['autocomplete_field'] ) && 'user_email' === $_REQUEST['autocomplete_field'] ) {
			$field = sanitize_text_field( $_REQUEST['autocomplete_field'] );
		} else {
			$field = 'user_login';
		}

		// Check element_id
		if (  0 === (int)$_GET['element_id'] )
		  wp_die();
		else {
			$element_id = (int) $_GET['element_id'];
		}

		// Sanitize $_REQUEST['term']
		$term = sanitize_text_field( $_REQUEST['term'] );

		// Sanitize $_GET['filter']
		$filter = sanitize_text_field( $_REQUEST['filter'] );

		$return = '';

		if ( !empty( $filter ) ) {
			$list_user_id = get_users( array(
				'fields' => 'ID',
				'search'  => '*' . $term . '*',
				'search_columns' => array( 'user_login', 'display_name', 'user_email' ),
			) );

			$return = apply_filters( $filter, '', $element_id, $list_user_id, $term );
			wp_die( wp_json_encode( array( 'template' => $return ) ) );
		}
		else {
			$users = get_users( array(
				'search'  => '*' . $term . '*',
				'search_columns' => array( 'user_login', 'user_nicename', 'user_email' ),
			) );

			foreach ( $users as $user ) {
				$return[] = array(
					/* translators: 1: user_login, 2: user_email */
					'label' => sprintf( __( '%1$s (%2$s)' ), $user->user_login, $user->user_email ),
					'value' => $user->$field,
				);
			}

			wp_die( wp_json_encode( $return ) );
		}

		wp_die();
	}

	public function ajax_search() {
		global $wpdigi_group_ctr;

		// Sanitize $_REQUEST['term']
		$term = sanitize_text_field( $_REQUEST['term'] );

		// Check element_id
		if (  0 === (int)$_GET['element_id'] )
			wp_die();
		else {
			$element_id = (int)$_GET['element_id'];
		}

		$list_group = $wpdigi_group_ctr->search( $term, array(
			'option' => array( '_wpdigi_unique_identifier' ),
			'post_title'
		) );

		if( empty( $list_group ) )
			return array();

		$return = array();

	  foreach ( $list_group as $element ) {
			if( $element->id != $element_id && !wpdigi_utils::is_parent( $element_id, $element->id ) && count( get_children( array( 'post_parent' => $element->id, 'post_type' => 'digi-workunit' ) ) ) == 0 ) {
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

new digirisk_action();
