<?php
/**
 * Classe gérant les mises à jour de DigiRisk.
 *
 * @package DigiRisk
 * @subpackage Module/Update_Manager
 *
 * @since 6.2.8.0
 * @version 6.2.8.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les mises à jour de DigiRisk.
 */
class Update_Manager extends Singleton_Util {

	protected function construct() {}

	public function display() {
		$availables_update = array();
		$versions_data = array();

		$current_version_to_check = (int) str_replace( '.', '', Config_Util::$init['digirisk']->version );
		$last_version_done = (int) get_option( Config_Util::$init['digirisk']->key_last_update_version, 6260 );
		$update_final_path = PLUGIN_DIGIRISK_PATH . Config_Util::$init['update-manager']->path . 'data/';

		if ( $last_version_done !== $current_version_to_check ) {
			for ( $i = $last_version_done; $i <= $current_version_to_check; $i++ ) {
				if ( is_file( $update_final_path . 'update-' . $i . '-data.php' ) ) {
					require_once( $update_final_path . 'update-' . $i . '-data.php' );
					$versions_data[ $i ] = $datas;
					$availables_update[] = $i;
				}
			}
		}

		View_Util::exec( 'update-manager', 'main', array(
			'versions_data' 		=> $versions_data,
			'availables_update' => $availables_update,
		) );
	}
}

new Update_Manager();
