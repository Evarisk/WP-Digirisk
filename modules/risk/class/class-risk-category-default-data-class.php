<?php
/**
 * Gestion des catégories de risque par défaut.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
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
	 * @version 7.0.0
	 *
	 * @return boolean True si tout s'est bien passé, sinon false.
	 */
	public function create() {
		$request = file_get_contents( \eoxia\Config_Util::$init['digirisk']->risk->path . 'asset/json/default.json' );

		if ( ! $request ) {
			return false;
		}

		$data = json_decode( $request );

		if ( ! empty( $data ) ) {
			foreach ( $data as $risk_category_from_json ) {
				$risk_category_data = array(
					'name'     => $risk_category_from_json->name,
					'status'   => 'valid',
					'position' => $risk_category_from_json->position,
				);

				$risk_category = Risk_Category_Class::g()->create( $risk_category_data );

				$file_id                             = \eoxia\File_Util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/categorieDangers/' . $risk_category_from_json->thumbnail_name . '.png', 0 );
				$risk_category->data['thumbnail_id'] = $file_id;

				$risk_category = Risk_Category_Class::g()->update( $risk_category->data );
			}
		}

		return true;
	}
}
