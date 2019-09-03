<?php
/**
 * Définition du schéma des méthodes d'évaluation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
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

		$this->schema['thumbnail_id'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['is_default'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'boolean',
			'meta_type' => 'multiple',
		);

		$this->schema['formula'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['matrix'] = array(
			'since'      => '6.0.0',
			'version'    => '6.5.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
