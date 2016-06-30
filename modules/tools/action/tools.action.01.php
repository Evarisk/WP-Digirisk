<?php if ( !defined( 'ABSPATH' ) ) exit;

class tools_action_01 {

	function __construct() {
	  add_action( 'admin_enqueue_scripts', array( $this, 'admin_asset' ) );
	}

  public function admin_asset() {
		wp_enqueue_script( 'wpdigi-tools-backend-js', TOOLS_URL . 'asset/js/backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
  }
}

new tools_action_01();
