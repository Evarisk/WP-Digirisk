<?php
/**
 * Testes les actions des évaluateurs
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Tests
 *
 * @since     7.1.0
 */

/**
 * Test Evaluator Action class.
 */
class Test_Evaluator_Action extends WP_Ajax_UnitTestCase {

	/**
	 * Au setup du test
	 *
	 * @since 7.1.0
	 */
	public function setup() {
		parent::setup();

		$this->_setRole( 'administrator' );
	}

	/**
	 * Testes l'action edit_risk.
	 *
	 * @since 7.1.0
	 */
	public function test_ajax_assign_evaluator() {
		try {
			$_POST['_wpnonce']   = wp_create_nonce( 'edit_evaluator_assign' );
			$_POST['element_id'] = 1;
			$this->_handleAjax( 'edit_evaluator_assign' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required for ajax test.
		}

		$response = json_decode( $this->_last_response, true );

		$this->assertTrue( $response['success'] );
	}
}
