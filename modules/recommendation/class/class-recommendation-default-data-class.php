<?php
/**
 * Gestion des données des recommandations par défaut.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des données des recommandations par défaut.
 */
class Recommendation_Default_Data_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructeur.
	 *
	 * @since   6.1.5
	 * @version 6.1.5
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Créer les données par défaut
	 *
	 * @since   6.1.5
	 * @version 7.0.0
	 *
	 * @return bool True si tout s'est bien passé, sinon false.
	 */
	public function create() {
		$request = file_get_contents( \eoxia\Config_Util::$init['digirisk']->recommendation->path . 'asset/json/default.json' );

		if ( ! $request ) {
			return false;
		}

		$data = json_decode( $request );

		if ( ! empty( $data ) ) {
			foreach ( $data as $json_recommendation_category ) {
				$this->create_recommendation_category( $json_recommendation_category );
			}
		}

		return true;
	}

	/**
	 * Créer les catégories des recommandation
	 *
	 * @since   6.1.5
	 * @version 7.0.0
	 *
	 * @param  Object $json_recommendation_category Les données de la catégorie de recommandation.
	 *
	 * @return void
	 */
	private function create_recommendation_category( $json_recommendation_category ) {
		$recommendation_category = Recommendation_Category::g()->create( array(
			'name' => $json_recommendation_category->name,
		) );

		if ( is_wp_error( $recommendation_category ) && ! empty( $recommendation_category->errors ) &&
			! empty( $recommendation_category->errors['term_exists'] ) ) {

			$recommendation_category = $this->get( array( 'id' => $recommendation_category->error_data['term_exists'] ), true );
		}

		$file_id = \eoxia\File_Util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/preconisations/' . $json_recommendation_category->name_thumbnail, 0 );

		$recommendation_category->data['thumbnail_id'] = $file_id;

		$recommendation_category = Recommendation_Category::g()->update( $recommendation_category->data );
	}
}
