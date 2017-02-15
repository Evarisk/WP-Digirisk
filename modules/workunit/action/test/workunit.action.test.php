<?php
/**
 * Tests unitaires pour la sauvegarde des unités de travail.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package workunit
 * @subpackage action\test
 */

namespace digi;

/**
 * Tests unitaires pour la sauvegarde des unités de travail.
 */
class Workunit_Action_Test extends \WP_UnitTestCase {

	/**
	 * Testes de la méthode ajax_save_workunit.
	 *
	 * @return void
	 *
	 * @since 6.2.7.0
	 * @version 6.2.7.0
	 */
	public function test_ajax_save_workunit() {
		$data = array(
			array(
				'title' => 'Bureau',
				'parent_id' => 1,
			),
			array(
				'title' => 'Bureau',
				'parent_id' => '',
			),
		);

		foreach ( $data as $d ) {
			/**	Création de l'unité / Create the unit	*/
			$element = Workunit_Class::g()->create( $d );

			$this->assertStringStartsWith( 'UT', $element->unique_identifier );
		}
	}
}
