<?php

namespace digi;

class Workunit_Action_Test extends \WP_UnitTestCase {
	public function test_ajax_save_workunit() {
		$workunit = array(
			'title' => 'Bureau',
			'parent_id' => 1,
		);

		/**	Création de l'unité / Create the unit	*/
		$element = Workunit_Class::g()->create( $workunit );

		$this->assertEquals( $element->unique_identifier, 'UT1' );
	}
}
