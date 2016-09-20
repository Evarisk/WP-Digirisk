<?php if ( !defined( 'ABSPATH' ) ) exit;

class document_model extends post_model {

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'mime_type' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> 'post_mime_type',
			),
			'unique_key' 	=> array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_identifier',
			),
			'model_id' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_model_id',
			),
			'document_meta' => array(
				'type' 				=> 'array',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_document_data',
			),
		) );


		parent::__construct( $object, $field_wanted );
	}

}
