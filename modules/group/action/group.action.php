<?php
/**
 * Les actions relatives aux groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package group
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux groupements
 */
class Group_Action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_wpdigi-create-group
	 * wp_ajax_wpdigi-load-group
	 * wp_ajax_wpdigi_ajax_group_update
	 * wp_ajax_display_ajax_sheet_display
	 * wp_ajax_wpdigi_generate_duer_digi-group
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_create_group', array( $this, 'ajax_create_group' ) );
	}

	/**
	 * Créer un groupement
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function ajax_create_group() {
		check_ajax_referer( 'create_group' );

		if ( 0 === (int) $_POST['parent_id'] ) {
			wp_send_json_error();
		} else {
			$parent_id = (int) $_POST['parent_id'];
		}

		$group = Group_Class::g()->create( array(
			'parent_id' => $parent_id,
			'title' => __( 'Undefined', 'digirisk' ),
		) );

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'group',
			'callback_success' => 'createdGroupSuccess',
			'groupment_id' => $group->id,
			'template' => ob_get_clean(),
		) );
	}
}

new Group_Action();
