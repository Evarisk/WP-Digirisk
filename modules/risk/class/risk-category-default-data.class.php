<?php
/**
 * Gestion des catégories de risque par défaut.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des catégories de risque par défaut.
 */
class Risk_Category_Default_Data_Class extends \eoxia\Singleton_Util {
	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * Créer les données par défaut.
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function create() {
		$file_content = file_get_contents( \eoxia\Config_Util::$init['digirisk']->risk->path . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( ! empty( $data ) ) {
			foreach ( $data as $risk_category_from_json ) {
				$data = array(
					'name' => $risk_category_from_json->name,
					'status' => 'valid',
					'position' => $risk_category_from_json->position,
				);

				$risk_category = Risk_Category_Class::g()->create( $data );

				$file_id = \eoxia\File_Util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/categorieDangers/' . $risk_category_from_json->thumbnail_name . '.png', 0 );
				$risk_category->thumbnail_id = $file_id;
				$risk_category = Risk_Category_Class::g()->update( $risk_category );
			}
		}
	}
}
