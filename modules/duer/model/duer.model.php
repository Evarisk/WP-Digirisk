<?php
/**
 * Définition des champs d'un document DUER.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.5.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un document DUER.
 */
class DUER_Model extends Document_Model {

	/**
	 * Définition des champs
	 *
	 * @since   6.5.0
	 * @version 7.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['zip_path'] = array(
			'since'     => '6.2.1',
			'version'   => '6.2.1',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => 'zip_path',
		);

		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(
				'identifiantElement' => array(
					'type' => 'string',
				),
				'nomEntreprise' => array(
					'type' => 'string',
				),
				'dateAudit' => array(
					'type' => 'string',
				),
				'emetteurDUER' => array(
					'type' => 'string',
				),
				'destinataireDUER' => array(
					'type' => 'string',
				),
				'dateGeneration' => array(
					'type' => 'wpeo_date',
				),
				'dateDebutAudit' => array(
					'type' => 'wpeo_date',
				),
				'dateFinAudit' => array(
					'type' => 'wpeo_date',
				),
				'telephone' => array(
					'type' => 'string',
				),
				'portable' => array(
					'type' => 'string',
				),
				'methodologie' => array(
					'type' => 'string',
					'default' => '* Étape 1 : Récupération des informations
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
					'default' => 'La sensibilisation des risques est définie dans l\'ed840 édité par l\'INRS.
Dans ce document vous trouverez:
- La définition d\'un risque, d\'un danger et un schéma explicatif
- Les explications concernant les différentes méthodes d\'évaluation'
				),
				'remarqueImportante' => array(
					'type' => 'string',
					'default' => 'Notes importantes',
				),
				'dispoDesPlans' => array(
					'type' => 'string',
				),
				'elementParHierarchie' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'risq' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'risq48' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'risq51' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'risq80' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'risqueFiche' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'planDactionRisq' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'planDactionRisq48' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'planDactionRisq51' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'planDactionRisq80' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'planDaction' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
			),
		);

		parent::__construct( $data, $req_method );
	}

}
