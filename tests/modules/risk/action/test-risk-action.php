<?php
/**
 * Testes les actions des risques
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
 * Test Risk Action class.
 */
class Test_Risk_Action extends WP_Ajax_UnitTestCase {

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
	public function test_ajax_save_risk() {
		remove_all_filters( 'comments_clauses' );

		\digi\Evaluation_Method_Default_Data_Class::g()->create();
		\digi\Risk_Category_Default_Data_Class::g()->create();

		$evaluation_method_simple = \digi\Evaluation_Method_Class::g()->get( array(
			'slug' => 'evarisk-simplified',
		), true );

		$variable_simple = \digi\Evaluation_Method_Variable_Class::g()->get( array(
			'slug' => 'evarisk',
		), true );

		$variable_simple_id = $variable_simple->data['id'];

		$risk_category = \digi\Risk_Category_Class::g()->get( array(
			'slug' => 'risques-de-chute-de-hauteur',
		), true );

		$evaluation_method_id = $evaluation_method_simple->data['id'];
		$risk_category_id     = $risk_category->data['id'];
		try {
			$_POST['_wpnonce']             = wp_create_nonce( 'edit_risk' );
			$_POST['risk_category_id']     = $risk_category_id;
			$_POST['evaluation_method_id'] = $evaluation_method_id;
			$_POST['evaluation_variables'] = json_encode( array(
				$variable_simple_id => 3,
			) );
			$this->_handleAjax( 'edit_risk' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Required for ajax test.
		}

		$response = json_decode( $this->_last_response, true );

		$this->assertTrue( $response['success'] );
		$this->assertInternalType( 'array', $response['data'] );
		$this->assertInternalType( 'array', $response['data']['risk'] );
		$this->assertSame( 'Risques de chute de hauteur', $response['data']['risk']['title'] );
		$this->assertSame( 51, $response['data']['risk']['current_equivalence'] );
		$this->assertSame( $risk_category_id, $response['data']['risk']['risk_category']['data']['id'] );
		$this->assertSame( 'Risques de chute de hauteur', $response['data']['risk']['risk_category']['data']['name'] );
		$this->assertSame( $evaluation_method_id, $response['data']['risk']['evaluation_method']['data']['id'] );
		$this->assertSame( 'Evarisk simplified', $response['data']['risk']['evaluation_method']['data']['name'] );
		$this->assertSame( 3, $response['data']['risk']['evaluation']['data']['scale'] );
		$this->assertSame( 51, $response['data']['risk']['evaluation']['data']['equivalence'] );
	}
}
