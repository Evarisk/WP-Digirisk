<?php
/**
 * Testes les actions de l'installeur.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Tests
 *
 * @since     7.1.0
 */

/**
 * Test Installer Action class.
 */
class Test_Installer_Action_Class extends WP_Ajax_UnitTestCase {

	/**
	 * Setup
	 *
	 * @since 7.1.0
	 */
	public function setup() {
		parent::setup();

		$this->_setRole( 'administrator' );
	}

	/**
	 * Testes l'action "installer_save_society".
	 *
	 * @since 7.1.0
	 */
	public function test_ajax_installer_save_society() {
		try {
			$_POST['title']                = 'Ma société';
			$_POST['install_default_data'] = 'true';
			$_POST['_wpnonce']             = wp_create_nonce( 'ajax_installer_save_society' );
			$this->_handleAjax( 'installer_save_society' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required pour l'ajax.
		}

		$response = json_decode( $this->_last_response, true );

		$this->assertTrue( $response['success'] );
		$this->assertInternalType( 'array', $response['data'] );
	}

	/**
	 * Testes l'action "installer_components".
	 *
	 * @since 7.1.0
	 */
	public function test_ajax_install_components() {
		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required pour l'ajax.
		}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertInternalType( 'array', $response['data'] );

		$this->_last_response = null;

		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required pour l'ajax.
		}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertTrue( $response['data']['core_option']['recommendation_installed'] );
		$this->assertInternalType( 'array', $response['data'] );
		$this->_last_response = null;

		try {
			$this->_handleAjax( 'installer_components' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required pour l'ajax.
		}

		$response = json_decode( $this->_last_response, true );
		$this->assertTrue( $response['success'] );
		$this->assertTrue( $response['data']['core_option']['danger_installed'] );
		$this->assertTrue( $response['data']['core_option']['recommendation_installed'] );
		$this->assertTrue( $response['data']['core_option']['evaluation_method_installed'] );
		$this->assertInternalType( 'array', $response['data'] );
	}


}
