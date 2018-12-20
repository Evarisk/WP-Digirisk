<?php
/**
 * Testes la classe des risques
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
 * Installer Risk class.
 */
class Installer_Risk extends WP_UnitTestCase {

	/**
	 * Test la création d'un risque
	 *
	 * @since 7.1.0
	 */
	function test_save() {
		$data = array();

		$data['parent_id'] = 1;
		$data['status']    = 'inherit';

		$data['taxonomy'] = array(
			'digi-category-risk' => array( 1 ),
			'digi-method'        => array( 2 ),
		);

		$data['title'] = 'Accident chute hauteur';

		$risk = \digi\Risk_Class::g()->update( $data );

		$this->assertSame( $data['title'], $risk->data['title'] );
	}

}
