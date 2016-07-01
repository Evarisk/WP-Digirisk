<?php if ( !defined( 'ABSPATH' ) ) exit;
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
	 * CORE - Instanciation des actions pour les documents
	 */
	function __construct() {
    add_action( 'wp_ajax_wpdigi_delete_sheet', array( $this, 'ajax_delete_sheet' ) );
  }

  public function ajax_delete_sheet() {
    if ( true !== is_int( (int) $_POST['parent_id'] ) )
      wp_send_json_error();
    else
      $parent_id = (int) $_POST['parent_id'];

    if ( true !== is_int( (int) $_POST['element_id'] ) )
      wp_send_json_error();
    else
      $element_id = (int) $_POST['element_id'];

    $global = sanitize_text_field( $_POST['global'] );

    global ${$global};
    $parent_element = ${$global}->show( $parent_id );

    if ( $parent_element->id == 0 || empty( $parent_element->option['associated_document_id']['document'] ) )
      wp_send_json_error();

    $key = array_search( $element_id, $parent_element->option['associated_document_id']['document'] );

    if ( $key < 0 )
      wp_send_json_error();

    unset( $parent_element->option['associated_document_id']['document'][$key] );

    ${$global}->update( $parent_element );

    wp_send_json_success();
  }
}

new document_action();
