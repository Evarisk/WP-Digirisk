<?php
/**
 * Définition du schéma des recommandations
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
 * Définition du schéma des recommandations
 */
class Recommendation_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des recommandations
	 *
	 * @since 6.1.5
	 * @version 6.1.5
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

		$this->schema['recommendation_type'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['efficiency'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['image'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['taxonomy'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['taxonomy']['child']['digi-recommendation'] = array(
			'since'      => '6.1.5',
			'version'    => '6.1.5',
			'meta_type'  => 'multiple',
			'type'       => 'array',
			'array_type' => 'int',
		);

		$this->schema['taxonomy']['child']['digi-recommendation-category'] = array(
			'since'      => '6.1.5',
			'version'    => '6.1.5',
			'meta_type'  => 'multiple',
			'type'       => 'array',
			'array_type' => 'int',
		);

		parent::__construct( $data, $req_method );
	}

}
