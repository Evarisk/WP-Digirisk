<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_action {
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 5 );
		add_action( 'wp_ajax_wpdigi-delete-risk', array( $this, 'ajax_delete_risk' ) );
		add_action( 'wp_ajax_wpdigi-load-risk', array( $this, 'ajax_load_risk' ) );
		add_action( 'wp_ajax_wpdigi-edit-risk', array( $this, 'ajax_edit_risk' ) );
		add_action( 'wp_ajax_wpfile_associate_file_digi-risk', array( $this, 'ajax_associate_file_to_risk' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'callback_delete_comment' ) );
	}

	/**
  * Enregistres un risque.
	* Ce callback est le dernier de save risque
  *
  * @param int $_POST['establishment']['establishment_id'] L'id de l'établissement
  * @param int $_POST['danger_id'] L'id du danger
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
	public function callback_save_risk() {
		check_ajax_referer( 'save_risk' );

		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		$element = society_class::get()->show_by_type( $element_id );

		$list_risk_id = $element->option['associated_risk'];
		$list_risk = array();
		foreach ( $list_risk_id as $risk_id ) {
			$list_risk[] = risk_class::get()->get_risk( $risk_id );
		}
		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] == $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) {
					return 0;
				}
				return ( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] > $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) ? -1 : 1;
			} );
		}

		ob_start();
		?>
		<li class="wp-digi-risk-list-header wp-digi-table-header" >
			<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
			<span class="wp-digi-risk-list-column-cotation" ><?php _e( 'Cot.', 'digirisk' ); ?></span>
			<span class="wp-digi-risk-list-column-reference header" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
			<span><?php _e( 'Risque', 'digirisk' ); ?></span>
			<span><?php _e( 'Comment', 'digirisk' ); ?></span>
			<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
		</li>
		<?php
		if ( !empty( $list_risk ) ) {
			foreach ( $list_risk as $risk ) {
				require( RISK_VIEW_DIR . 'list-item.php' );
			}
		}
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
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
			if ( 0 === (int)$_POST['risk_id'] )
				wp_send_json_error( array( 'error' => __LINE__, ) );
			else
				$risk_id = (int)$_POST['risk_id'];

			$global = sanitize_text_field( $_POST['global'] );

			wpdigi_utils::check( 'ajax_load_risk_' .$risk_id );

			$risk_definition = risk_class::get()->get_risk( $risk_id );

			$element = society_class::get()->show_by_type( $risk_definition->parent_id );

			foreach ( $risk_definition->comment as &$comment ) {
				$comment->date = explode( ' ', $comment->date );
				$comment->date = $comment->date[0];

			}
			unset( $comment );

			ob_start();
			require( RISK_VIEW_DIR . 'list-item-edit.php' );
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

			$risk = risk_class::get()->show( $risk_id );

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

			risk_class::get()->update( $risk );

			ob_start();
			echo get_the_post_thumbnail( $risk_id, 'digirisk-element-miniature' );
			echo do_shortcode( "[wpeo_gallery element_id='" . $risk_id . "' global='wpdigi_risk_ctr' ]" );

			wp_send_json_success( array( 'id' => $risk->id, 'template' => ob_get_clean() ) );
		}

		public function callback_delete_comment() {
			$id = !empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
			$risk_id = !empty( $_POST['risk_id'] ) ? (int) $_POST['risk_id'] : 0;

			check_ajax_referer( 'ajax_delete_risk_comment_' . $risk_id . '_' . $id );

			$risk_evaluation_comment = risk_evaluation_comment_class::get()->show( $id );
			$risk_evaluation_comment->status = 'trash';
			risk_evaluation_comment_class::get()->update( $risk_evaluation_comment );

			wp_send_json_success();
		}
}

new risk_action();
