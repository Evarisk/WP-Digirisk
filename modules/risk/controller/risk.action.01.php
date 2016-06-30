<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de controlle des requêtes ajax pour les risques / Risks' ajax request main file
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de controlle des requêtes ajax pour les risques / Risks' ajax request main class
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_risk_action_01 extends wpdigi_risk_ctr_01 {

	/**
	 * CORE - Instanciation des actions ajax pour les risques / Instanciate ajax treatment for danger
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_asset' ) );
		// add_action( 'wp_ajax_wpdigi-create-risk', array( $this, 'ajax_create_risk' ), 12 );
		add_action( 'wp_ajax_wpdigi-delete-risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_wpdigi-load-risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_wpfile_associate_file_digi-risk', array( $this, 'ajax_associate_file_to_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	public function admin_asset() {
		wp_enqueue_script( 'wpdigi-risk-backend-js', WPDIGI_RISKS_URL . 'asset/js/backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
	}

	public function ajax_delete_risk() {
		if ( 0 === (int)$_POST['risk_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['risk_id'];

		$global = sanitize_text_field( $_POST['global'] );

		wpdigi_utils::check( 'ajax_delete_risk_' . $risk_id );

		global $wpdigi_risk_ctr;
		global ${$global};

		$risk = $wpdigi_risk_ctr->show( $risk_id );

		if ( empty( $risk ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		$workunit = ${$global}->show( $risk->parent_id );

		if ( empty( $workunit ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		if ( FALSE === $key = array_search( $risk_id, $workunit->option['associated_risk'] ) )
			wp_send_json_error( array( 'error' => __LINE__ ) );

		unset( $workunit->option['associated_risk'][$key] );

		$risk->status = 'trash';

		$wpdigi_risk_ctr->update( $risk );
		${$global}->update( $workunit );

		wp_send_json_success();
	}

	public function ajax_load_risk() {
		ini_set("display_errors", true);
		error_reporting(E_ALL);
		if ( 0 === (int)$_POST['risk_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['risk_id'];

		$global = sanitize_text_field( $_POST['global'] );

		wpdigi_utils::check( 'ajax_load_risk_' .$risk_id );

		global $wpdigi_risk_ctr;
		global ${$global};

		$risk_definition = $wpdigi_risk_ctr->get_risk( $risk_id );

		$element = ${$global}->show( $risk_definition->parent_id );

		foreach ( $risk_definition->comment as &$comment ) {
			$comment->date = explode( ' ', $comment->date );
			$comment->date = $comment->date[0];

		}
		unset( $comment );

		ob_start();
		require_once( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'list-item-edit' ) );
		$template = ob_get_clean();

		wp_send_json_success( array( 'template' => $template ) );
	}

	/**
	 * Affectation de fichiers a une unité de travail / Associate file to a workunit
	 */
	public function ajax_associate_file_to_risk() {
		// wpdigi_utils::check( 'ajax_file_association_' . $_POST['element_id'] );

		if ( 0 === (int)$_POST['element_id'] )
			wp_send_json_error( array( 'error' => __LINE__, ) );
		else
			$risk_id = (int)$_POST['element_id'];

		if ( empty( $_POST ) || empty( $_POST[ 'files_to_associate'] ) || !is_array( $_POST[ 'files_to_associate'] ) )
			wp_send_json_error( array( 'message' => __( 'Nothing has been founded for association', 'digirisk' ), ) );

		$risk = $this->show( $risk_id );

		foreach ( $_POST[ 'files_to_associate' ] as $file_id ) {
			if ( true === is_int( (int)$file_id ) ) {
				if ( wp_attachment_is_image( $file_id ) ) {
					if ( empty( $risk->option[ 'associated_document_id' ][ 'image' ] ) )
						$risk->option[ 'associated_document_id' ][ 'image' ] = array();

					$risk->option[ 'associated_document_id' ][ 'image' ][] = (int)$file_id;

					//if ( !empty( $_POST['thumbnail'] ) ) {
					set_post_thumbnail( $risk_id , (int)$file_id );
					//}
				}
				else {
					$risk->option[ 'associated_document_id' ][ 'document' ][] = (int)$file_id;
				}
			}
		}

		$this->update( $risk );

		ob_start();
		echo get_the_post_thumbnail( $risk_id, 'digirisk-element-miniature' );
		echo do_shortcode( "[wpeo_gallery element_id='" . $risk_id . "' global='wpdigi_risk_ctr' ]" );

		wp_send_json_success( array( 'id' => $risk->id, 'template' => ob_get_clean() ) );
	}

	public function callback_delete_comment() {
		$id = !empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;

		check_ajax_referer( 'ajax_delete_risk_comment_' . $risk_id . '_' . $id );

		global $wpdigi_risk_evaluation_comment_ctr;
		$risk_evaluation_comment = $wpdigi_risk_evaluation_comment_ctr->show( $id );
		$risk_evaluation_comment->status = 'trash';
		$wpdigi_risk_evaluation_comment_ctr->update( $risk_evaluation_comment );

		wp_send_json_success();
	}
}

new wpdigi_risk_action_01();
