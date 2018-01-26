<?php
/**
 * Définition du schéma des recommandations
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
 * Définition du schéma des recommandations
 */
class Recommendation_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des recommandations
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['unique_key'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'default'   => '',
		);

		$this->schema['recommendation_type'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['efficiency'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['image'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['taxonomy'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['taxonomy']['child']['digi-recommendation'] = array(
			'meta_type'  => 'multiple',
			'type'       => 'array',
			'array_type' => 'int',
		);

		$this->schema['taxonomy']['child']['digi-recommendation-category'] = array(
			'meta_type'  => 'multiple',
			'type'       => 'array',
			'array_type' => 'int',
		);

		parent::__construct( $data, $req_method );
	}

}
