<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class danger_default_data_class extends singleton_util {
	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	* Créé les données par défaut des dangers selon le fichier assets/json/default.json
	*/
	public function create() {
		$file_content = file_get_contents( PLUGIN_DIGIRISK_PATH . config_util::$init['danger']->path . 'assets/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_danger_category ) {
				$this->create_danger_category( $json_danger_category );
			}
		}
	}

	private function create_danger_category( $json_danger_category ) {
		$data = array(
			'name' => $json_danger_category->name,
			'status' => $json_danger_category->option->status,
		);

		// Créer la catégorie danger
		$danger_category = category_danger_class::g()->create( $data );

		// Si elle est déjà existante
		if ( is_wp_error( $danger_category ) && !empty( $danger_category->errors ) && !empty( $danger_category->errors['term_exists'] ) ) {
			// Récupère la catégorie danger existante
			$danger_category = category_danger_class::g()->get( array( 'id' => $danger_category->error_data['term_exists'] ) );
		}

		if ( $json_danger_category->option->status == 'valid' ) {
			$file_id = file_util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );
			$danger_category->thumbnail_id = $file_id;
			$danger_category = category_danger_class::g()->update( $danger_category );
		}

		foreach ( $json_danger_category->option->danger as $json_danger ) {
			$this->create_danger( $danger_category, $json_danger_category, $json_danger );
		}
	}

	private function create_danger( $danger_category, $json_danger_category, $json_danger ) {
		$danger = danger_class::g()->create( array(
			'name' 			=> $json_danger->name,
			'parent_id'	=> $danger_category->id,
			'status'		=> $json_danger->option->status,
		) );

		if ( !is_wp_error( $danger ) ) {
			if ( $json_danger->option->status == 'valid' && !empty( $json_danger_category->name_thumbnail ) ) {
				if ( !empty( $json_danger->name_thumbnail ) ) {
					$file_id = file_util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/categorieDangers/' . $json_danger->name_thumbnail, 0 );
				}
				else {
					$file_id = file_util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );
				}
					$danger->thumbnail_id = $file_id;
					danger_class::g()->update( $danger );
			}
		}
	}
}
