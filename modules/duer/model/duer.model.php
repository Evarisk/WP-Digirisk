<?php
/**
 * Définition des champs d'un DUER.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un DUER.
 */
class DUER_Model extends Document_Model {

	/**
	 * Définition des champs
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['zip_path'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => 'zip_path',
		);

		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(),
		);

		$this->schema['document_meta']['child']['identifiantElement'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['nomEntreprise'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['dateAudit'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['emetteurDUER'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['destinataireDUER'] = array(
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['document_meta']['child']['dateGeneration'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['dateDebutAudit'] = array(
			'type'    => 'wpeo_date',
			'context' => array( 'GET' ),
		);

		$this->schema['document_meta']['child']['dateFinAudit'] = array(
			'type'    => 'wpeo_date',
			'context' => array( 'GET' ),
		);

		$this->schema['document_meta']['child']['telephone'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['portable'] = array(
			'type' => 'string',
		);

		$this->schema['document_meta']['child']['methodologie'] = array(
			'type'    => 'string',
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
			- Traitement et rédaction du document unique',
		);

		$this->schema['document_meta']['child']['sources'] = array(
			'type'    => 'string',
			'default' => 'La sensibilisation des risques est définie dans l\'ed840 édité par l\'INRS.
			Dans ce document vous trouverez:
			- La définition d\'un risque, d\'un danger et un schéma explicatif
			- Les explications concernant les différentes méthodes d\'évaluation',
		);

		$this->schema['document_meta']['child']['remarqueImportante'] = array(
			'type'    => 'string',
			'default' => 'Notes importantes',
		);

		$this->schema['document_meta']['child']['dispoDesPlans'] = array(
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['document_meta']['child']['elementParHierarchie'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['risq'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['risq48'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['risq51'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['risq80'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['risqueFiche'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['planDactionRisq'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['planDactionRisq48'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['planDactionRisq51'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['planDactionRisq80'] = array(
			'type' => 'array',
		);

		$this->schema['document_meta']['child']['planDaction'] = array(
			'type' => 'array',
		);

		parent::__construct( $data, $req_method );
	}

}
