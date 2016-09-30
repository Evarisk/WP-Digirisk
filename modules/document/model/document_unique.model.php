<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class document_unique_model extends document_model {

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
				'dateDebutAudit' => array(
					'type'	=> 'string'
				),
				'dateFinAudit' => array(
					'type' => 'string'
				),
				'telephone' => array(
					'type'	=> 'string'
				),
				'portable' => array(
					'type'	=> 'string'
				),
				'methodologie' => array(
					'type'	=> 'string',
					'bydefault' => '* Étape 1 : Récupération des informations
- Visite des locaux
- Récupération des données du personnel

* Étape 2 : Définition de la méthodologie et de document
- Validation des fiches d\'unité de travail standard
- Validation de l\'arborescence des unités

* Étape 3  : Réalisation de l\'étude de risques
- Sensibilisation des personnels aux risques et aux dangers
- Création des unités de travail avec le personnel et le ou les responsables
- Évaluations des risques par unités de travail avec le personnel

* Étape 4
- Traitement et rédaction du document unique'
				),
				'sources' => array(
					'type' => 'string',
					'bydefault' => 'La sensibilisation des risques est définie dans l\'ed840 édité par l\'INRS.
Dans ce document vous trouverez:
- La définition d\'un risque, d\'un danger et un schéma explicatif
- Les explications concernant les différentes méthodes d\'évaluation'
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
