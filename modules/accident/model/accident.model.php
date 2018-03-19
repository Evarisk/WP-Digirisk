<?php
/**
 * Définition des champs d'un accident.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un accident.
 */
class Accident_Model extends \eoxia\Post_Model {

	/**
	 * Définition des champs d'un accident
	 *
	 * @since 6.3.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['unique_key'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'default'   => '',
		);

		$this->schema['accident_date'] = array(
			'since'     => '6.3.0',
			'version'   => '6.5.0',
			'type'      => 'wpeo_date',
			'context'   => array( 'GET' ),
			'meta_type' => 'single',
			'field'     => '_wpdigi_accident_date',
		);

		$this->schema['victim_identity_id'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_victim_identity_id',
		);

		$this->schema['registration_date_in_register'] = array(
			'since'     => '6.3.0',
			'version'   => '6.5.0',
			'type'      => 'wpeo_date',
			'context'   => array( 'GET' ),
			'meta_type' => 'single',
			'field'     => '_wpdigi_registration_date_in_register',
		);

		$this->schema['location_of_lesions'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['nature_of_lesions'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['name_and_address_of_witnesses'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['name_and_address_of_third_parties_involved'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['observation'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['compiled_stopping_days'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_compiled_stopping_days',
		);

		$this->schema['have_investigation'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'boolean',
			'meta_type' => 'single',
			'field'     => '_wpdigi_have_investigation',
			'default'   => false,
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['signature_of_the_caregiver_id'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['signature_of_the_victim_id'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['accident_investigation_id'] = array(
			'since'     => '6.3.0',
			'version'   => '6.3.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
