<?php
/**
 * Définition du schéma des groupements.
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
 * Définition du schéma des groupements.
 */
class Group_Model extends Society_Model {

	/**
	 * Définition du schéma des groupements.
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['user_info'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['user_info']['child']['owner_id'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['user_info']['child']['affected_id'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['identity'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['identity']['child']['workforce'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['siren'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['siret'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['social_activity_number'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['establishment_date'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->model['owner_id'] = array(
			'description' => 'L\'ID responsable de la société',
			'since'       => '6.4.0',
			'version'     => '6.4.0',
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_digi_owner_id',
		);

		parent::__construct( $data, $req_method );
	}

}
