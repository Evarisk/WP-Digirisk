<?php
/**
 * Définition du schéma des méthodes d'évaluation.
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
 * Définition du schéma des méthodes d'évaluation.
 */
class Evaluation_Method_Model extends \eoxia\Term_Model {

	/**
	 * Définition du schéma des méthodes d'évaluation.
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {

		$this->schema['unique_key'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['thumbnail_id'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['is_default'] = array(
			'type'      => 'boolean',
			'meta_type' => 'multiple',
		);

		$this->schema['formula'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['matrix'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
