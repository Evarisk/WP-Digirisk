<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de controlle des requêtes pour les documents
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de controlle des requêtes pour les documents
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class document_action {

	/**
	 * Le constructeur appelle l'action personnalisé wp_ajax_wpdigi_delete_sheet
	 */
	function __construct() {
    add_action( 'wp_ajax_wpdigi_delete_sheet', array( $this, 'ajax_delete_sheet' ) );
    add_action( 'wp_ajax_regenerate_document', array( $this, 'ajax_regenerate_document' ) );
		add_action( 'wp_ajax_paginate_document', array( $this, 'ajax_paginate_document' ) );
  }

	/**
	* Supprimes un document dans une societé
	*/
  public function ajax_delete_sheet() {
		// Todo déplacer cette fonction dans la class
		if ( true !== is_int( (int) $_POST['parent_id'] ) )
      wp_send_json_error();
    else
      $parent_id = (int) $_POST['parent_id'];

    if ( true !== is_int( (int) $_POST['element_id'] ) )
      wp_send_json_error();
    else
      $element_id = (int) $_POST['element_id'];

    $global = sanitize_text_field( $_POST['global'] );

    $parent_element = society_class::g()->show_by_type( $parent_id );

    if ( $parent_element->id == 0 || empty( $parent_element->option['associated_document_id']['document'] ) )
      wp_send_json_error();

    $key = array_search( $element_id, $parent_element->option['associated_document_id']['document'] );

    if ( $key < 0 )
      wp_send_json_error();

    unset( $parent_element->option['associated_document_id']['document'][$key] );

    society_class::g()->update_by_type( $parent_element );

    wp_send_json_success();
  }

	/**
	 * Re-génére un document a partir des données présentes en base de données
	 */
	function ajax_regenerate_document() {
		check_ajax_referer( 'regenerate_document' );

		$model_name = !empty( $_POST['model_name'] ) ? sanitize_text_field( $_POST['model_name'] ) : '';
		if ( empty( $model_name ) ) {
			wp_send_json_error();
		}
		$tmp_name = $model_name;
		$model_name = '\digi\\' . $model_name . '_class';

		$document_id = !empty( $_POST ) && is_int( (int)$_POST[ 'element_id' ] ) && !empty( $_POST[ 'element_id' ] ) ? (int)$_POST[ 'element_id' ] : 0;
		if ( !empty( $document_id ) ) {
			$parent_id = !empty( $_POST ) && is_int( (int)$_POST[ 'parent_id' ] ) && !empty( $_POST[ 'parent_id' ] ) ? (int)$_POST[ 'parent_id' ] : 0;
			$parent_element = society_class::g()->show_by_type( $parent_id );

			$current_document = $model_name::g()->get( array( 'post__in' => array( $document_id ), 'post_status' => 'any' ) );
		 	$response =	document_class::g()->generate_document( $current_document[0]->model_id, $current_document[ 0 ]->document_meta, $parent_element->type . '/' . $parent_id . '/' . $current_document[ 0 ]->title . '.odt' );
			wp_send_json_success( $response );
		}
		else {
      wp_send_json_error( array( 'message' => __( 'No document has been selected', 'digirisk' ), ) );
		}

		wp_send_json_error( array( 'message' => __( 'An error occured while trying to generate the document', 'digirisk' ), ) );
	}

	public function ajax_paginate_document() {
		$element = society_class::g()->show_by_type( $_REQUEST['element_id'] );
		document_class::g()->display_document_list( $element );

		wp_die();
	}
}

new document_action();
