<?php if ( !defined( 'ABSPATH' ) ) exit;

class document_unique_model extends document_model {

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
			'field'				=> '_wpdigi_document_data',
			'child' => array(
				'identifiantElement' => array(
					'type' => 'string'
				),
				'nomEntreprise' => array(
					'type' => 'string'
				),
				'dateAudit' => array(
					'type'	=> 'string'
				),
				'emetteurDUER' => array(
					'type'	=> 'string'
				),
				'destinataireDUER' => array(
					'type'	=> 'string'
				),
				'dateGeneration' => array(
					'type'	=> 'string'
				),
				'telephone' => array(
					'type'	=> 'string'
				),
				'portable' => array(
					'type'	=> 'string'
				),
				'methodologie' => array(
					'type'	=> 'string'
				),
				'remarqueImportante' => array(
					'type'	=> 'string'
				),
				'dispoDesPlans' => array(
					'type'	=> 'string'
				),
				'elementParHierarchie' => array(
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
				'risqueFiche' => array(
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
				'planDactionRisq' => array(
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
				'planDactionRisq48' => array(
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
				'planDactionRisq51' => array(
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
				'planDactionRisq80' => array(
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
				'planDaction' => array(
					'type'	=> 'array',
					'child' => array(
						'segment' => array(
							'type' => 'string'
						),
						'value' => array(
							'type'	=> 'array'
						)
					)
				)
			)
		);

		parent::__construct( $object, $field_wanted );
	}

}
