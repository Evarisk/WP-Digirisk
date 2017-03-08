<?php
/**
 * Tests unitaires pour la gestion des posts.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package wpeo_model
 * @subpackage class\test
 */

namespace digi;

/**
 * Tests unitaires pour la gestion des posts.
 */
class Post_Class_Test extends \WP_UnitTestCase {
	public function test_init_post_type() {
		$return = Post_Class::g()->init_post_type();

		$this->assertInstanceOf( 'WP_Post_Type', $return );
	}
}
