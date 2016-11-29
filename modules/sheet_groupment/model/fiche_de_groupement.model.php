<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Fiche_De_Groupement_Model extends Document_Model {

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type'				=> 'array',
			'meta_type' 	=> 'single',
			'field'				=> 'document_meta',
			'child' => array(
				'reference' => array(
					'type' => 'string',
				),
				'nom' => array(
					'type'	=> 'string',
				),
				'photoDefault'	=> array(
					'type'	=> 'array',
				),
				'description'	=> array(
					'type'	=> 'string',
				),
				'adresse'	=> array(
					'type'	=> 'string',
				),
				'telephone' => array(
					'type'	=> 'string'
				),
				'utilisateursDesaffectes' => array(
					'type'	=> 'array'
				),
				'utilisateursAffectes' => array(
					'type'	=> 'array'
				),
				'utilisateursPresents' => array(
					'type'	=> 'array'
				),
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

		parent::__construct( $object );
	}

}
