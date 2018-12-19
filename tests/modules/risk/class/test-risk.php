<?php
/**
 * Class TestRisk
 *
 * @package Digirisk
 */

/**
 * Test Risk
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
		$data['status'] = 'inherit';

		$data['taxonomy'] = array(
			'digi-category-risk' => array( 1 ),
			'digi-method'        => array( 2 ),
		);

		$data['title'] = 'Accident chute hauteur';

		$risk = \digi\Risk_Class::g()->update( $data );

		$this->assertSame( $data['title'], $risk->data['title'] );
	}

}
