<?php
/**
 * Les actions relatives aux groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
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
		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );
		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );
		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );
	}

	/**
	 * Créer un groupement
	 *
	 * @since 1.0
	 * @version 6.2.4.0
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
		wp_send_json_success( array( 'module' => 'group', 'callback_success' => 'createdGroupSuccess', 'groupment_id' => $group->id, 'template' => ob_get_clean() ) );
	}

	/**
	* Charges les données d'un groupement
	*
	* int $_POST['group_id'] L'ID du groupement
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_load_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group_id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $group_id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	/**
	* Sauvegardes les données d'un groupement
	*
	* int $_POST['group_id'] L'ID du groupement
	* string $_POST['title'] Le titre du groupement
	* int $_POST['send_to_group_id'] L'ID du groupement parent
	*
	* @param array $_POST Les données envoyées par le formulaire
	*/
	public function ajax_group_update() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$title = sanitize_text_field( $_POST['title'] );

		wpdigi_utils::check( 'ajax_update_group_' . $group_id );

		$group = $this->show( $group_id );
		$group->title = $title;

		if ( !empty( $_POST['send_to_group_id'] ) ) {
			$send_to_group_id = (int) $_POST['send_to_group_id'];
			$group->parent_id = $_POST['send_to_group_id'];
		}

		$this->update( $group );

		$group_parent = group_class::g()->get(
			array(
				'posts_per_page' => 1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
			), array(
				'list_group'
			) );

		ob_start();
		$display_mode = 'simple';
		$this->display_toggle( $group_parent[0], $group );
		wp_send_json_success( array( 'template_left' => ob_get_clean() ) );
	}

}

new group_action();
