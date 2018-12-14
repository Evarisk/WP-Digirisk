<?php

class Ajax_Test extends WP_Ajax_UnitTestCase {
	public function test_ajax_installer_save_society() {
		$this->_setRole( 'administrator' );

		try {
			$_POST['title']    = 'Ma société';
			$_POST['_wpnonce'] = wp_create_nonce( 'ajax_installer_save_society' );
			$this->_handleAjax( 'installer_save_society' );
			$this->fail( 'Expected exception: WPAjaxDieContinueException' );
		} catch ( WPAjaxDieContinueException $e ) {}

		$response = json_decode( $this->_last_response, true );

		$this->assertTrue( $response['success'] );
		$this->assertInternalType( 'array', $response['data'] );
	}

	public function test_ajax_install_components() {
		$this->_setRole( 'administrator' );

		// Trois tests, car cette méthode ajax est appelé trois fois lors de l'installation.
		for ( $i = 0; $i < 3; $i++ ) {
			try {
				$_POST['_wpnonce'] = wp_create_nonce( 'ajax_installer_components' );
				$this->_handleAjax( 'installer_components' );
				$this->fail( 'Expected exception: WPAjaxDieContinueException' );
			} catch ( WPAjaxDieContinueException $e ) {}

			$response = json_decode( $this->_last_response, true );
			$this->assertTrue( $response['success'] );
			$this->assertInternalType( 'array', $response['data'] );
		}
	}
}
