<?php
/**
 * Classe gérant la page installeur
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant la page installeur
 */
class Installer_Class extends \eoxia001\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.7
	 */
	protected function construct() {}

	/**
	 * Appelle la vue pour la page installeur
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.7
	 */
	public function callback_setup_page() {
		$file_content = file_get_contents( \eoxia001\Config_Util::$init['digirisk']->installer->path . 'asset/json/default.json' );
		$default_data = json_decode( $file_content );

		\eoxia001\View_Util::exec( 'digirisk', 'installer', 'installer', array(
			'default_data' => $default_data,
		) );
	}

}

new Installer_Class();
