<?php
/**
 * Définition du schéma des évalutions de risque
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
 * Définition du schéma des évalutions de risque
 */
class Risk_Evaluation_Model extends \eoxia\Comment_Model {

	/**
	 * Définition du schéma des évalutions de risque
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['risk_level'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['risk_level']['child']['method_result'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
			'required'  => true,
		);

		$this->schema['risk_level']['child']['equivalence'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
			'required'  => true,
		);

		$this->schema['quotation_detail'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['equivalence'] = array(
			'type'      => 'integer',
			'field'     => '_wpdigi_risk_evaluation_equivalence',
			'meta_type' => 'single',
			'default'   => 0,
		);

		$this->schema['scale'] = array(
			'type'      => 'integer',
			'field'     => '_wpdigi_risk_evaluation_scale',
			'meta_type' => 'single',
			'default'   => -1,
			'required'  => true,
		);

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

		parent::__construct( $data, $req_method );
	}

}
