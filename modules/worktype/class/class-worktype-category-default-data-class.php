<?php
/**
 * Gestion des types de travaux par défaut
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des catégories de risque par défaut.
 */
class Worktype_Category_Default_Data_Class extends \eoxia\Singleton_Util {

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
		$request = file_get_contents( \eoxia\Config_Util::$init['digirisk']->worktype->path . 'asset/json/default.json' );

		if ( ! $request ) {
			return false;
		}

		$data = json_decode( $request );

		if ( ! empty( $data ) ) {
			foreach ( $data as $worktype_category_from_json ) {
				$worktype_category_data = array(
					'name'     => $worktype_category_from_json->name,
					'status'   => 'valid',
					'position' => $worktype_category_from_json->position
				);

				$worktype_category = Worktype_Category_Class::g()->create( $worktype_category_data );

				$file_id = \eoxia\File_Util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/typeDeTravaux/' . $worktype_category_from_json->thumbnail_name . '.png', 0 );
				$worktype_category->data['thumbnail_id'] = (int) $file_id;

				$worktype_category = Worktype_Category_Class::g()->update( $worktype_category->data );
			}
		}

		return true;
	}
}
