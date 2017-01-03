<?php
/**
 * Add filter for add tab
 * Add filter for display the tab content
 * Add action ajax for load content
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Tab_Action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_lood_tab_content
	*/
  public function __construct() {
    add_action( 'wp_ajax_load_tab_content', array( $this, 'callback_load_tab_content' ) );
  }

  /**
  * Charges le contenu d'un onglet
  *
	* int $_POST['element_id'] L'ID de la societé
	* string $_POST['tab_to_display'] L'onglet a charger
	*
  * @param array $_POST Les données envoyées par le formulaire
  */
  public function callback_load_tab_content() {
    // check_ajax_referer( 'load_content' );

    $element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
    $tab_to_display = !empty( $_POST['tab_to_display'] ) ? sanitize_key( $_POST['tab_to_display'] ) : '';

    ob_start();
		view_util::exec( 'tab', 'content', array( 'element_id' => $element_id, 'tab_to_display' => $tab_to_display ) );
    wp_send_json_success( array( 'template' => ob_get_clean() ) );
  }
}

new Tab_Action();
