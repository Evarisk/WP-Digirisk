<?php
/**
 * Définition du schéma des sociétés.
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
 *  Définition du schéma des sociétés.
 */
class Society_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des sociétés.
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {

		$this->schema['associated_document_id'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['image'] = array(
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		/**
		 * La clé unique.
		 */
		$this->schema['unique_key'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
			'since'     => '6.0.0',
			'version'   => '6.5.0',
		);

		/**
		 * L'identifiant unique.
		 */
		$this->schema['unique_identifier'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'default'   => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		/**
		 * L'identifiant unique.
		 */
		$this->schema['modified_unique_identifier'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		/**
		 * Les recommendations associées
		 *
		 * @todo: 23/01/2018 -> Est ce utilisé ?
		 */
		$this->schema['associated_recommendation'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['siret_id'] = array(
			'description' => 'Le SIRET de la société.',
			'since'       => '6.3.0',
			'version'     => '6.3.0',
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_wpdigi_siret_id',
			'default'     => '',
		);

		$this->schema['number_of_employees'] = array(
			'description' => 'Le nombre d\'employée dans la société.',
			'since'       => '6.3.0',
			'version'     => '6.5.0',
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_wpdigi_number_of_employees',
			'default'     => 0,
		);

		$this->schema['contact'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['contact']['child']['phone'] = array(
			'type'       => 'array',
			'array_type' => 'string',
			'meta_type'  => 'multiple',
		);

		$this->schema['contact']['child']['email'] = array(
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['contact']['child']['address_id'] = array(
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
			'default'    => array( 0 ),
		);

		$this->schema['owner_id'] = array(
			'description' => 'L\'ID responsable de la société',
			'since'       => '6.4.0',
			'version'     => '6.4.0',
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_digi_owner_id',
			'default'     => 0,
		);

		parent::__construct( $data, $req_method );
	}

}
