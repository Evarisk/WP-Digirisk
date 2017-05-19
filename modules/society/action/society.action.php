<?php
/**
 * Les actions relatives aux sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux sociétés
 */
class Society_Action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_load_sheet_display
	 * wp_ajax_save_society
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_society', array( $this, 'callback_load_society' ) );
		add_action( 'wp_ajax_save_society', array( $this, 'callback_save_society' ) );
		add_action( 'wp_ajax_delete_society', array( $this, 'callback_delete_society' ) );
	}

	/**
	 * Charges le template d'une société
	 *
	 * @since 1.0
	 * @version 6.2.9.0
	 */
	public function callback_load_society() {
		$template = '';

		ob_start();
		Digirisk_Class::g()->display();
		$template .= ob_get_clean();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'society',
			'callback_success' => 'loadedSocietySuccess',
			'template' => $template,
		) );
	}

	/**
	 * Sauvegardes les données d'une societé
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_save_society() {
		check_ajax_referer( 'save_society' );

		// todo: Doublon ?
		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$group_id = $id;
		$workunit_id_selected = 0;

		$society = Society_Class::g()->show_by_type( $_POST['id'] );
		$society->title = $_POST['title'];

		if ( ! empty( $_POST['parent_id'] ) ) {
			$parent_id = (int) $_POST['parent_id'];
			$society->parent_id = $_POST['parent_id'];
		}

		Society_Class::g()->update_by_type( $society );

		if ( 'digi-workunit' === $society->type ) {
			$id = $society->parent_id;

			$_POST['workunit_id'] = $society->id;
		}

		ob_start();
		Digirisk_Class::g()->display( $id );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'society',
			'callback_success' => 'savedSocietySuccess',
			'society' => $society,
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes une société
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_delete_society() {
		check_ajax_referer( 'delete_society' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$society = Society_Class::g()->show_by_type( $id );
		$society->status = 'trash';
		Society_Class::g()->update_by_type( $society );

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array(
			'template' => ob_get_clean(),
			'namespace' => 'digirisk',
			'module' => 'society',
			'callback_success' => 'deletedSocietySuccess',
		) );
	}
}

new Society_Action();
