<?php if ( !defined( 'ABSPATH' ) ) exit;

class danger_class extends term_class {

	protected $model_name   = 'wpdigi_danger_mdl_01';

	protected $taxonomy    	= 'digi-danger';

	protected $meta_key    	= '_wpdigi_danger';

	protected $base = 'digirisk/danger';
	protected $version = '0.1';

	public $element_prefix = 'D';

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	* Récupères le nom du danger par rapport à son ID
	*
	* @param int $danger_id L'ID du danger
	*
	* @return string Le nom du danger
	*/
	public function get_name_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'name', $danger_id, $this->taxonomy );

		return $term;
	}

	/**
	* Récupères le term parent selon l'ID du danger enfant
	*
	* @param int $danger_id L'ID du danger enfant
	*
	* @return int
	*/
	public function get_parent_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'parent', $danger_id, $this->taxonomy );

		return $term;
	}

	/**
	* Créé les données par défaut des dangers selon le fichier assets/json/default.json
	*/
	public function create_default_data() {
		$file_content = file_get_contents( DANGER_PATH . 'assets/json/default.json' );
		$data = json_decode( $file_content );


		if ( !empty( $data ) ) {
			foreach ( $data as $json_danger_category ) {
				$unique_key = wpdigi_utils::get_last_unique_key( 'term', danger_category_class::get()->get_taxonomy() );
				$unique_key++;
				$unique_identifier = danger_category_class::get()->element_prefix . '' . $unique_key;
				$danger_category = danger_category_class::get()->create( array(
					'name' => $json_danger_category->name,
					'option' => array(
						'unique_key' => $unique_key,
						'unique_identifier' => $unique_identifier,
						'status' => $json_danger_category->option->status,
					),
				) );


				if ( is_wp_error( $danger_category ) && !empty( $danger_category->errors ) && !empty( $danger_category->errors['term_exists'] ) ) {
					$danger_category = $this->show( $danger_category->error_data['term_exists'] );
				}

				if ( $json_danger_category->option->status == 'valid' ) {
					$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );

					$danger_category->option['thumbnail_id'] = $file_id;
					$danger_category = danger_category_class::get()->update( $danger_category );
				}

				foreach( $json_danger_category->option->danger as $json_danger ) {
					$unique_key = wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() );
					$unique_key++;
					$unique_identifier = $this->element_prefix . '' . $unique_key;
					$danger = $this->create( array(
						'name' => $json_danger->name,
						'parent_id' => $danger_category->id,
						'option' => array(
							'unique_key' => $unique_key,
							'unique_identifier' => $unique_identifier,
							'status' => $json_danger->option->status,
						),
					) );

					if ( !is_wp_error( $danger ) ) {
						if ( $json_danger->option->status == 'valid' && !empty( $json_danger_category->name_thumbnail ) ) {
							if ( !empty( $json_danger->name_thumbnail ) ) {
								$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger->name_thumbnail, 0 );

							}
							else {
								$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );
							}
								$danger->option['thumbnail_id'] = $file_id;
								$danger = $this->update( $danger );
						}
					}
				}
			}
		}
	}
}

danger_class::get();
