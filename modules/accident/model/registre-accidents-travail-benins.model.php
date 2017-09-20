<?php
/**
 * Définition des champs d'un registre accidents travail bénins.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un registre accidents travail bénins.
 */
class Registre_Accidents_Travail_Benins_Model extends Document_Model {

	/**
	 * Définition des champs 'Accident_Travail_Benin'
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @param Object $object L'objet contenant les champs pour le modèle.
	 * @return void
	 */
	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type' => 'array',
			'meta_type' => 'single',
			'field' => 'document_meta',
			'child' => array(
				'ref' => array(
					'type' => 'string',
					'description' => 'La référence du document, correspond à celui de l\'accident',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'raisonSociale' => array(
					'type' => 'string',
					'description' => 'La raison sociale de la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'adresse' => array(
					'type' => 'string',
					'description' => 'L\'adresse de la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'telephone' => array(
					'type' => 'string',
					'description' => 'Le numéro de téléphone de la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'siret' => array(
					'type' => 'string',
					'description' => 'Le numéro de SIRET de la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'email' => array(
					'type' => 'string',
					'description' => 'L\'adresse email de la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'effectif' => array(
					'type' => 'string',
					'description' => 'Le nombre d\'employé dans la société',
					'since' => '6.3.0',
					'version' => '6.3.0',
				),
				'accidentDebut' => array(
					'type' => 'array',
					'child' => array(
						'ref' => array(
							'type' => 'string',
							'description' => 'Référence de l\'accident',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'dateInscriptionRegistre' => array(
							'type' => 'string',
							'description' => 'La date d\'inscription de l\'accident dans le registre',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'nomPrenomMatriculeVictime' => array(
							'type' => 'string',
							'description' => 'Nom, Prénom et matricule interne de la victime',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'dateHeure' => array(
							'type' => 'string',
							'description' => 'Date et heure de l\'accident',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'lieu' => array(
							'type' => 'string',
							'description' => 'Lieu de l\'accident',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'circonstances' => array(
							'type' => 'string',
							'description' => 'Circonstance de l\'accident',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'siegeLesions' => array(
							'type' => 'string',
							'description' => 'Siège des lésions',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
					),
				),
				'accidentFin' => array(
					'type' => 'array',
					'child' => array(
						'ref' => array(
							'type' => 'string',
							'description' => 'Référence de l\'accident (Affiché dans le deuxième tableau)',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'natureLesions' => array(
							'type' => 'string',
							'description' => 'Nature des lésions',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'nomAdresseTemoins' => array(
							'type' => 'string',
							'description' => 'Nom et adresse des témoins',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'nomAdresseTiers' => array(
							'type' => 'string',
							'description' => 'Nom et adresse des tiers impliqués extérieurs à l\'établissement',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'signatureDonneurSoins' => array(
							'type' => 'string',
							'description' => 'Nom et signature du donneur de soins',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'signatureVictime' => array(
							'type' => 'string',
							'description' => 'Signature de la victime',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
						'observations' => array(
							'type' => 'string',
							'description' => 'Observations',
							'since' => '6.3.0',
							'version' => '6.3.0',
						),
					),
				),
			),
		);

		parent::__construct( $object );
	}

}
