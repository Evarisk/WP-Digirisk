<?php

/**
*
*
* @group ajax
*/

class Ajax_Test extends WP_Ajax_UnitTestCase {
	public function setup() {
		parent::setup();

		$this->_setRole( 'administrator' );
	}

	public function test_ajax_installer_save_society() {
		try {
			$_POST['title']                = 'Ma société';
			$_POST['install_default_data'] = 'true';
			$_POST['_wpnonce']             = wp_create_nonce( 'ajax_installer_save_society' );
			$this->_handleAjax( 'installer_save_society' );
		} catch ( WPAjaxDieContinueException $e ) {}

		$response = json_decode( $this->_last_response, true );

		$this->assertTrue( $response['success'] );
		$this->assertInternalType( 'array', $response['data'] );
	}

	public function test_ajax_install_danger() {
		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertInternalType( 'array', $response['data'] );

		$this->_last_response = null;

		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertTrue( $response['data']['core_option']['recommendation_installed'] );
		$this->assertInternalType( 'array', $response['data'] );
		$this->_last_response = null;

		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertTrue( $response['data']['core_option']['recommendation_installed'] );
		$this->assertTrue( $response['data']['core_option']['evaluation_method_installed'] );
		$this->assertInternalType( 'array', $response['data'] );
	}


}
