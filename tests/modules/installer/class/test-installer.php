<?php
/**
 * Testes la class "installer".
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
 * Test Installer class.
 */
class Installer_Test extends WP_UnitTestCase {

	/**
	 * Vérification si le JSON des données par défaut est accessible.
	 *
	 * @since 7.1.0
	 */
	function test_get_default_data() {
		$data = \digi\Installer_Class::g()->get_installer_default_data();
		$this->assertInternalType( 'array', $data );
	}

	/**
	 * Création des données par défaut.
	 *
	 * @since 7.1.0
	 */
	function test_installer_save_society() {
		$society = \digi\Installer_Class::g()->create_install_society( 'Ma société' );
		$this->assertInstanceOf( '\digi\Society_Model', $society );
		$this->assertEquals( 'Ma société', $society->data['title'] );

		$status = \digi\Installer_Class::g()->create_default_data( $society->data['id'] );
		$this->assertTrue( $status );
	}
}
