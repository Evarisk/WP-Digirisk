<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class setting_class extends singleton_util {

	protected function construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init_option' ) );
	}

	public function init_option() {
		$file_content = file_get_contents( PLUGIN_DIGIRISK_PATH . config_util::$init['setting']->path . 'asset/json/default.json' );
		$data = json_decode( $file_content, true );
		$list_accronym = get_option( config_util::$init['digirisk']->accronym_option );

		if ( empty( $list_accronym ) ) {
			update_option( config_util::$init['digirisk']->accronym_option, json_encode( $data ) );
		}
	}
}

setting_class::g();
