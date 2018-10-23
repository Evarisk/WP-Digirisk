<?php
/**
 * Définition des champs d'un ODT d'accident de travail bénins.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un ODT d'accident de travail bénins.
 */
class Accident_Travail_Benin_Model extends Document_Model {

	/**
	 * Définition des champs d'un ODT d'accident de travail bénins.
	 *
	 * @since 6.3.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['document_meta'] = array(
			'since'     => '6.3.0',
			'version'   => '6.5.0',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(
				'ref' => array(
					'type' => 'string',
				),
				'raisonSociale' => array(
					'type' => 'string',
				),
				'siret' => array(
					'type' => 'string',
				),
				'adresse' => array(
					'type' => 'string',
				),
				'email' => array(
					'type' => 'string',
				),
				'telephone' => array(
					'type' => 'string',
				),
				'effectif' => array(
					'type' => 'integer',
				),
				'dateInscriptionRegistre' => array(
					'type' => 'string',
				),
				'nomPrenomMatriculeVictime' => array(
					'type' => 'string',
				),
				'dateHeure' => array(
					'type' => 'string',
				),
				'lieu' => array(
					'type' => 'string',
				),
				'circonstances' => array(
					'type' => 'string',
				),
				'siegeLesions' => array(
					'type' => 'string',
				),
				'natureLesions' => array(
					'type' => 'string',
				),
				'nomAdresseTemoins' => array(
					'type' => 'string',
				),
				'nomAdresseTiers' => array(
					'type' => 'string',
				),
				'signatureDonneurSoins' => array(
					'type' => 'array',
				),
				'signatureVictime' => array(
					'type' => 'array',
				),
				'observations' => array(
					'type' => 'string',
				),
				'enqueteAccident' => array(
					'type' => 'string',
				),
			),
		);

		parent::__construct( $data, $req_method );
	}

}
