<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class group_action {

	/**
	 * CORE - Instanciation des actions ajax pour les groupement / Instanciate ajax treatment for group
	 */
	public function __construct() {
		add_action( 'wp_ajax_wpdigi-create-group', array( $this, 'ajax_create_group' ) );
		add_action( 'wp_ajax_wpdigi-delete-group', array( $this, 'ajax_delete_group' ) );

		add_action( 'wp_ajax_wpdigi-load-group', array( $this, 'ajax_load_group' ) );

		add_action( 'wp_ajax_wpdigi_ajax_group_update', array( $this, 'ajax_group_update' ) );

		add_action( 'wp_ajax_display_ajax_sheet_content', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_group_sheet_display', array( $this, 'ajax_group_sheet_display' ) );

		add_action( 'wp_ajax_wpdigi_loadsheet_group', array( $this, 'ajax_display_ajax_sheet_content' ) );

		add_action( 'wp_ajax_wpdigi_generate_duer_' . group_class::get()->get_post_type(), array( $this, 'ajax_generate_duer' ) );
	}

	public function ajax_create_group() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', group_class::get()->get_post_type() );
		$last_unique_key++;

		$group = group_class::get()->create( array(
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => group_class::get()->element_prefix . $last_unique_key,
			),
			'parent_id' => $group_id,
			'title' => __( 'Undefined', 'digirisk' ),
		) );

		ob_start();
		$display_mode = 'simple';
		group_class::get()->display_society_tree( $display_mode, $group->id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		group_class::get()->display( $group->id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

	public function ajax_delete_group() {
		global $wpdigi_group_ctr;
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		wp_delete_post( $group_id );

		$group_list = $wpdigi_group_ctr->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );

		global $default_selected_group_id;
		$default_selected_group_id = ( $default_selected_group_id == null ) && ( !empty( $group_list ) ) ? $group_list[0]->id : $default_selected_group_id;

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $default_selected_group_id );
		$template_left = ob_get_clean();

		$_POST['subaction'] = 'generate-sheet';
		ob_start();
		$this->display( $default_selected_group_id );
		$template_right = ob_get_clean();

		wp_send_json_success( array( 'template_left' => $template_left, 'template_right' => $template_right ) );
	}

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

		ob_start();
		$display_mode = 'simple';
		$this->display_society_tree( $display_mode, $group->id );
		wp_send_json_success( array( 'template_left' => ob_get_clean() ) );
	}

	public function ajax_display_ajax_sheet_content() {
		if ( 0 === ( int )$_POST['group_id'] )
			wp_send_json_error();
		else
			$group_id = (int) $_POST['group_id'];

		$group = $this->show( $group_id );

		$response = array(
			'status'		=> false,
			'output'		=> null,
			'message'		=> __( 'Element to load have not been found', 'digirisk' ),
		);

		$subaction = sanitize_text_field( $_POST['subaction'] );

		ob_start();
		$this->display_group_tab_content( $group, $subaction );
		$response['output'] = ob_get_contents();
		ob_end_clean();

		wp_die( json_encode( $response ) );
	}

	public function ajax_generate_duer() {
		check_ajax_referer( 'digi_ajax_generate_element_duer' );
		group_duer_class::get()->generate( $_POST );
		wp_send_json_success();
	}

	public function get_element_sub_tree( $element, $tabulation = '', $extra_params = null ) {
		$element_children = array();
		$element_tree = '';

		$element_children[ $element->option[ 'unique_identifier' ] ] = array( 'nomElement' => $tabulation . ' ' . $element->option[ 'unique_identifier' ] . ' - ' . $element->title, ) ;
		if ( !empty( $extra_params ) ) {
			if ( !empty( $extra_params[ 'default' ] ) ) {
				$element_children[ $element->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'default' ], $element_children[ $element->option[ 'unique_identifier' ] ] );
			}
			if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $element->option[ 'unique_identifier' ], $extra_params[ 'value' ] ) ) {
				$element_children[ $element->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'value' ][ $element->option[ 'unique_identifier' ] ], $element_children[ $element->option[ 'unique_identifier' ] ] );
			}
		}
		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id , 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$element_children = array_merge( $element_children, $this->get_element_sub_tree( $group, $tabulation . '-', $extra_params ) );
		}

		$tabulation = $tabulation . '-';
		$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $work_unit_list as $workunit ) {
			$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = array( 'nomElement' => $tabulation . ' ' . $workunit->option[ 'unique_identifier' ] . ' - ' . $workunit->title, );

			if ( !empty( $extra_params ) ) {
				if ( !empty( $extra_params[ 'default' ] ) ) {
					$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'default' ], $workunit_definition[ $workunit->option[ 'unique_identifier' ] ] );
				}
				if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $workunit->option[ 'unique_identifier' ], $extra_params[ 'value' ] ) ) {
					$workunit_definition[ $workunit->option[ 'unique_identifier' ] ] = wp_parse_args( $extra_params[ 'value' ][ $workunit->option[ 'unique_identifier' ] ], $workunit_definition[ $workunit->option[ 'unique_identifier' ] ] );
				}
			}
			$element_children = array_merge( $element_children, $workunit_definition );
		}

		return $element_children;
	}

	public function get_element_sub_tree_id( $element_id, $list_id ) {
		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id , 'post_status' => array( 'publish', 'draft', ), ), false );
		if( !empty( $group_list ) ) {
			foreach ( $group_list as $group ) {
				$list_id[] = array( 'id' => $group->id, 'workunit' => array() );
				// $list_id[count($list_id) - 1] = array();
				// $list_id[count($list_id) - 1]['workunit'] = array();
				$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $group->id, 'post_status' => array( 'publish', 'draft', ), ), false );
				foreach ( $work_unit_list as $workunit ) {
					$list_id[count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
				}
				$list_id = $this->get_element_sub_tree_id( $group->id, $list_id );
			}
		}
		else {
			$work_unit_list = workunit_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => $element_id, 'post_status' => array( 'publish', 'draft', ), ), false );
			foreach ( $work_unit_list as $workunit ) {
				// $list_id[count($list_id) - 1 == -1 ? 0 : count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
			}
		}


		return $list_id;
	}

}

new group_action();
