<?php
/**
 * Tests unitaires pour l'installation de l'application.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package installer
 * @subpackage action\test
 */

namespace digi;

/**
 * Tests unitaires pour l'installation de l'application.
 */
class Installer_Action_Test extends \WP_UnitTestCase {

	/**
	 * Testes la méthode pour enregister une société dans la page d'installation de DigiRisk.
	 *
	 * @return void
	 *
	 * @since 6.2.7.0
	 * @version 6.2.7.0
	 */
	public function test_ajax_installer_save_society() {
		$data = array(
			array(
				'post_title' => 'Evarisk',
			),
			array(
				'post_title' => '%@]<?_²/*>',
			),
		);

		if ( ! empty( $data ) ) {
			foreach ( $data as $d ) {
				$group = Group_Class::g()->update( $d );
				$this->assertStringStartsWith( 'GP', $group->unique_identifier );
			}
		}
	}

	/**
	 * Testes la méthode pour installer les composants de base pour le bon fonctionnement de DigiRisk.
	 *
	 * @return void
	 *
	 * @since 6.2.7.0
	 * @version 6.2.7.0
	 */
	public function test_ajax_installer_components() {
		$default_core_option = array(
			'installed' 									=> false,
			'db_version'									=> '1',
			'danger_installed' 						=> false,
			'recommendation_installed' 		=> false,
			'evaluation_method_installed' => false,
		);

		$core_option = get_option( Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			Danger_Default_Data_Class::g()->create();
			$core_option['danger_installed'] = true;
		} elseif ( ! $core_option['recommendation_installed'] ) {
			Recommendation_Default_Data_Class::g()->create();
			$core_option['recommendation_installed'] = true;
		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			Evaluation_Method_Default_Data_Class::g()->create();
			$core_option['evaluation_method_installed'] = true;
			$core_option['installed'] = true;
		}

		$this->assertTrue( update_option( Config_Util::$init['digirisk']->core_option, $core_option ) );
		$this->assertEquals( Config_Util::$init['digirisk']->core_option, '_digirisk_core' );
	}
}
