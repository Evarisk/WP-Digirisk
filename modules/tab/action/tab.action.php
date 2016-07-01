<?php
/**
* Add filter for add tab
* Add filter for display the tab content
* Add action ajax for load content
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package tab
* @subpackage action
*/
if ( !defined( 'ABSPATH' ) ) exit;

class tab_action {
  public function __construct() {
    add_action( 'wp_ajax_load_tab_content', array( $this, 'callback_load_tab_content' ) );
  }

  /**
  * Appelles le contenu d'un établissement
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @param string $tab_to_display Le nom de l'onglet pour le contenu à afficher.
  */
  public function callback_load_tab_content() {
    // check_ajax_referer( 'load_content' );

    $element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
    $tab_to_display = !empty( $_POST['tab_to_display'] ) ? sanitize_key( $_POST['tab_to_display'] ) : '';

    $element = society_class::get()->show_by_type( $element_id );

    ob_start();
    require( TAB_VIEW_DIR . 'content.view.php' );
    wp_send_json_success( array( 'template' => ob_get_clean() ) );
  }
}

new tab_action();
