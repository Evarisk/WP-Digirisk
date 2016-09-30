<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class setting_action {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_update_accronym', array( $this, 'callback_update_accronym' ) );
	}

	public function admin_menu() {
    add_options_page( 'Digirisk', 'Digirisk', 'manage_options', 'digirisk-setting', array( $this, 'add_option_page' ) );
  }

  public function add_option_page() {
		$list_accronym = get_option( config_util::$init['digirisk']->accronym_option );
		$list_accronym = !empty( $list_accronym ) ? json_decode( $list_accronym, true ) : array();
		view_util::g()->exec( 'setting', 'main', array( 'list_accronym' => $list_accronym ) );
  }

	public function callback_update_accronym() {
		$list_accronym = $_POST['list_accronym'];

		if ( !empty( $list_accronym ) ) {
		  foreach ( $list_accronym as &$element ) {
				$element['to'] = sanitize_text_field( $element['to'] );
				$element['description'] = sanitize_text_field( stripslashes( $element['description'] ) );
			}
		}

		update_option( config_util::$init['digirisk']->accronym_option, json_encode( $list_accronym ) );
		wp_safe_redirect( admin_url( 'options-general.php?page=digirisk-setting' ), $status = 302 );
	}
}

new setting_action();
