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
class opening_time_action_01 {
	function __construct() {
    add_action( 'wp_ajax_save_opening_time', array( $this, 'callback_save_opening_time' ) );
	}

  public function callback_save_opening_time() {
    check_ajax_referer( 'save_opening_time' );
    wp_send_json_success();
  }
}

new opening_time_action_01();
