<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class fiche_de_groupement_model extends document_model {

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $field_wanted = array() ) {
		$this->model['_wpdigi_document_data'] = array(
			'type'				=> 'array',
			'meta_type' 	=> 'single',
			'field'				=> '_wpdigi_document_data',
			'child' => array(
				'risq' => array(
					'type'	=> 'array',
					'child' => array(
						'segment' => array(
							'type' => 'string'
						),
						'value' => array(
							'type'	=> 'array'
						)
					)
				),
				'risq48' => array(
					'type'	=> 'array',
					'child' => array(
						'segment' => array(
							'type' => 'string'
						),
						'value' => array(
							'type'	=> 'array'
						)
					)
				),
				'risq51' => array(
					'type'	=> 'array',
					'child' => array(
						'segment' => array(
							'type' => 'string'
						),
						'value' => array(
							'type'	=> 'array'
						)
					)
				),
				'risq80' => array(
					'type'	=> 'array',
					'child' => array(
						'segment' => array(
							'type' => 'string'
						),
						'value' => array(
							'type'	=> 'array'
						)
					)
				),
			)
		);

		parent::__construct( $object, $field_wanted );
	}

}
