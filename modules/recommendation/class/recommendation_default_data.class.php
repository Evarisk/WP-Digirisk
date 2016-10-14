<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_default_data_class extends singleton_util {
	protected function construct() {}
	/**
	* Créer les données par défaut
	*/
	public function create() {
		$file_content = file_get_contents( PLUGIN_DIGIRISK_PATH . config_util::$init['recommendation']->path . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_recommendation_category ) {
				$this->create_recommendation_category( $json_recommendation_category );
			}
		}
	}

	private function create_recommendation_category( $json_recommendation_category ) {
		$recommendation_category = recommendation_category_term_class::g()->create( array(
				'name' => $json_recommendation_category->name,
				'recommendation_category_print_option' => $json_recommendation_category->option->recommendation_category_print_option,
				'recommendation_category_option' => $json_recommendation_category->option->recommendation_print_option,
		) );

		if ( is_wp_error( $recommendation_category ) && !empty( $recommendation_category->errors ) && !empty( $recommendation_category->errors['term_exists'] ) ) {
			$recommendation_category = $this->get( array( 'id' => $recommendation_category->error_data['term_exists'] ) );
		}

		$file_id = file_util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/preconisations/' . $json_recommendation_category->name_thumbnail, 0 );

		$recommendation_category->thumbnail_id = $file_id;
		$recommendation_category->associated_document_id[] = $file_id;
		$recommendation_category = recommendation_category_term_class::g()->update( $recommendation_category );

		foreach( $json_recommendation_category->option->recommendation as $json_recommandation ) {
			$this->create_recommendation( $recommendation_category, $json_recommandation );
		}
	}

	private function create_recommendation( $recommendation_category, $json_recommandation ) {
		$recommandation = recommendation_term_class::g()->create( array(
			'name' => $json_recommandation->name,
			'parent_id' => $recommendation_category->id,
			'type'	=> $json_recommandation->option->type,
		) );

		if ( !is_wp_error( $recommandation ) ) {
			$file_id = file_util::g()->move_file_and_attach( PLUGIN_DIGIRISK_PATH . '/core/assets/images/preconisations/' . $json_recommandation->name_thumbnail, 0 );
			$recommandation->thumbnail_id = $file_id;
			$recommandation = recommendation_term_class::g()->update( $recommandation );
		}
	}
}
