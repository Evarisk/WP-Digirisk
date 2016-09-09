<?php if ( !defined( 'ABSPATH' ) ) exit;

class setting_class extends singleton_util {

	protected function construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init_option' ) );
	}

	public function init_option() {
		$file_content = file_get_contents( SETTING_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content, true );
		$list_accronym = get_option( SETTING_OPTION_NAME_ACCRONYM );

		if ( empty( $list_accronym ) ) {
			update_option( SETTING_OPTION_NAME_ACCRONYM, json_encode( $data ) );
		}
	}
}

setting_class::g();
