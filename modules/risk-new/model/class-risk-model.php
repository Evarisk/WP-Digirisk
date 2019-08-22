<?php
/**
 * Définition du schéma des risques
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
 * Définition du schéma des risques
 */
class Risk_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des risques
	 *
	 * @since 6.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {

		$this->schema['associated_recommendation'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['risk_date'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['unique_key'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
		);

		$this->schema['current_equivalence'] = array(
			'since'     => '6.0.0',
			'version'   => '6.5.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_equivalence',
			'default'   => -1,
		);

		$this->schema['current_evaluation_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.5.0',
			'type'       => 'integer',
			'meta_type'  => 'multiple',
			'default'    => 0,
			'deprecated' => '>= 6.5.0',
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['image'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['taxonomy'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['taxonomy']['child']['digi-category-risk'] = array(
			'since'      => '6.0.0',
			'version'    => '6.5.0',
			'meta_type'  => 'multiple',
			'array_type' => 'integer',
			'type'       => 'array',
		);

		$this->schema['taxonomy']['child']['digi-method'] = array(
			'since'      => '6.0.0',
			'version'    => '6.5.0',
			'meta_type'  => 'multiple',
			'array_type' => 'integer',
			'type'       => 'array',
		);

		$this->schema['preset'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'boolean',
			'meta_type' => 'single',
			'field'     => '_wpdigi_preset',
			'default'   => false,
		);

		parent::__construct( $data, $req_method );
	}

}
