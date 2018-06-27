<?php
/**
 * Classe gérant l'installation de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Installer class.
 */
class Installer_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructor.
	 *
	 * @since 7.0.0
	 */
	protected function construct() {}

	/**
	 * Appelle la vue pour la page installeur
	 *
	 * @since 6.0.0
	 */
	public function setup_page() {
		$request = wp_remote_get( \eoxia\Config_Util::$init['digirisk']->installer->url . 'asset/json/default.json' );

		if ( is_wp_error( $request ) ) {
			\eoxia\LOG_Util::log( sprintf( 'Installeur - Impossible de lire asset/json/default.json' ), 'digirisk' );
			wp_send_json_error();
		}

		$request = wp_remote_retrieve_body( $request );
		$data    = json_decode( $request );

		\eoxia\View_Util::exec( 'digirisk', 'installer', 'installer', array(
			'default_data' => $data,
		) );
	}

}

new Installer_Class();
