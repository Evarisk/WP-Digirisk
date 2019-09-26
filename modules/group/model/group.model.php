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
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['owner_id'] = array(
			'since'       => '6.4.0',
			'version'     => '6.4.0',
			'description' => 'L\'ID responsable de la société',
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_digi_owner_id',
			'default'     => 0,
		);

		$this->schema['user_info']['child']['owner_id'] = array(
			'since'       => '6.0.0',
			'version'     => '6.0.0',
			'description' => 'old storage',
			'type'        => 'integer',
			'meta_type'   => 'multiple',
		);

		$this->schema['user_info']['child']['affected_id'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['identity'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['identity']['child']['workforce'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['siren'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['siret'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['social_activity_number'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'integer',
			'meta_type' => 'multiple',
		);

		$this->schema['identity']['child']['establishment_date'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
