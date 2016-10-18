<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class affichage_legal_a4_model extends document_model {

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $field_wanted = array() ) {
		$this->model['document_meta'] = array(
			'type'				=> 'array',
			'meta_type' 	=> 'single',
			'field'				=> 'document_meta',
			'child' => array(
			)
		);

		parent::__construct( $object, $field_wanted );
	}

}
